<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Registrar PARTIDISTA - Ficha digital Partida Cba</title>

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

if ($_POST && $_POST['persona'] == 'rol_partidista') {

    $datos_rol = $utils->sanitizeData('rol_partidista', $_POST);
    $flag = $new_user->new_rol_data(4, $datos_rol);

    if ($flag)
        $membership->redirectUser($_SESSION['rol']);
}

?>
<body>
<div class="container-fluid">
    <div class="row center_div" id="holder">
        <div class="col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2" id="form-holder">
            <form id="form_partidista" name="form_partidista" method="post"
                  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <input class="form-control" type="hidden" name="persona" value="rol_partidista">
                <div class="page-header">
                    <h1>Registrarse como <em>partidista</em></h1>
                    <br />
                    <h1><small>Ingresá tus datos</small></h1>
                </div>
                <div class="form-group">
                    <label for="dni">DNI</label>
                    <input class="form-control" type="text" name="dni" id="dni" placeholder="<?php echo isset($_SESSION['persona'])? $_SESSION['persona']: 'xx.xxx.xxx' ?>" readonly/>
                    <br class="clear"/>
                </div>
                <div class="form-group">
                    <label for="apodo">Apodo</label>
                    <input class="form-control" type="text" name="apodo" id="apodo" required/>
                    <br class="clear"/>
                </div>
                <div class="form-group">
                    <label for="facultad">Facultad</label>
                    <select id="facultad" name="facultad" class="form-control" required>
                        <option value="">No seleccionado</option>
                        <option value="UNC">UNC</option>
                        <option value="UCC">UCC</option>
                        <option value="UTN">UTN</option>
                        <option value="SXXI">Siglo XXI</option>
                        <option value="UBP">UBP</option>
                        <option value="MarMor">Mariano Moreno</option>
                        <option value="Otra">Otra</option>
                    </select>
                    <br class="clear"/>
                </div>
                <div class="form-group">
                    <label for="serv_emergencia">Serv Emergencia</label>
                    <input class="form-control" type="text" name="serv_emergencia" id="serv_emergencia" required/>
                    <br class="clear"/>
                </div>
                <hr style="height: 2px; background-color: black; width: 75%">
                <div class="form-group">
                    <h2>Aspecto Personal</h2>
                    <label for="aspecto_personal1">1. ¿Por qué querés hacer PARTIDA?</label>
                    <textarea class="form-control" rows="3" name="aspecto_personal1" id="aspecto_personal1" required></textarea>
                    <br class="clear"/>
                    <label for="aspecto_personal2">2. Reflexioná sobre estos siete aspectos de tu vida y ordenalos por importancia cómo los vivís: Espiritual - Afectivo - Político - Intelectual - Económico - Corporal - Social. Explica porqué.</label>
                    <textarea class="form-control" rows="3" name="aspecto_personal2" id="aspecto_personal2" required></textarea>
                    <br class="clear"/>
                    <label for="aspecto_personal3">3. ¿Qué querés y qué te gustaría ser en tu vida?</label>
                    <textarea class="form-control" rows="3" name="aspecto_personal3" id="aspecto_personal3" required></textarea>
                    <br class="clear"/>
                    <label for="aspecto_personal4">4. ¿Cuál es tu máxima aspiración y cómo la lograrías?</label>
                    <textarea class="form-control" rows="3" name="aspecto_personal4" id="aspecto_personal4" required></textarea>
                    <br class="clear"/>
                    <label for="aspecto_personal5">5. Cómo te ves a vos mismo: ¿Cuáles son tus tres principales virtudes? ¿Por qué? ¿Cuáles son tus tres principales defectos? ¿Por qué?</label>
                    <textarea class="form-control" rows="3" name="aspecto_personal5" id="aspecto_personal5" required></textarea>
                    <br class="clear"/>
                </div>
                <div class="form-group">
                    <h2>Relación con los demás</h2>
                    <label for="relacion_con_demas1">1. ¿Qué actividades desarrollás? ¿Dónde? (Club, parroquia, etc.)</label>
                    <textarea class="form-control" rows="3" name="relacion_con_demas1" id="relacion_con_demas1" required></textarea>
                    <br class="clear"/>
                    <label for="relacion_con_demas2">2. ¿Qué dicen de vos los demás? ¿Estás de acuerdo? ¿Por qué?</label>
                    <textarea class="form-control" rows="3" name="relacion_con_demas2" id="relacion_con_demas2" required></textarea>
                    <br class="clear"/>
                    <label for="relacion_con_demas3">3. ¿Qué defectos te molestan más de las otras personas? ¿Por qué?</label>
                    <textarea class="form-control" rows="3" name="relacion_con_demas3" id="relacion_con_demas3" required></textarea>
                    <br class="clear"/>
                    <label for="relacion_con_demas4">4. ¿Tus padres viven? ¿Vivís con los dos juntos? ¿Cuántos hermanos tenés y cómo es tu relación con ellos?</label>
                    <textarea class="form-control" rows="3" name="relacion_con_demas4" id="relacion_con_demas4" required></textarea>
                    <br class="clear"/>
                    <label for="relacion_con_demas5">5. En tu familia te sentís: cuestionado, ignorado, privilegiado, escuchado, aceptado, desatendido, valorizado, limitado, otros. ¿Por qué?</label>
                    <textarea class="form-control" rows="3" name="relacion_con_demas5" id="relacion_con_demas5" required></textarea>
                    <br class="clear"/>
                    <label for="relacion_con_demas6">6. ¿Qué personas marcaron tu vida? ¿Para quién significas mucho? ¿Con quién o quienes tenés problemas?</label>
                    <textarea class="form-control" rows="3" name="relacion_con_demas6" id="relacion_con_demas6" required></textarea>
                    <br class="clear"/>
                </div>
                <div class="form-group">
                    <h2>Relación con Dios</h2>
                    <label for="relacion_con_dios1">1. ¿Quién es Dios para vos? ¿Cuál de estas imágenes tenés de Él: policía, amigo, juez, castigador, misericordioso, todopoderoso, paciente, indiferente a los problemas del hombre, padre, otros)?</label>
                    <textarea class="form-control" rows="3" name="relacion_con_dios1" id="relacion_con_dios1" required></textarea>
                    <br class="clear"/>
                    <label for="relacion_con_dios2">2. ¿Qué cosas cuestionás de la Iglesia?</label>
                    <textarea class="form-control" rows="3" name="relacion_con_dios2" id="relacion_con_dios2" required></textarea>
                    <br class="clear"/>
                    <label for="relacion_con_dios3">3. ¿Qué sacramentos recibiste? ¿Tenés un asesor o algún sacerdote fijo con el cual charlás?</label>
                    <textarea class="form-control" rows="3" name="relacion_con_dios3" id="relacion_con_dios3" required></textarea>
                    <br class="clear"/>
                    <label for="relacion_con_dios4">4. ¿Participaste en retiros o convivencias? ¿Qué te dieron y qué descubriste? - ¿Participás o participaste en trabajos apostólicos (grupo misionero, catequesis, etc.)? ¿Qué te dan o dieron y qué descubriste?</label>
                    <textarea class="form-control" rows="3" name="relacion_con_dios4" id="relacion_con_dios4" required></textarea>
                    <br class="clear"/>
                    <label for="relacion_con_dios5">5. ¿Qué significa en tu vida la oración, la misa, la eucaristía, la confesión y la Virgen María?</label>
                    <textarea class="form-control" rows="3" name="relacion_con_dios5" id="relacion_con_dios5" required></textarea>
                    <br class="clear"/>
                    <label for="relacion_con_dios6">6. ¿Cómo te sentís hoy con tu fe?</label>
                    <textarea class="form-control" rows="3" name="relacion_con_dios6" id="relacion_con_dios6" required></textarea>
                    <br class="clear"/>
                    <label for="relacion_con_dios7">7. ¿Qué creés que PARTIDA te puede dar?</label>
                    <textarea class="form-control" rows="3" name="relacion_con_dios7" id="relacion_con_dios7" required></textarea>
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