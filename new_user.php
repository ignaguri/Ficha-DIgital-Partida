<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Primera vez - Ficha digital Partida Cba</title>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        .center_div {
            margin: 0 auto;
            width: 70%
        }
    </style>
    <style type="text/css">
        body {
            background: url(images/logo_partida_small.png) no-repeat fixed;
        }

        label {
            background-color: white;
        }
    </style>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/newuser.js"></script>
</head>
<?php
session_start();
require_once(__DIR__ . '/classes/Membership.php');
require_once(__DIR__ . '/classes/Fn_new_user.php');
require_once(__DIR__ . '/classes/Utils.php');
require_once(__DIR__ . '/classes/PhotoUploader.php');
$membership = new Membership();
$new_user = new new_user();
$utils = new Utils();
$photo_upload = new PhotoUploader();

// If the user clicks the "Log Out" link on the index page.
if (isset($_GET['status']) && $_GET['status'] == 'loggedout') {
    $membership->log_User_Out();
}

if ($_POST) {
    if ($_POST['persona'] == 'persona_full') {
        $datos = $utils->sanitizeData('persona_full', $_POST);
        $inscrito = $new_user->new_persona_full($_SESSION['rol'], $datos, $_FILES['foto']);
        if ($inscrito[0]) {
            echo "<script type=\"text/javascript\">
                 $(document).ready(function(){
                     $('#btn_no').click(function (e) {
                        window.location.href = \"login.php?status=loggedout\";
                    });
                    $('#btn_si').click(function (e) {
                        var rol = {$_SESSION["rol"]};
                        switch (rol){
                            case 2:
                                window.location.href = \"inscr/new_secre.php\";
                                break;
                            case 3:
                                window.location.href = \"inscr/new_padrino.php\";
                                break;
                            case 4:
                                window.location.href = \"inscr/new_partidista.php\";
                                break;
                        }
                    });
                 $('#modal_continuar').modal('show');});
                 </script>";
        } else {
            echo '<script> alert("No se pudieron guardar los datos de la persona.\n"' . $inscrito[1] . '); </script>';
        }
    }
}
?>
<body>
<div class="container-fluid">
    <div class="row center_div" id="holder">
        <div class="col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2" id="form-holder">
            <form id="form_persona" name="form_persona" class="form-horizontal" method="post"
                  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                <input type="hidden" name="persona" value="persona_full">
                <div class="page-header">
                    <h1 style="background-color: white;">Registrarse por primera vez en el sistema</h1>
                    <br/>
                    <h1 style="background-color: white;">
                        <small>Ingresá tus datos personales</small>
                    </h1>
                </div>
                <div class="form-group">
                    <label for="dni">DNI</label>
                    <input type="text" class="form-control" name="dni" id="dni" pattern="\d+" required/>
                    <br class="clear"/>
                </div>
                <div class="form-group">
                    <label for="Foto">Subí una foto tuya de frente (tipo foto carnet)</label>
                    <input id="foto" name="foto" type="file" class="file" multiple=false required/>
                </div>
                <div class="form-group">
                    <label for="apellido">Apellido</label>
                    <input type="text" class="form-control" name="apellido" id="apellido" required/>
                    <br class="clear"/>
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control" name="nombre" id="nombre" required/>
                    <br class="clear"/>
                </div>
                <div class="form-group">
                    <label for="fechaNacimiento">Fecha de nacimiento</label>
                    <input type="date" class="form-control" name="fechaNacimiento" id="fechaNacimiento" required/>
                    <br class="clear"/>
                </div>
                <div class="form-group">
                    <label for="mail">Mail</label>
                    <input type="email" class="form-control" name="mail" id="mail" required/>
                    <br class="clear"/>
                </div>
                <div class="form-group">
                    <label for="celular">Celular</label>
                    <input type="tel" class="form-control" name="celular" id="celular"/>
                    <br class="clear"/>
                </div>
                <?php if (!isset($_SESSION['rol']) or $_SESSION['rol'] == 4)
                echo '<input type="hidden" class="form-control" name="partidaHecha" id="partidaHecha" value="0"/>';
                else
                echo '<div class="form-group">
                    <label for="partidaHecha">Partida hecha</label>
                    <input type="number" class="form-control" name="partidaHecha" id="partidaHecha" required/>
                    <br class="clear"/></div>';
                ?>
                <div class="form-group">
                    <label for="sexo">Sexo</label>
                    <input type="radio" class="radio-inline" name="sexo" value="0" id="sexo_0" required/>Femenino

                    <input type="radio" class="radio-inline" name="sexo" value="1" id="sexo_1" required/>Masculino

                    <br class="clear"/>
                </div>
                <div class="form-group">
                    <label for="domicilio">Domicilio</label>
                    <input type="text" class="form-control" name="domicilio" id="domicilio"/>
                    <br class="clear"/>
                </div>
                <div class="form-group">
                    <label for="password">Clave nueva</label>
                    <input type="password" class="form-control" name="password" id="password"
                           aria-describedby="helpBlock" required/>
                    <span id="helpBlock" class="help-block">La clave que ingresaste ya no tiene validez, debes crear una nueva.
                        <strong>La contraseña tiene que tener 6 caracteres como mínimo</strong></span>
                    <br class="clear"/>
                    <input type="password" class="form-control" name="password2" id="password2"
                           aria-describedby="helpBloc2k" required/>
                    <span id="helpBlock2" class="help-block">Volvé a ingresar la nueva clave</span>
                </div>
                <button type="submit" id="btn_submit" class="btn btn-block btn-success"> Inscribirse
                </button>
            </form>
        </div>
        <div class="modal fade" id="modal_continuar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <!--                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
                        <h4 class="modal-title" id="myModalLabel">¡Registrado!</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h2 class="text-center text-success"><strong>¡Felicitaciones!</strong> Ya estas
                                    registrado en nuestro sistema como usuario común</h2>
                                <div class="alert alert-warning">
                                    <div><strong>Recordá que para ingresar la próxima vez, podés hacerlo con tu DNI y la
                                            clave que configuraste.</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12"><h3 class="text-center">¿Querés responder las preguntas de
                                    inscripción ahora?</h3></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn_no" class="btn btn-danger btn-block" data-dismiss="modal">No,
                            respondo la próxima vez que entre
                        </button>
                        <button type="button" id="btn_si" class="btn btn-success btn-block">Sí, quiero contestar ahora
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<a id="logout" href="login.php?status=loggedout">Salir</a>

</body>
</html>