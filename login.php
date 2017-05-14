<?php
session_start();
require_once 'classes/Membership.php';
$membership = new Membership();

// If the user clicks the "Log Out" link on the index page.
if (isset($_GET['status']) && $_GET['status'] == 'loggedout') {
    $membership->log_User_Out();
}

// cleaning input-------------
// define variables and set to empty values
/*$name = $email = $gender = $comment = $website = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = test_input($_POST["name"]);
    $email = test_input($_POST["email"]);
    $website = test_input($_POST["website"]);
    $comment = test_input($_POST["comment"]);
    $gender = test_input($_POST["gender"]);
}
*/
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
//-------------------------------

// Did the user enter a password/username and click submit?
if ($_POST && !empty($_POST['pwd'])) {
    if($_POST['dni']) {
        $response = $membership->validate_User(test_input($_POST['dni']),test_input($_POST['pwd']));
    }
    else {
        $response = $membership->validate_newUser(test_input($_POST['pwd']));
    }
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Login - Ficha digital Partida Cba</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
        body {
            background: url(images/logo_partida_big.jpg) no-repeat center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }
    </style>
</head>

<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div>
                <h1 class="text-center" style="background-color: rgba(255,255,255,0.8)"><strong>Ficha Digital - Partida Córdoba</strong></h1>
                <h4 class="text-muted text-center" style="background-color: rgba(255,255,255,0.7)">Ingresá al sistema</h4>
            </div>
            <div>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="form col-md-12 center-block">
                    <div class="form-group">
                        <input type="text" name="dni" id="dni" class="form-control input-lg" placeholder="DNI">
                        <input type="password" name="pwd" id="pwd" class="form-control input-lg" placeholder="Clave">
                    </div>
                    <div class="form-group" id="botones">
                        <button id="btn_entrar" class="btn btn-success btn-lg btn-block">Entrar</button>
                        <button id="btn_firstTime" class="btn btn-danger btn-lg btn-block" type='button'>Es la primera vez que entro</button>
                    </div>
                    <?php if(isset($response)) echo '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button><strong>' . $response . "</strong></div>"; ?>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/login.js"></script>
</body>
</html>