<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Registrar SECRETARADO - Ficha digital Partida Cba</title>

    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        .center_div {
            margin: 0 auto;
            width: 70%
        }
    </style>
    <style type="text/css">
        body {
            background: url(../images/logo_partida_small.png) no-repeat fixed;
        }
    </style>

    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</head>

<?php
session_start();
require_once '../classes/Membership.php';
require_once '../classes/Fn_new_user.php';
require_once '../classes/Utils.php';
$membership = new Membership();
$new_user = new new_user();
$utils = new Utils();

// If the user clicks the "Log Out" link on the index page.
if (isset($_GET['status']) && $_GET['status'] == 'loggedout') {
    $membership->log_User_Out();
}

if ($_POST && $_POST['persona'] == 'rol_secre') {
    $datos_rol = $utils->sanitizeData('rol_secre', $_POST);
    $flag = $new_user->new_rol_data(2, $datos_rol);

    if ($flag)
        $membership->redirectUser($_SESSION['rol']);
}

?>
<body>
<div class="container-fluid">
    <div class="row center_div" id="holder">
        <div class="col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2" id="form-holder">
            <form id="form_secre" name="form_secre" class="form-horizontal" method="post"
                  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <input type="hidden" name="persona" value="rol_secre">
                <div class="page-header">
                    <h1>Registrarse como <em>secretariado</em></h1>
                    <br />
                    <h1><small>Ingresá tus datos</small></h1>
                </div>
                <div class="form-group">
                    <label class="control-label" for="dni">Tu DNI</label>
                    <input type="text" name="dni" id="dni" class="form-control" placeholder="<?php echo isset($_SESSION['persona'])? $_SESSION['persona']: 'xx.xxx.xxx' ?>" readonly/>
                    <br class="clear"/>
                </div>
                <div class="form-group">
                    <label class="control-label" for="comentarios">Comentarios</label>
                    <textarea class="form-control" name="comentarios" id="comentarios" cols="45" rows="5"></textarea>
                    <br class="clear"/>
                </div>
                <div class="form-group">
                    <button type="submit" id="btn_submit_rol" class="btn btn-block btn-success">Registrar datos</button>
                </div>
            </form>
        </div>
    </div>
</div>

<a id="logout" href="login.php?status=loggedout">Salir</a>

</body>
</html>