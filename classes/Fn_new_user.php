<?php
require_once 'Mysql.php';
date_default_timezone_set('America/Argentina/Cordoba');

class new_user
{

    function new_persona_full($rol, $rtas)
    {
        $_SESSION['new_user'] = false;
        $mysql = New Mysql();
        $valido = $this->validar_datos($rtas);
        if ($valido[0]) {
            $insert = $mysql->insert_persona_full($rtas, $rol);
            if($insert) $_SESSION['persona'] = $rtas['dni'];
            return [$insert, $rol];
        } else {
            return [false, "El campo " . $valido[1] + " no es válido"];
        }
    }

    function validar_datos($datos)
    {
        if (empty($datos['dni']) or !is_int($datos['dni'])) {
            return ([false, 'dni', 0]);
        }
        if (empty($datos['apellido']) or is_null($datos['apellido'])) {
            return ([false, 'apellido', 1]);
        }
        if (empty($datos['nombre']) or is_null($datos['nombre'])) {
            return ([false, 'nombre', 2]);
        }
        if(!empty($datos['fechaNacimiento'])){
            $tempDate = explode('-', $datos['fechaNacimiento']);
            $today = new DateTime();
            $fechaNac = new DateTime($datos['fechaNacimiento']);
            if (!checkdate($tempDate[1], $tempDate[2], $tempDate[0]) and $fechaNac > $today) {
                return ([false, 'fecha de nacimiento', 3]);
            }
        }
        else return ([false, 'fecha de nacimiento', 3]);

        if (empty($datos['mail']) or !filter_var($datos['mail'], FILTER_VALIDATE_EMAIL)) {
            return ([false, 'email', 4]);
        }
        if (empty($datos['celular']) or !is_int($datos['celular'])) {
            return ([false, 'celular', 5]);
        }
        if (empty($datos['sexo']) or is_null($datos['sexo']) and strlen($datos['sexo']) != 1) {
            return ([false, 'sexo', 7]);
        }
        if (empty($datos['partidaHecha']) or !$this->partida_existe($datos['partidaHecha'], $datos['sexo'])) {
            return ([false, 'partida hecha', 6]);
        }
        if (empty($datos['password']) or is_null($datos['password']) and strlen($datos['password']) < 6) { #contraseña de al menos 6 caracteres
            return ([false, 'contraseña', 8]);
        }
        if (empty($datos['domicilio']) or is_null($datos['domicilio'])) {
            return ([false, 'domicilio', 9]);
        }
        return ([true]);
    }
    function partida_existe($nro, $sexo)
    {
        $mysql = New Mysql();
        return $mysql->check_partida($nro, $sexo);
    }

    function new_rol_data($rol, $rtas){
        $flag = false;
        switch ($rol){
            case 2:
                $flag = $this->new_secre($rtas);
                break;
            case 3:
                $flag = $this->new_padrino($rtas);
                break;
            case 4:
                $flag = $this->new_partidista($rtas);
                break;
            default:
                break;
        }
        return $flag;
    }

    function new_secre($datos){
        # $datos[0]: dni, [1]: observaciones
        $mysql = New Mysql();
        if(empty($datos[1]))
            $comment = "Sin observaciones";
        else
            $comment = $datos[1];
        return $mysql->insert_secre($datos[0],$comment);
    }
    function new_padrino($datos){
        #$datos[0]: dni, [1-16]: respuestas
        $mysql = New Mysql();
        foreach ($datos as $rta)
        {
            if (empty($rta))
                return false;
        }
        return $mysql->insert_padrino($datos);
    }
    function new_partidista($datos){
        #$datos[0]: dni, [1]: apodo, [2]: facultad, [3]: servicio de emergencia, [4-21]: respuestas
        $mysql = New Mysql();
        foreach ($datos as $rta)
        {
            if (empty($rta))
                return false;
        }
        return $mysql->insert_partidista($datos);
    }

}