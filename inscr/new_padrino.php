<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Registrar PADRINO - Ficha digital Partida Cba</title>

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
#TODO: fue presentado anteriormente? Aggiornar con el nuevo formulario
if ($_POST && $_POST['persona'] == 'rol_padrino') {

    $datos_rol = $utils->sanitizeData('rol_padrino', $_POST);
    $flag = $new_user->new_rol_data(3, $datos_rol);

    if ($flag)
        $membership->redirectNewUser($_SESSION['rol']);
}

?>
<body>
<div class="container-fluid">
    <div class="row center_div" id="holder">
        <div class="col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2" id="form-holder">
            <form id="form_padrino" name="form_padrino" method="post"
                  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <input type="hidden" name="persona" value="rol_padrino">
                <div class="page-header">
                    <h1>Registrarse como <em>padrino</em></h1>
                    <br />
                    <h1><small>Por favor, respondé las preguntas honesta y completamente</small></h1>
                </div>
                <div class="form-group">
                    <label for="dni">Tu DNI</label>
                    <input class="form-control" type="text" name="dni" id="dni" placeholder="<?php echo isset($_SESSION['persona'])? $_SESSION['persona']: 'Si estas viendo esto, hubo un error' ?>" value="<?php echo isset($_SESSION['persona'])? $_SESSION['persona']: -1 ?>" readonly/>
                    <br class="clear"/>
                </div>
                <div class="form-group">
                    <h2>Sobre tu ahijado</h2>
                    <label for="dniAhijado">DNI de tu ahijado</label>
                    <input class="form-control" type="text" name="dni_ahijado" id="dni_ahijado" required/>
                    <br class="clear"/>
                    <label for="apellidoAhijado">Apellido de tu ahijado</label>
                    <input class="form-control" type="text" name="apellidoAhijado" id="apellidoAhijado" required/>
                    <br class="clear"/>
                    <label for="nombreAhijado">Nombre de tu ahijado</label>
                    <input class="form-control" type="text" name="nombreAhijado" id="nombreAhijado" required/>
                    <br class="clear"/>
                </div>
                <div class="form-group">
                    <h2>Prepartida</h2>
                    <label for="prepartida1">1. ¿Cuánto hace que conocés a tu ahijado? ¿De dónde?</label>
                    <textarea required class="form-control" rows="3" name="prepartida1" id="prepartida1"></textarea>
                    <br class="clear"/>
                    <label for="prepartida2">2. ¿Hace cuánto que lo estás preparando?</label>
                    <textarea required class="form-control" rows="3" name="prepartida2" id="prepartida2"></textarea>
                    <br class="clear"/>
                    <label for="prepartida3">3. ¿Tu ahijado conoce detalles de la PARTIDA? ¿Cuáles? (Palancas, cartas, recepción, etc.)</label>
                    <textarea required class="form-control" rows="3" name="prepartida3" id="prepartida3"></textarea>
                    <br class="clear"/>
                    <label for="prepartida4">4. ¿Por qué lo presentás a PARTIDA? ¿Qué pensás que la PARTIDA le puede dar?</label>
                    <textarea required class="form-control" rows="3" name="prepartida4" id="prepartida4"></textarea>
                    <br class="clear"/>
                </div>
                <div class="form-group">
                    <h2>Partida</h2>
                    <label for="partida1">1. ¿Con qué predisposición va a la PARTIDA? (Indiferencia, curiosidad, miedo, ilusión, cierto rechazo, apertura, otros)</label>
                    <textarea required class="form-control" rows="3" name="partida1" id="partida1"></textarea>
                    <br class="clear"/>
                    <label for="partida2">2. Según tu criterio ¿Cuál será su actitud ante charlas, debates, dinámicas de la PARTIDA? ¿Por qué pensás esto?</label>
                    <textarea required class="form-control" rows="3" name="partida2" id="partida2"></textarea>
                    <br class="clear"/>
                </div>
                <div class="form-group">
                    <h2>Personalidad</h2>
                    <label for="personalidad1">1. Describí su personalidad y su carácter. (Maduro, introvertido, abierto, alegre, depresivo, animoso, cambiante, nervioso, impulsivo, afectivo, cerebral, otros) Poné ejemplos que clarifiquen.</label>
                    <textarea required class="form-control" rows="3" name="personalidad1" id="personalidad1"></textarea>
                    <br class="clear"/>
                    <label for="personalidad2">2. ¿Es responsable? ¿En qué casos?</label>
                    <textarea required class="form-control" rows="3" name="personalidad2" id="personalidad2"></textarea>
                    <br class="clear"/>
                </div>
                <div class="form-group">
                    <h2>Ambiente</h2>
                    <label for="ambiente1">1. Explicá cómo se compone su familia (integrantes, edades).</label>
                    <textarea required class="form-control" rows="3" name="ambiente1" id="ambiente1"></textarea>
                    <br class="clear"/>
                    <label for="ambiente2">2. ¿Qué papel desempeña en su familia? (Conciliador, protegido, oveja negra, indiferente, otros) Ejemplos.</label>
                    <textarea required class="form-control" rows="3" name="ambiente2" id="ambiente2"></textarea>
                    <br class="clear"/>
                    <label for="ambiente3">3. ¿Hay algún problema destacable de su familia que convenga aclarar?</label>
                    <textarea required class="form-control" rows="3" name="ambiente3" id="ambiente3"></textarea>
                    <br class="clear"/>
                    <label for="ambiente4">4. ¿En qué otros ambientes se mueve? (Club, estudio, parroquia, trabajo, otros). Describí cómo son esos ambientes y ordenalos por prioridades.</label>
                    <textarea required class="form-control" rows="3" name="ambiente4" id="ambiente4"></textarea>
                    <br class="clear"/>
                    <label for="ambiente5">5. ¿Qué papel desempeña, en general, en esos ambientes? (Manejado, participante, líder, conductor, factor de unión/desunión, alentador, negativo, otros)</label>
                    <textarea required class="form-control" rows="3" name="ambiente5" id="ambiente5"></textarea>
                    <br class="clear"/>
                    <label for="ambiente6">6. Si tiene novio/a: ¿Cómo es su relación con él/ella? (Absorbente, normal, de escapismo de la casa, otros)</label>
                    <textarea required class="form-control" rows="3" name="ambiente6" id="ambiente6"></textarea>
                    <br class="clear"/>
                    <label for="ambiente7">7. ¿Hay algo que te preocupe en particular de tu ahijado/a y querés aclarar? ¿Tu ahijado ha tenido alguna experiencia en su vida que lo ha marcado en su forma de ser?
                    <small>(Si esta respuesta es de carácter reservado podés escribirla en sobre cerrado y nosotros se lo haremos llegar al sacerdote que acompañe a esta PARTIDA)</small></label>
                    <textarea required class="form-control" rows="3" name="ambiente7" id="ambiente7"></textarea>
                    <br class="clear"/>
                </div>
                <div class="form-group">
                    <h2>Religiosidad</h2>
                    <label for="religiosidad1">1. ¿Qué sacramentos recibió? ¿Se acerca actualmente a los sacramentos? (Eucaristía, confesión)</label>
                    <textarea required class="form-control" rows="3" name="religiosidad1" id="religiosidad1"></textarea>
                    <br class="clear"/>
                    <label for="religiosidad2">2. ¿Qué instrucción religiosa tiene? ¿Le interesa? ¿Qué temas acerca de fe y moral te preocupan de tu ahijado?</label>
                    <textarea required class="form-control" rows="3" name="religiosidad2" id="religiosidad2"></textarea>
                    <br class="clear"/>
                </div>
                <div class="form-group">
                    <button type="submit" id="btn_submit_rol" class="btn btn-block btn-success">Registrar datos</button>
                </div>
            </form>
        </div>
    </div>
</div>

<a id="logout" href="../login.php?status=loggedout">Salir</a>

</body>
</html>