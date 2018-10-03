<?php
	session_start();
	if($_POST) 
	{
		require_once("utilizador.php");
		$utilizador = new utilizador();
		$result = $utilizador->validarChangePass($_POST['password_actual'],$_POST['password_a'],$_POST['password_b']);
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
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
		<a href="profile.php"><h3>Go back</h3></a>
		<div class="text-center">
			<h2 class="text-center">Alteração da password</h2> 
		<form action="" method="post" class="text-center">
			<label class="campos"><span style="color:red">*</span>Password actual</label><br>
			<input type="password" name="password_actual"/> <br>
			<label class="campos"><span style="color:red">*</span>Nova password</label><br>
			<input type="password" name="password_a"/> <br>
		<label class="campos"><span style="color:red">*</span>Repita a nova password</label><br>
			<input type="password" name="password_b"/> <br>
			<button type="submit" class="button btn btn-default">Submit</button>
		</form>
		<?php
			if($_POST) 
			{
				echo '<h2 class="text-center">' . $result['msg'] . '</h2>';
				if($result['status'] == true) {
					$utilizador->insertNewPass();
					
				}
			}
			
			
		?>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</body>
</html>