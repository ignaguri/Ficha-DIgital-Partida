<?php

require_once (__DIR__. '/classes/Membership.php');
$membership = New Membership();
$rolNeeded = 3;
$membership->confirm_Member($rolNeeded);

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Página PADRINO</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

  </head>
  <body>

    <div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1>
					Página PADRINO
				</h1>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<ul class="nav nav-pills">
				<li class="active">
					<a href="#">Solicitar código ahijado</a>
				</li>
				<li>
					<a href="#">Revisar ficha ahijado</a>
				</li>
				<li class="disabled">
					<a href="#">Ayuda</a>
				</li>
			</ul>
		</div>
	</div>
</div>
    <a href="login.php?status=loggedout">Salir</a>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
