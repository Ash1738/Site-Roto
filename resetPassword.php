<?php 
	require_once("utilizador.php");
	$utilizador = new utilizador();
	$result = $utilizador->validateTokenAndEmail();
	
	
	if($result == FALSE)
	{
		header('location: error.php');
		exit();
	}
	
	if($_POST) 
	{
		$result1 = $utilizador->validarSetPasswordFromEmail($_POST['password_a'], $_POST['password_b']);
		
	}
	
?>
<!DOCTYPE html>
<html>
	<head>
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"/>
		<style>
		body {
			background-color: #a6a6a6;
		}
		.campos {
			margin-top:20px;
		}
		.form1 {
			margin-top:150px;
		}
			.button {
				 margin-top:20px;
			}
		</style>
	</head>
	<body>
		<a href="login.php"><h3>Go back</h3></a>
		<div class="text-center">
			<h2 class="text-center">Alteração da password</h2> 
		<form action="" method="post" class="text-center">
			<label class="campos"><span style="color:red">*</span>Nova password</label><br>
			<input type="password" name="password_a"/> <br>
		<label class="campos"><span style="color:red">*</span>Repita a nova password</label><br>
			<input type="password" name="password_b"/> <br>
			<button type="submit" class="button btn btn-default">Submit</button>
		</form>
		<?php
			if($_POST) 
			{
				echo '<h2 class="text-center">' . $result1['msg'] . '</h2>';
				if($result1['status'] == true) {
					$utilizador->setPasswordFromEmail();
					$email=$_GET['email'];
					$utilizador->deleteTokenAndDate($email);
					header('location: login.php');
				}
			}
		?>
	</body>
</html>
