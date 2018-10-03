<?php
session_start();
	if ($_POST)
	{
		require_once("utilizador.php");
		$utilizador = new utilizador();
		$result = $utilizador->validar_campos_signup($_POST['name'],$_POST['email'],$_POST['password_a'],$_POST['password_b']);
	}
?>
<!DOCTYPE html>
<html>
	<head>
	
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"/>
		<?php require_once("navbar.php"); ?>
		<?php require_once('teste.html'); ?>
	</head>
	<body>
		<div class="jumbotron">
			<div class="row">
				<div class="col-xs-12">
					<h2 class="text-center">Registo</h2>
					
					<form action="" method="post" class="text-center form1">
						<input type="text" name="name" placeholder="Nome" required> <br>
						<input type="text" name="email" placeholder="Email" required> <br>
						<input type="password" name="password_a" placeholder="Senha" required> <br>
						<input type="password" name="password_b" placeholder="Repita a Senha" required> <br>
						<button type="submit" class="button btn btn-default">Inscreva-se</button>
					</form>
					<div class="thumbnail">
							<p class="text-center" style="font-size:18px;">Já se inscreveu??<a href="login.php"> Faça Login!</a></p>
					</div>
				</div>
			</div>
		</div>	
		<?php 
			if($_POST)
			{
				echo '<h2 class="text-center">' . $result['msg'] . '</h2>';
				
				if ($result['status'] == TRUE) 
				{
					$utilizador->insertData($_POST["name"], $_POST["email"], $_POST["password_a"]);
					header('location: login.php');
					exit();
				}	
			}
		?>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</body>
</html>