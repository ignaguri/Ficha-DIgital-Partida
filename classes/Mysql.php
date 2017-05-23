<?php

require_once 'constants.php';

class Mysql
{
    private $conn;

    function __construct()
    {
        try {
            $this->conn = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);
        } catch (Exception $e) {
            echo 'Error: ', $e->getMessage();
        }
    }

    function reconnect()
    {
        try {
            $this->conn = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);
        } catch (Exception $e) {
            echo 'Error: ', $e->getMessage();
        }
    }

    function purgar()
    {
        do {
            if ($res = $this->conn->store_result()) {
                $res->fetch_all(MYSQLI_ASSOC);
                $res->free();
            }
        } while ($this->conn->more_results() && $this->conn->next_result());
    }

    function verify_Pass($pwd)
    {
        $query1 = "SELECT idRol
				FROM claves cl
				WHERE cl.clave = ?
				LIMIT 1";

        $query2 = "DELETE FROM claves
                   WHERE clave = ?";

        try {
            mysqli_autocommit($this->conn, false);

            if (!$stmt1 = $this->conn->prepare($query1)) {
                print_r($this->conn->error);
                return false;
            }
            if (!$stmt2 = $this->conn->prepare($query2)) {
                print_r($this->conn->error);
                return false;
            }
            $stmt1->bind_param('s', $pwd);
            $stmt2->bind_param('s', $pwd);

            if ($stmt1->execute()) {
                $stmt1->store_result();
                $stmt1->bind_result($idRol);
                $stmt1->fetch();
                $stmt1->free_result();
            } else {
                print_r($this->conn->error);
                return false;
            }
            if (!$stmt2->execute()) {
                print_r($this->conn->error);
                return false;
            }

            mysqli_commit($this->conn);
            $stmt1->close();
            $stmt2->close();
            $this->purgar();
            $this->conn->close();

            return $idRol;
        } catch (Exception $e) {
            mysqli_rollback($this->conn);
            $this->conn->close();
            return null;
        }

    }

    function verify_Username_and_Pass($dni, $pwd)
    {
        #TODO: permitir mas de un rol por persona
        $query = "SELECT idRol
				FROM rolxuser rxu JOIN personas p ON rxu.dni = p.dni
				WHERE p.dni = ? AND p.password = ?
				LIMIT 1";

        if ($stmt = $this->conn->prepare($query)) {
            $stmt->bind_param('ss', $dni, $pwd);
            $stmt->execute();
            $stmt->bind_result($idRol);

            if ($stmt->fetch()) {
                $stmt->close();
                $this->purgar();
                $this->conn->close();
                return $idRol;
            } else {
                $this->conn->close();
                return null;
            }
        }

    }

    #TODO: hacerlo transaccion
    function insert_persona_full($datos, $rol, $foto_path)
    {
        #para Partidista
        if ($rol == 4) {
            try {
                $query0 = "SELECT fechaNacimiento
                          FROM personas
                           WHERE dni = ?";
                if ($stmt0 = $this->conn->prepare($query0)) {
                    $stmt0->bind_param('i', $datos['dni']);
                    $stmt0->execute();
                    if ($stmt0->num_rows > 0) {
                        throwException('Error. Persona ya registrada');
                    } else {
                        $stmt0->close();
                        $this->purgar();
                        $query = "UPDATE personas
                                  SET apellido=?, nombre=?, fechaNacimiento=?,
                                   mail=?, celular=?, partidaHecha=?, sexo=?, password=?, domicilio=?, foto_carnet=?
                                  WHERE dni = ?";
                        if ($stmt = $this->conn->prepare($query)) {
                            $fecha_parsed = date_create($datos['fechaNacimiento'])->format('Y-m-d');
                            $pwd_md5 = md5($datos['password']);
                            $sexo = $datos['sexo'] == 0 ? 'M' : 'H';
                            $partida = $datos['partidaHecha'] == null ? null : $datos['partidaHecha'];
                            $stmt->bind_param('ssssiissssi', $datos['apellido'], $datos['nombre'], $fecha_parsed,
                                $datos['mail'], $datos['celular'], $partida, $sexo,
                                $pwd_md5, $datos['domicilio'],$foto_path, $datos['dni']);

                            $stmt->execute();
                            if ($stmt->affected_rows >= 0) {
                                $flag = true;
                            } else {
                                echo $stmt->error;
                                $flag = false;
                            }
                        }
                        #check. es omisible
                        $query2 = "SELECT dni
                                    FROM rolxuser
                                    WHERE dni= ? AND idRol = ?
                                    LIMIT 1";
                        $stmt->close();
                        $this->purgar();
                        $this->conn->next_result();
                        if ($stmt2 = $this->conn->prepare($query2)) {
                            $stmt2->bind_param('ii', $datos['dni'], $rol);
                            $stmt2->execute();
                            if ($stmt2->get_result()) {
                                $flag = true;
                            } else {
                                echo $stmt2->error;
                                $flag = false;
                            }
                        }
                        $stmt2->close();
                        $this->purgar();
                        $this->conn->close();
                    }
                }
            } catch (Exception $e) {
                echo "ERROR: No se pudo agregar a la persona" . $e->getMessage();
                $this->conn->close();
                $flag = false;
            }
        } else {
            try {
                $query = "INSERT INTO personas (dni, apellido, nombre, fechaNacimiento, mail, celular, partidaHecha, sexo, domicilio, foto_carnet, password)
                    VALUES (?,?,?,?,?,?,?,?,?,?)";
                $query2 = "INSERT INTO rolxuser (idRol, dni)
                        VALUES (?, ?)";

                mysqli_autocommit($this->conn, false);

                if (!$stmt1 = $this->conn->prepare($query)) {
                    print_r($this->conn->error);
                    return false;
                }
                if (!$stmt2 = $this->conn->prepare($query2)) {
                    print_r($this->conn->error);
                    return false;
                }

                $fecha_parsed = date_create($datos['fechaNacimiento'])->format('Y-m-d');
                $pwd_md5 = md5($datos['password']);
                $sexo = $datos['sexo'] = 0 ? 'M' : 'H';
                $stmt1->bind_param('issssiissss', $datos['dni'], $datos['apellido'], $datos['nombre'], $fecha_parsed,
                    $datos['mail'], $datos['celular'], $datos['partidaHecha'], $sexo,
                    $datos['domicilio'], $foto_path, $pwd_md5);

                $stmt2->bind_param('ii', $rol, $datos['dni']);

                if (!$stmt1->execute() || $stmt1->affected_rows < 1) {
                    print_r($this->conn->error);
                    return false;
                }
                if (!$stmt2->execute() || $stmt2->affected_rows < 1) {
                    print_r($this->conn->error);
                    return false;
                }

                mysqli_commit($this->conn);
                $stmt1->close();
                $stmt2->close();
                $this->purgar();
                $this->conn->close();

                return true;
                /*if ($stmt = $this->conn->prepare($query)) {
                    $fecha_parsed = date_create($datos['fechaNacimiento'])->format('Y-m-d');
                    $pwd_md5 = md5($datos['password']);
                    $sexo = $datos['sexo'] = 0 ? 'M' : 'H';
                    $stmt->bind_param('issssiissss', $datos['dni'], $datos['apellido'], $datos['nombre'], $fecha_parsed,
                        $datos['mail'], $datos['celular'], $datos['partidaHecha'], $sexo,
                        $datos['domicilio'], $foto_path, $pwd_md5);

                    $stmt->execute();
                    if ($stmt->affected_rows > 0) {
                        // echo 'Exito!';
                        $flag = true;
                    } else {
                        echo $stmt->error;
                        $flag = false;
                    }
                }

                if ($stmt2 = $this->conn->prepare($query2)) {
                    $stmt2->bind_param('ii', $rol, $datos['dni']);
                    $stmt2->execute();
                    if ($stmt2->affected_rows > 0) {
                        // echo 'Exito!';
                        $flag = true;
                    } else {
                        echo $stmt2->error;
                        $flag = false;
                    }
                }
                $this->conn->close();*/
            } catch (Exception $e) {
                echo "ERROR: No se pudo agregar a la persona" . $e->getMessage();
                mysqli_rollback($this->conn);
                $this->conn->close();
                return false;
            }
        }
    }

    function check_partida($nro, $sexo)
    {
        $query = "SELECT 1
                  FROM partidas p
                  WHERE p.nro = ?
                  AND p.sexo = ?";
        try {
            if ($stmt = $this->conn->prepare($query)) {
                $stmt->bind_param('is', $nro, $sexo);
                $stmt->execute();
                //$stmt->bind_result($result);

                if ($stmt->get_result()) {
                    $this->conn->close();
                    return true;
                } else {
                    $this->conn->close();
                    return false;
                }
            } else
                echo $this->conn->error, ' asi es';
        } catch (Exception $e) {
            echo "Error " . $e->getMessage();
            $this->conn->close();
            return false;
        }
    }

    function insert_secre($dni, $comentario)
    {
        $query = "INSERT INTO secretariado(dni, comentarios)
                  VALUES (?,?)";
        try {
            if (!$stmt = $this->conn->prepare($query))
                print_r($this->conn->error);
            $stmt->bind_param('is', $dni, $comentario);
            if (!$stmt->execute())
                print_r($this->conn->error);
            if ($stmt->affected_rows < 1) {
                print_r($this->conn->error);
                throwException("No se insertó ninguna row");
            }
            echo '<script>alert("Secre insertado");</script>';
            $this->conn->close();
            return true;
        } catch (Exception $e) {
            echo "ERROR: No se pudo agregar a la persona" . $e->getMessage();
            return false;
        }
    }

    function insert_padrino($rtas)
    {
        try {
            $query1 = "INSERT INTO personas(dni, apellido, nombre)
                       VALUES (?, ?, ?)";

            $query2 = "INSERT INTO padrino(dni,dniAhijado,prepartida1,prepartida2,prepartida3,prepartida4,partida1,
                    partida2,personalidad1,personalidad2,ambiente1,ambiente2,ambiente3,ambiente4,
                    ambiente5,ambiente6,ambiente7,religiosidad1,religiosidad2)
                  VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

            $query3 = "INSERT INTO rolxuser(idRol, dni)
                       VALUES (4, ?)";


            mysqli_autocommit($this->conn, false);

            if (!$stmt1 = $this->conn->prepare($query1)) {
                print_r($this->conn->error);
                return false;
            }
            if (!$stmt2 = $this->conn->prepare($query2)) {
                print_r($this->conn->error);
                return false;
            }
            if (!$stmt3 = $this->conn->prepare($query3)) {
                print_r($this->conn->error);
                return false;
            }

            $stmt1->bind_param('iss', $rtas['dni_ahijado'], $rtas['apellidoAhijado'], $rtas['nombreAhijado']);

            $stmt2->bind_param('iisssssssssssssssss', $rtas['dni'], $rtas['dni_ahijado'], $rtas['prepartida1'],
                $rtas['prepartida2'], $rtas['prepartida3'], $rtas['prepartida4'], $rtas['partida1'], $rtas['partida2'],
                $rtas['personalidad1'], $rtas['personalidad2'], $rtas['ambiente1'], $rtas['ambiente2'], $rtas['ambiente3'],
                $rtas['ambiente4'], $rtas['ambiente5'], $rtas['ambiente6'], $rtas['ambiente7'],
                $rtas['religiosidad1'], $rtas['religiosidad2']);

            $stmt3->bind_param('i', $rtas['dni_ahijado']);

            if (!$stmt1->execute() || $stmt1->affected_rows < 1) {
                print_r($this->conn->error);
                return false;
            }
            if (!$stmt2->execute() || $stmt2->affected_rows < 1) {
                print_r($this->conn->error);
                return false;
            }
            if (!$stmt3->execute() || $stmt3->affected_rows < 1) {
                print_r($this->conn->error);
                return false;
            }

            mysqli_commit($this->conn);
            $stmt1->close();
            $stmt2->close();
            $this->purgar();
            $this->conn->close();

            return true;
        } catch (Exception $e) {
            mysqli_rollback($this->conn);
            $this->conn->close();
            return false;
        }
    }

    function insert_partidista($rtas)
    {
        $query = "INSERT INTO partidista (dni,apodo,facultad,serv_emergencia,aspecto_personal1,
                    aspecto_personal2,aspecto_personal3,aspecto_personal4,aspecto_personal5,
                    relacion_con_demas1,relacion_con_demas2,relacion_con_demas3,relacion_con_demas4,
                    relacion_con_demas5,relacion_con_demas6,relacion_con_dios1,relacion_con_dios2,
                    relacion_con_dios3,relacion_con_dios4,relacion_con_dios5,relacion_con_dios6,
                    relacion_con_dios7)
                  VALUES ( ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,? )";

        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('isssssssssssssssssssss', $rtas['dni'], $rtas['apodo'], $rtas['facultad'],
                $rtas['serv_emergencia'], $rtas['aspecto_personal1'], $rtas['aspecto_personal2'],
                $rtas['aspecto_personal3'], $rtas['aspecto_personal4'], $rtas['aspecto_personal5'],
                $rtas['relacion_con_demas1'], $rtas['relacion_con_demas2'], $rtas['relacion_con_demas3'],
                $rtas['relacion_con_demas4'], $rtas['relacion_con_demas5'], $rtas['relacion_con_demas6'],
                $rtas['relacion_con_dios1'], $rtas['relacion_con_dios2'], $rtas['relacion_con_dios3'],
                $rtas['relacion_con_dios4'], $rtas['relacion_con_dios5'], $rtas['relacion_con_dios6'], $rtas['relacion_con_dios7']);

            $stmt->execute();
            if ($stmt->affected_rows > 0) {
                $this->conn->close();
                return true;
            }
        } catch (Exception $e) {
            echo "ERROR: No se pudo agregar a la persona" . $e->getMessage();
            return false;
        }
        $this->conn->close();
        return false;
    }

    function read_persona($dni)
    {
        $this->reconnect();
        $query = "SELECT dni, apellido, nombre
				FROM personas
				WHERE dni = $dni";

        if ($res = $this->conn->query($query)) {
            $persona = $res->fetch_row();
            $this->purgar();
            $this->conn->close();
            return $persona;
        } else {
            $this->conn->close();
            return null;
        }

    }

    function getDniPadrino($dniAhijado)
    {
        $this->reconnect();
        $query = "SELECT dni
				FROM padrino
				WHERE dniAhijado = $dniAhijado";

        if ($res = $this->conn->query($query)) {
            $dniPadrino = $res->fetch_row();
            $this->purgar();
            $this->conn->close();
            return $dniPadrino[0];
        } else {
            $this->conn->close();
            return null;
        }
    }

    function datosCompletos($dni, $idRol)
    {
        $this->reconnect();
        switch ($idRol) {
            case 1:
                return true;
                break;
            case 2:
                $tabla = 'secretariado';
                $cantIdeal = 2;
                break;
            case 3:
                $tabla = 'padrino';
                $cantIdeal = 19;
                break;
            case 4:
                $tabla = 'partidista';
                $cantIdeal = 22;
                break;
            default:
                break;
        }

        $query = "SELECT * FROM $tabla WHERE dni = ?";
        if ($stmt = $this->conn->prepare($query)) {
            $stmt->bind_param('i', $dni);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0 && $result->field_count == $cantIdeal) {
                $stmt->close();
                $this->purgar();
                $this->conn->close();
                return true;
            } else {
                $this->conn->close();
                return false;
            }
        }
    }

    function uploadFotoCarnet($dni, $target_file){
        $query = "UPDATE personas
                  SET foto_carnet = ?
                  WHERE dni= ?";
        try {
            if (!$stmt = $this->conn->prepare($query))
                print_r($this->conn->error);
            $stmt->bind_param('si', $target_file, $dni);
            if (!$stmt->execute())
                print_r($this->conn->error);
            if ($stmt->affected_rows < 1) {
                print_r($this->conn->error);
                throwException("No se insertó ninguna row");
            }
            $this->conn->close();
            return true;
        } catch (Exception $e) {
            echo "ERROR: No se pudo subir la foto" . $e->getMessage();
            return false;
        }
    }
    function uploadFotoDNI($dni, $target_file){
        $query = "UPDATE personas
                  SET foto_dni = ?
                  WHERE dni= ?";
        try {
            if (!$stmt = $this->conn->prepare($query))
                print_r($this->conn->error);
            $stmt->bind_param('si', $target_file, $dni);
            if (!$stmt->execute())
                print_r($this->conn->error);
            if ($stmt->affected_rows < 1) {
                print_r($this->conn->error);
                throwException("No se insertó ninguna row");
            }
            $this->conn->close();
            return true;
        } catch (Exception $e) {
            echo "ERROR: No se pudo subir la foto" . $e->getMessage();
            return false;
        }
    }
}