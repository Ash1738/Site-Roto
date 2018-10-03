<?php	
	session_start();
	require("navbar.php");
	require_once("utilizador.php");
	$utilizador = new utilizador();
	
	if($utilizador->checkSession() == TRUE)
	{
		header('location: profile.php');
		exit();
	}
	
	if ($_POST)
	{
		$result = $utilizador->validar_campos_login($_POST['email'],$_POST['password_a']);
		
		if($result['status'] == TRUE)
		{
			
			$user_id = $utilizador->getUserIdByEmail($_POST['email']);
			$utilizador->insertAccess($user_id);
			$utilizador->setSession($_POST['email']);
			$utilizador->setCookie();
			if($utilizador->checkAdmin() == FALSE) 
			{
				header('location: profile.php');
				exit();
			}
			header('location: profileAdmin.php');
			exit();
			
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"/>
		<style>
		body {
			background-color: #e6ecf0;;
			font-family:"Segoe UI",Arial,sans-serif;
			font-size:15px;
			color:#14171a;
		}
		h2 {
			font-size:27px;
			
		}

		.button {
			margin-top:20px;
			background-color: #1da1f2;
			border-color: #006dbf;
			color: #fff;

		}
		.jumbotron {
			background-color: rgb(255, 255, 255);
			width: auto;
			position: relative;
			width: 500px;
			margin: 0 auto;
			border: 1px solid #c1c1c1;
			border-radius: 15px;
		}
		.thumbnail {
			margin-top:50px;
			background-color: #f5f8fa;
			font-size: 14px;
			color: #657786;
			margin-left:-60px;
			margin-right:-60px;
			margin-bottom:-48px;
		}
		input {
			margin-top:30px;
						
		}

		</style>
	</head>
	<body>
		<div class="container">
			<div class="jumbotron">
				<div class="row">
					<div class="col-xs-12">
						<h2>Entra no Twéter Caralho</h2> 
						<form action="" method="post">
							<input type="text" name="email" placeholder="Email"> <br>
					sdaasdasdasddas="password_a" placeholder="Senha"> <br>
							<input type="checkbox" name="remember" checked>Lembrar-me ainda mais rápido!<br>
							<button type="submit" class="button btn btn-default">Entrar</button>
							<a href="recovery.php">Esqueceu a sua senha?</a>
						</form>
						<div class="thumbnail">
							<p class="text-center" style="font-size:18px;">Novo no Twéter? <a href="signup.php">Inscreva-se agora jovem!</a></p>
						</div>
					</div>
				</div>
			</dasdasdasdasd
			if($_POST)
				echo '<h2 class="text-center">' . $result['msg'] . '</h2>';
			
		?>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</body>
</html>