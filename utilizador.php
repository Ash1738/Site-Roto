<?php
 class utilizador {
	 private $servername;
	 private $username;
	 private $password;
	 private $database;
	 private $connection;
	 
	 function __construct() 
	 {
		 $this->servername = "localhost";
		 $this->username =  "root";
		 $this->password = "";
		 $this->database = "miguel";
		 $this->connection = new mysqli($this->servername, $this->username, $this->password, $this->database);
		 $this->connection->set_charset('UTF8');
		 
		 
	 }
	 
	 function validar_campos_signup($name, $email, $password1, $password2) {
		 
		 if($name == null || $email == null || $password1 == null || $password2 == null) 
			return array("status"=>FALSE, "msg"=>"Faltam-te campos para preencher jovem");
		
		if(filter_var($email, FILTER_VALIDATE_EMAIL) == FALSE) 
			return array("status"=>FALSE, "msg"=>"O email tem carateres estúpidos");
		
		if(strlen($password1) < 6 )
			return array("status"=>FALSE, "msg"=>"A password tem de ter 6 carateres no mínimo");
		
		if($password2 != $password1)
			return array("status"=>FALSE, "msg"=>"As passwords não coincidem");
		
		if ($this->checkIfEmailExists($email) == TRUE)
			return array("status"=>FALSE, "msg"=>"O email já existe");

		return array("status"=>TRUE, "msg"=>"GZ");
	 }
	 
	 function validar_campos_login($email, $password1) {
		 
		 if($email == null || $password1 == null) 
			return array("status"=>FALSE, "msg"=>"Faltam-te campos para preencher jovem");
		
		if(filter_var($email, FILTER_VALIDATE_EMAIL) == FALSE) 
			return array("status"=>FALSE, "msg"=>"O email é inválido");
		
		if ($this->userExistsByEmailAndPassword($email, $password1) == FALSE)
			return array("status" => FALSE, "msg" => "Email ou senha errados");
		
		 return array("status" => TRUE);
	 }
	 
	 function checkIfEmailExists($email) 
	 {
		 $statement = $this->connection->prepare("SELECT email FROM users WHERE email = ?");
		 $statement->bind_param("s", $email);
		 $statement->execute();
		 $statement->store_result();

		 if($statement->num_rows() > 0)
			 return TRUE;
	 }
	 
	 function userExistsByEmailAndPassword($email, $password)
	 {
		$statement = $this->connection->prepare("SELECT password FROM users WHERE email = ?");
		$statement->bind_param("s", $email);
		$statement->execute();
		$statement->store_result();
		$statement->bind_result($password_from_database);
		$statement->fetch();

		return password_verify($password, $password_from_database);
	 }
	 
	 function doesIdExistsAndIsNotAdmin($id)
	 {
		$admin = FALSE;
		 
		$statement = $this->connection->prepare("SELECT id FROM users WHERE id = ? AND admin = ?");
		$statement->bind_param("ii", $id, $admin);
		$statement->execute();
		$statement->store_result();

		if($statement->num_rows() > 0)
			 return TRUE;
	 }
	 
	 function insertData($name, $email, $password, $status = TRUE) 
	 {
		 $passwordEnc = password_hash($password, PASSWORD_DEFAULT);
		 
		 $statement = $this->connection->prepare("INSERT INTO users (name, email, password, status) VALUES (?, ?, ?, ?)");
		 $statement->bind_param("sssi", $name, $email, $passwordEnc, $status);
		 $statement->execute();
	 }
	 
	 function insertAccess($user_id) 
	 {
		 $statement = $this->connection->prepare("INSERT INTO users_history (user_id) VALUES (?)");
		 $statement->bind_param("i", $user_id);
		 $statement->execute();
	 }
	 
	 function getUserIdByEmail($email) 
	 {
		$statement = $this->connection->prepare("SELECT id FROM users WHERE email = ?");
		$statement->bind_param("s", $email);
		$statement->execute();
		$statement->store_result();
		$statement->bind_result($id);
		$statement->fetch();
		
		return $id;
	 }
	 
	 
	 
	 function setSession($email) 
	 {
		 $_SESSION["email"] = $email;
	 }
	 
	function checkSession() 
	{
		if(!isset($_SESSION['email']))
			return $this->checkCookie();
		
		return TRUE;
	}
	
	function setCookie() 
	{
		if(isset($_POST['remember']) && $_POST['remember'] == TRUE) 
		{
			$email 		= $_POST['email'];
			$hash_unico = $this->generateRandomString() . $email; 
			
			setcookie("hash_unico", $hash_unico, time() + (86400 * 30 *30));
			
			$statement = $this->connection->prepare("UPDATE users SET cookie = ? WHERE email = ?");
			$statement->bind_param("ss", $hash_unico, $email);
			$statement->execute();
		}
	}
	
	function checkCookie()
	{	
		if(!isset($_COOKIE["hash_unico"]))
			return FALSE;
		
		$statement = $this->connection->prepare("SELECT email FROM users WHERE cookie = ?");
		$statement->bind_param("s", $_COOKIE['hash_unico']);
		$statement->execute();
		$statement->store_result();

		if($statement->num_rows() > 0)
			return TRUE;
	}
	
	function generateRandomString($length = 15)
	{
		return substr(sha1(rand()), 0, $length);
	}
	function findUser () 
	{
		if (isset($_SESSION['email']) || isset($_COOKIE['hash_unico'])) 
		{
			if (isset($_SESSION['email']) && !isset($_COOKIE['hash_unico'])) 
			{
			$statement = $this->connection->prepare("SELECT name FROM users WHERE email = ?");
			$statement->bind_param("s",$_SESSION['email']);
			$statement->execute();
			$statement->store_result();
			$statement->bind_result($name);
			$statement->fetch();
			echo $name;
			} else 
			{
			$statement = $this->connection->prepare("SELECT name FROM users WHERE cookie = ?");
			$statement->bind_param("s",$_COOKIE['hash_unico']);
			$statement->execute();
			$statement->store_result();
			$statement->bind_result($name);
			$statement->fetch();
			echo $name;
			}
		
		
		}
	}
	function validarChangePass($passActual, $passNova1, $passNova2) 
	{
		$query = $this->connection->prepare("SELECT password FROM users WHERE email = ?");
		$query->bind_param("s", $_SESSION['email']);
		$query->execute();
		$query->store_result();
		$query->bind_result($password);
		$query->fetch();
		
		if($passActual == null || $passNova1 == null || $passNova2 == null) 
			return array("status"=>false, "msg"=>"Preencha todos os campos");
		
		if(!password_verify($passActual,$password))
			return array("status"=>false, "msg"=>"A pw actual não é a mesma");
		
		if(strlen($passNova1) < 6 )
			return array("status"=>FALSE, "msg"=>"A Nova password tem de ter 6 carateres no mínimo");
		
		if($passNova1 != $passNova2)
			return array("status"=>FALSE, "msg"=>"As passwords não coincidem");
		
		return array("status"=>TRUE, "msg"=>"A pass foi mudada!");
	}
	function insertNewPass() 
	{
		
		$passwordEnc = password_hash($_POST['password_a'], PASSWORD_DEFAULT);
		$query = $this->connection->prepare("UPDATE users SET password = ? WHERE email = ?");
		$query->bind_param("ss", $passwordEnc, $_SESSION['email']);
		$query->execute();
	}
	function checkAdmin() 
	{
		$query = $this->connection->prepare("SELECT admin FROM users WHERE email = ?");
		$query->bind_param("s", $_POST['email']);
		$query->execute();
		$query->store_result();
		$query->bind_result($admin);
		$query->fetch();
		if($admin == 0) 
			return FALSE;
		if($admin == 1)
			return TRUE;
	
	}
	
	function getAllUsers() 
	{
		$query = $this->connection->query("SELECT * FROM users");
		
		$listOfUsers = array();
		
		while($row = $query->fetch_array(MYSQLI_ASSOC))
			array_push($listOfUsers, $row);
		
		return $listOfUsers;
	}
	function edit($id, $status, $admin) 
	{
	
		$query = $this->connection->prepare("UPDATE users SET status = ?, admin = ? WHERE id = ?");
		$query->bind_param("iii", $status, $admin, $id);
		$query->execute();
	}
	function delete($id)
	{
		$query = $this->connection->prepare("DELETE FROM users WHERE id = ?");
		$query->bind_param("i", $id);
		$query->execute();
	}
	function sendEmail($email) 
	{
		require('mail.php');
		
		$mail = new mail();
		
		$email_sem_arroba = str_replace('@', '--at--', $email);
		$token 			  = $this->generateRandomString();
		$sendTo 		  = array($email);
		$bccTo  	  	  = array();
		$replyTo 	  	  = array();
		$subject 		  = 'Recuperação da senha';
		$body    		  = '';
		$attachments 	  = array();

		$body  = 'Exmo/a, <br/><br/>';
		$body .= 'Foi solicitado a recuperação da senha para a sua conta. <br/>';
		$body .= 'Por favor clique no link abaixo para concluir a alteração.<br/><br/>';
		$body .= '<a href="http://localhost/test/resetPassword.php?token=' . $token . '&email=' . $email_sem_arroba . '">Clique neste link</a>';
		
		$token_date = date('Y-m-d H:i:s', strtotime('+2 hours'));
		
		$query = $this->connection->prepare("UPDATE users SET token = ?, token_date = ? WHERE email = ?");
		$query->bind_param('sss',$token, $token_date, $email);
		$query->execute();
		
		$mail->send($sendTo, $bccTo, $replyTo, $subject, $body, $attachments);
		
	}
	function validateTokenAndEmail() 
	{
		$email = $_GET['email'];
		$token = $_GET['token'];
		
		$email = str_replace('--at--','@' , $email); 
		
		$query = $this->connection->prepare("SELECT id FROM users WHERE email = ? AND token = ? AND token_date >= NOW()");
		$query->bind_param('ss', $email, $token);
		$query->execute();
		$query->store_result();
	
		if($query->num_rows() > 0)
			return TRUE;
	}
	function setPasswordFromEmail() 
	{
		$email = $_GET['email'];
		$email = str_replace('--at--','@' , $email);
		$passwordEnc = password_hash($_POST['password_a'], PASSWORD_DEFAULT);
		$query = $this->connection->prepare("UPDATE users SET password = ? WHERE email = ?");
		$query->bind_param("ss", $passwordEnc, $email);
		$query->execute();
	}
	function validarSetPasswordFromEmail($passNova1, $passNova2) 
	{
		if($passNova1 == null || $passNova2 == null) 
			return array("status"=>false, "msg"=>"Preencha todos os campos");
		
		if(strlen($passNova1) < 6 )
			return array("status"=>FALSE, "msg"=>"A Nova password tem de ter 6 carateres no mínimo");
		
		if($passNova1 != $passNova2)
			return array("status"=>FALSE, "msg"=>"As passwords não coincidem");
		
		return array("status"=>TRUE, "msg"=>"A pass foi mudada!");
	}
	function deleteTokenAndDate() 
	{
		$token_date  = null;
		$token		 = null;
		$tokenDate	 = null;
		$email = $_GET['email'];
		$email		 = str_replace('--at--','@' , $email);
		$query		 = $this->connection->prepare("UPDATE users SET token = ?, token_date = ? WHERE email = ?");
		$query->bind_param("sss", $token, $token_date, $email);
		$query->execute();
	}
	
	function validateTokenDate($email)
	{
		$query = $this->connection->prepare("SELECT token_date FROM users WHERE email = ?");
		$query->bind_param("s", $email);
		$query->execute();
		$query->store_result();
		$query->bind_result($tokenDate);
		$query->fetch();
		$date = date('Y-m-d H:i:s');
		
		if(is_null($tokenDate) || $tokenDate < $date)
			return TRUE;
	}

	function validateStatus() 
	{
		$email = $_POST['email'];
		$query = $this->connection->prepare("SELECT status FROM users WHERE email = ?");
		$query->bind_param("s",$email);
		$query->execute();
		$query->store_result();
		$query->bind_result($status);
		$query->fetch();
		
		
		if($status == 1)
			return TRUE;
	}
	
	function savePhotoPath($url)
	{
		$email = $_SESSION['email'];
		
		$query = $this->connection->prepare("UPDATE users SET photo_path = ? WHERE email = ?");
		$query->bind_param("ss", $url, $email);
		$query->execute();
	}
}
 
?>