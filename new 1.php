<?php
class utilizador 
{
	private $servername;
	private $username;
	private $password;
	private $database;
	private $connection;
	
	public function __construct()
	{
		$this->servername = 'localhost';
		$this->username = 'root';
		$this->password = '';
		$this->database = 'miguel';
		$this->connection = new mysqli($this->servername, $this->username, $this->password, $this->database);
		//Para os acentos aparecerem na base de dados
		mysqli_set_charset($this->connection ,"utf8");
	}
	
	public function validar($name, $email, $password, $passwordR)
	{
		if($name == null || $email == null || $password == null || $passwordR == null) 
			return array('status'=>FALSE, 'msg'=>"Preencha os campos necessários.");
		
		if(filter_var($email, FILTER_VALIDATE_EMAIL) == FALSE) 
			return array('status'=>FALSE, 'msg'=>"O email tem caracteres inválidos.");
		
		if(strlen($password) < 6) 
			return array('status'=>FALSE, 'msg'=>"A password tem de ter no mínimo 6 coisos.");
		
		if($passwordR != $password) 
			return array('status'=>FALSE, 'msg'=>"As passwords não coincidem.");
		
		if($this->DoesEmailExistInDatabase($email) == TRUE)
			return array('status'=>FALSE, 'msg'=> 'Atenção que o email já existe');
		
		return array('status'=>TRUE, 'msg'=>"Good job lad!");
	}
	
	public function InsertUserIntoDatabase($name, $email, $password, $status = TRUE)
	{
		$password_aux = password_hash($password, PASSWORD_DEFAULT);
		
		$statement = $this->connection->prepare("INSERT INTO users (name, email, password, status) VALUES(?, ?, ?, ?)");
		$statement->bind_param("sssi", $name, $email, $password_aux, $status);
		$statement->execute();
	}
	
	public function DoesEmailExistInDatabase($email)
	{
		$statement = $this->connection->prepare("SELECT email FROM users WHERE email = ?");
		$statement->bind_param("s", $email);
		$statement->execute();
		$statement->store_result();

		if($statement->num_rows() > 0)
			return TRUE;
	}	
	
	public function GetUserInfoFromDatabase($email)
	{
		$statement = $this->connection->prepare("SELECT id, name, date_signup FROM users WHERE email = ?");
		$statement->bind_param("s", $email);
		$statement->execute();
		$statement->store_result();
		$statement->bind_result($id, $name, $date_signup);
		$statement->fetch();
	
		return array('id' => $id, 'name' => $name, 'date_signup' => $date_signup);
	}
}
?>