<?php
	session_start();
	require("navbar.php");
	require_once("utilizador.php");
	$utilizador = new utilizador();
	
	
	if($utilizador->checkSession() == FALSE)
	{
		header('location: login.php');
		exit();
	}
		
?>
<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"/>
		<style>
			.navbar {
				color:white;
			}
		</style>
	</head>
	<body>
		Welcome <?php $utilizador->findUser(); ?> 
		<button class="pull-right"><a href="logout.php">LOG OUT</a></button>
		<a href="uploadPicture.php" class="pull-right">Upload Picture</a>
		<a href="changePass.php" class="pull-right">Change password</a>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</body>
</html>