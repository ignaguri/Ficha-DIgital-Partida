<?php

require_once 'Mysql.php';

class Membership {

    function validate_user($dni, $pwd) {
        $mysql = New Mysql();
        $idRol = $mysql->verify_Username_and_Pass($dni, md5($pwd));

        if ($idRol != null) {
            $_SESSION['status'] = 'authorized';
            $_SESSION['rol'] = $idRol;
            $_SESSION['persona'] = $dni;
            $_SESSION['new_user'] = false;
            $this->redirectUser($idRol);
        } else {
            return "La clave ingresada no es correcta.";
        }
    }

    function validate_newUser($pwd) {
        $mysql = New Mysql();
        $idRol = $mysql->verify_Pass(md5($pwd));

        if ($idRol != null) {
            $_SESSION['status'] = 'authorized';
            $_SESSION['rol'] = $idRol;
            $_SESSION['new_user'] = true;
            $this->redirectUser($idRol);
        } else {
            return "La clave ingresada no es correcta.";
        }
    }

    function redirectUser($idRol) {
        switch ($idRol) {
            case 1:
                header("location: index.php");
                break;
            case 2:
                if($_SESSION['new_user'] == true)
                    header("location: new_user.php");
                else
                    header("location: secre.php");
                break;
            case 3:
                if($_SESSION['new_user'] == true)
                    header("location: new_user.php");
                else
                    header("location: padrino.php");
                break;
            case 4:
                if($_SESSION['new_user'] == true)
                    header("location: new_user.php");
                else
                    header("location: partidista.php");
                break;
            default:
                header("location: login.php");
                break;
        }
    }

    function log_User_Out() {
        if (isset($_SESSION['status'])) {
            unset($_SESSION['status']);
            unset($_SESSION['rol']);

            if (isset($_COOKIE[session_name()]))
                setcookie(session_name(), '', time() - 1000);
            session_destroy();
        }
    }

    function confirm_Member($rolNeeded) {
        session_start();
        if ($_SESSION['status'] != 'authorized' || $_SESSION['rol'] != $rolNeeded)
            header("location: login.php");
    }

}
