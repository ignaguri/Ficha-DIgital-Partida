<?php

require_once (__DIR__. '/classes/Membership.php');
$membership = New Membership();
$rolNeeded = 4;
$membership->confirm_Member($rolNeeded);

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Página PARTIDISTA</title>


    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

  </head>
  <body>

    <div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1>
					Página PARTIDISTA
				</h1>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<dl class="dl-horizontal">
				<dt>
					Instrucciones:
				</dt>
				<dd>
					Completá todos estos datos que son una banda
				</dd>
			</dl>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<dl class="dl-horizontal">
				<dt>
					Subí una foto
				</dt>
				<dd>
					que no salgas espantoso, pero tampoco para Tinder.
				</dd>
			</dl>
		</div>
		<div class="col-md-6">
			<img src="images/profile.png" class="img-circle">
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<form role="form">
				<div class="form-group">

					<label for="exampleInputEmail1">
						Email address
					</label>
					<input type="email" class="form-control" id="exampleInputEmail1">
				</div>
				<div class="form-group">

					<label for="exampleInputPassword1">
						Password
					</label>
					<input type="password" class="form-control" id="exampleInputPassword1">
				</div>
				<div class="form-group">

					<label for="exampleInputFile">
						File input
					</label>
					<input type="file" id="exampleInputFile">
					<p class="help-block">
						Example block-level help text here.
					</p>
				</div>
				<div class="checkbox">

					<label>
						<input type="checkbox"> Check me out
					</label>
				</div>
				<button type="submit" class="btn btn-default">
					Submit
				</button>
			</form>
			<h3 class="text-danger">
				Ordená tus pecados de forma candente
			</h3>
			<ol>
				<li>
					Lorem ipsum dolor sit amet
				</li>
				<li>
					Consectetur adipiscing elit
				</li>
				<li>
					Integer molestie lorem at massa
				</li>
				<li>
					Facilisis in pretium nisl aliquet
				</li>
				<li>
					Nulla volutpat aliquam velit
				</li>
				<li>
					Faucibus porta lacus fringilla vel
				</li>
				<li>
					Aenean sit amet erat nunc
				</li>
				<li>
					Eget porttitor lorem
				</li>
			</ol>
			<h2>
				¿Qué esperas de Partida? bla bla
			</h2>
			<p>
				Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Espero que Nachito Albar Diaz no me tire apenas empiece el cuarto día.
			</p>
			<p>
				<a class="btn" href="#">View details »</a>
			</p>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<h3>
				Datos padrino (ya precargados)
			</h3>
			<address>
				 <strong>Twitter, Inc.</strong><br> 795 Folsom Ave, Suite 600<br> San Francisco, CA 94107<br> <abbr title="Phone">P:</abbr> (123) 456-7890
			</address>
		</div>
	</div>
	<div class="row">
		<div class="col-md-10">
		</div>
		<div class="col-md-2">

			<button type="button" class="btn btn-block btn-success btn-default">
				Enviar
			</button>
		</div>
	</div>
</div>
    <a href="login.php?status=loggedout">Salir</a>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
