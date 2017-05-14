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

    #TODO: falta eliminar la clave despues de usarla
    function verify_Pass($pwd)
    {
        $query = "SELECT idRol
				FROM claves cl
				WHERE cl.clave = ?
				LIMIT 1";

        if ($stmt = $this->conn->prepare($query)) {
            $stmt->bind_param('s', $pwd);
            $stmt->execute();
            $stmt->bind_result($idRol);

            if ($stmt->fetch()) {
                $stmt->close();
                unset($conn);
                return $idRol;
            } else {
                unset($conn);
                return null;
            }
        }

    }

    function verify_Username_and_Pass($dni, $pwd)
    {

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
                unset($conn);
                return $idRol;
            } else {
                unset($conn);
                return null;
            }
        }

    }

    #TODO: hacerlo transaccion
    function insert_persona_full($datos, $rol)
    {
        $flag = false;
       try {
            $query = "INSERT INTO personas (dni, apellido, nombre, fechaNacimiento, mail, celular, partidaHecha, sexo, password, domicilio)
                    VALUES (?,?,?,?,?,?,?,?,?,?)";
            if ($stmt = $this->conn->prepare($query)) {
                $fecha_parsed = date_create($datos['fechaNacimiento'])->format('Y-m-d');
                $pwd_md5 = md5($datos['password']);
                $sexo = $datos['sexo'] = 0 ? 'M' : 'H';
                $stmt->bind_param('issssiisss', $datos['dni'], $datos['apellido'], $datos['nombre'], $fecha_parsed,
                    $datos['mail'], $datos['celular'], $datos['partidaHecha'], $sexo,
                    $pwd_md5, $datos['domicilio']);

                $stmt->execute();
                if ($stmt->affected_rows > 0){
                   // echo 'Exito!';
                    $flag = true;
                }
                else {
                    echo $stmt->error;
                    $flag = false;
                }
            }
            $query2 = "INSERT INTO rolxuser (idRol, dni)
                        VALUES (?, ?)";
            if ($stmt2 = $this->conn->prepare($query2)) {
                $stmt2->bind_param('ii', $rol, $datos['dni']);
                $stmt2->execute();
                if ($stmt2->affected_rows > 0){
                   // echo 'Exito!';
                    $flag = true;
                }
                else {
                    echo $stmt2->error;
                    $flag = false;
                }
            }
            unset($conn);
        } catch (Exception $e) {
            echo "ERROR: No se pudo agregar a la persona" . $e->getMessage();
            unset($conn);
            $flag = false;
        }
        return $flag;
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
                    unset($conn);
                    return true;
                } else {
                    unset($conn);
                    return false;
                }
            } else
                echo $this->conn->error, ' asi es';
        } catch (Exception $e) {
            echo "Error " . $e->getMessage();
            unset($conn);
            return false;
        }
    }

    function insert_secre($dni, $comentario)
    {
        $query = "INSERT INTO secretariado(dni, comentarios)
                  VALUES (:dni, :comentario)";
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param(':dni', $dni);
            $stmt->bind_param(':comentario', $comentario);

            $stmt->execute();
        } catch (Exception $e) {
            echo "ERROR: No se pudo agregar a la persona" . $e->getMessage();
            return false;
        }
        unset($conn);
        return true;
    }

    function insert_padrino($rtas)
    {
        $query = "INSERT INTO padrino(`dni`,`prepartida1`,`prepartida2`,`prepartida3`,`prepartida4`,`partida1`,
                    `partida2`,`personalidad1`,`personalidad2`,`ambiente1`,`ambiente2`,`ambiente3`,`ambiente4`,
                    `ambiente5`,`ambiente6`,`ambiente7`,`religiosidad1`,`religiosidad2`)
                  VALUES(:dni ,:prepartida1 ,:prepartida2 ,:prepartida3 ,:prepartida4 ,
                    :partida1 ,:partida2 ,:personalidad1 ,:personalidad2 ,:ambiente1 ,
                    :ambiente2 ,:ambiente3 ,:ambiente4 ,:ambiente5 ,:ambiente6 ,:ambiente7 ,
                    :religiosidad1 ,:religiosidad2 )";

        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param(':dni', $rtas[0]);
            $stmt->bind_param(':prepartida1', $rtas[1]);
            $stmt->bind_param(':prepartida2', $rtas[2]);
            $stmt->bind_param(':prepartida3', $rtas[3]);
            $stmt->bind_param(':prepartida4', $rtas[4]);
            $stmt->bind_param(':partida1', $rtas[5]);
            $stmt->bind_param(':partida2', $rtas[6]);
            $stmt->bind_param(':personalidad1', $rtas[7]);
            $stmt->bind_param(':personalidad2', $rtas[8]);
            $stmt->bind_param(':ambiente1', $rtas[9]);
            $stmt->bind_param(':ambiente2', $rtas[10]);
            $stmt->bind_param(':ambiente3', $rtas[11]);
            $stmt->bind_param(':ambiente4', $rtas[12]);
            $stmt->bind_param(':ambiente5', $rtas[13]);
            $stmt->bind_param(':ambiente6', $rtas[14]);
            $stmt->bind_param(':ambiente7', $rtas[15]);
            $stmt->bind_param(':religiosidad1', $rtas[16]);
            $stmt->bind_param(':religiosidad2', $rtas[17]);


            $stmt->execute();
        } catch (Exception $e) {
            echo "ERROR: No se pudo agregar a la persona" . $e->getMessage();
            return false;
        }
        unset($conn);
        return true;
    }

    function insert_partidista($rtas)
    {
        $query = "INSERT INTO partidista (`dni`,`apodo`,`facultad`,`serv_emergencia`,`aspecto_personal1`,
                    `aspecto_personal2`,`aspecto_personal3`,`aspecto_personal4`,`aspecto_personal5`,
                    `relacion_con_demas1`,`relacion_con_demas2`,`relacion_con_demas3`,`relacion_con_demas4`,
                    `relacion_con_demas5`,`relacion_con_demas6`,`relacion_con_dios1`,`relacion_con_dios2`,
                    `relacion_con_dios3`,`relacion_con_dios4`,`relacion_con_dios5`,`relacion_con_dios6`,
                    `relacion_con_dios7`)
                  VALUES ( :dni , :apodo , :facultad , :serv_emergencia , :aspecto_personal1 ,
                     :aspecto_personal2 , :aspecto_personal3 , :aspecto_personal4 , :aspecto_personal5 ,
                     :relacion_con_demas1 , :relacion_con_demas2 , :relacion_con_demas3 , :relacion_con_demas4 ,
                     :relacion_con_demas5 , :relacion_con_demas6 , :relacion_con_dios1 , :relacion_con_dios2 ,
                     :relacion_con_dios3 , :relacion_con_dios4 , :relacion_con_dios5 , :relacion_con_dios6 , :relacion_con_dios7 )";

        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param(':dni', $rtas[0]);
            $stmt->bind_param(':apodo', $rtas[1]);
            $stmt->bind_param(':facultad', $rtas[2]);
            $stmt->bind_param(':serv_emergencia', $rtas[3]);
            $stmt->bind_param(':aspecto_personal1', $rtas[4]);
            $stmt->bind_param(':aspecto_personal2', $rtas[5]);
            $stmt->bind_param(':aspecto_personal3', $rtas[6]);
            $stmt->bind_param(':aspecto_personal4', $rtas[7]);
            $stmt->bind_param(':aspecto_personal5', $rtas[8]);
            $stmt->bind_param(':relacion_con_demas1', $rtas[9]);
            $stmt->bind_param(':relacion_con_demas2', $rtas[10]);
            $stmt->bind_param(':relacion_con_demas3', $rtas[11]);
            $stmt->bind_param(':relacion_con_demas4', $rtas[12]);
            $stmt->bind_param(':relacion_con_demas5', $rtas[13]);
            $stmt->bind_param(':relacion_con_demas6', $rtas[14]);
            $stmt->bind_param(':relacion_con_dios1', $rtas[15]);
            $stmt->bind_param(':relacion_con_dios2', $rtas[16]);
            $stmt->bind_param(':relacion_con_dios3', $rtas[17]);
            $stmt->bind_param(':relacion_con_dios4', $rtas[18]);
            $stmt->bind_param(':relacion_con_dios5', $rtas[19]);
            $stmt->bind_param(':relacion_con_dios6', $rtas[20]);
            $stmt->bind_param(':relacion_con_dios7', $rtas[21]);

            $stmt->execute();
        } catch (Exception $e) {
            echo "ERROR: No se pudo agregar a la persona" . $e->getMessage();
            return false;
        }
        unset($conn);
        return true;
    }

    #testing purposes
    function read_persona($dni)
    {
        $query = "SELECT *
				FROM personas p
				WHERE p.dni = ?";

        if ($stmt = $this->conn->prepare($query)) {
            $stmt->bind_param('s', $dni);
            $stmt->execute();
            $stmt->bind_result($persona);

            if ($stmt->fetch()) {
                $stmt->close();
                unset($conn);
                return $persona;
            } else {
                unset($conn);
                return null;
            }
        }
    }
}