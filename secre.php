<?php

require_once (__DIR__. '/classes/Membership.php');
$membership = New Membership();
$rolNeeded = 2;
//$rolNeeded = 1;
$membership->confirm_Member($rolNeeded);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Página SECRETARIADO</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center text-primary">
                Página SECRETARIADO
            </h1>
        </div>
    </div>
</div>
<a href="login.php?status=loggedout">Salir</a>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
