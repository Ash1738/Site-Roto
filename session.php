<?php
/*SESSION -> SESSOES -> SESSAO TEM DE SER GUARDADA NA BASE DADOS
COOKIES -> O COOKIE TAMBEM DEVE SER GUARDADO NA BASE DADOS


PHP mysqli login
PHP login
PHP sessions */ 
	session_start();
	if(!isset($_SESSION['email']))
		{
		header("Location: login.php");
		exit(); 
		}



?>