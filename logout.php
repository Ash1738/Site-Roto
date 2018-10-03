<?php
	session_start();
	session_destroy();
	setcookie("hash_unico", "", time() - (86400 * 30 *30));
	
	header('location: login.php');
	exit;
	
?>