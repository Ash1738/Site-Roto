<?php 
	require_once("utilizador.php");
	$utilizador = new utilizador();
	
	
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
			<img src="chicken.png" style="width:60px;height:60px;" class="image form1"> </div>
		<div class="text-center">
			<h2 class="text-center">Enter your email</h2> 
		<form action="" method="post" class="text-center">
			<label class="campos"><span style="color:red" >*</span>Email</label><br>
			<input type="text" name="email"/> <br>
			<button type="submit" class="button btn btn-default" onclick="this.form.submit(); this.disabled=true;">Submit</button> <br>
		</form>
		<?php 
			if($_POST) 
			{
				$result3 = $utilizador->validateStatus();
				if($result3 == FALSE) 
				{
					echo "Your account is inactive";
					return;
				}
				$result2 = $utilizador->validateTokenDate($_POST['email']);
				if($result2 == FALSE) 
				{
					echo 'Wait my friend';
					return;
				}
				$result = $utilizador->checkIfEmailExists($_POST['email']);
				if($result == false) 
				{
					echo "O email não existe";
					return;
				}
			
				$email = $_POST['email'];
				$utilizador->sendEmail($email);
			}	
		?>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</body>
</html>
