<?php

require_once (__DIR__. '/classes/Membership.php');
$membership = New Membership();

$rolNeeded = 1;
$membership->confirm_Member($rolNeeded);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="css/bootstrap.min.css" />

<title>Ficha digital Partida Cba</title>
</head>

<body>

<div id="container">
	<p>
    	Si estas viendo esto, felicidades, te logueaste con exito.
    </p>
    <blockquote>Bienvenido, Mr. Webmaster</blockquote>
    <a href="login.php?status=loggedout">Salir</a>
</div>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
