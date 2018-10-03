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
	 
	 function checkIfEmailExists($email) {
		 $statement = $this->connection->prepare("SELECT email FROM users WHERE email = ?");
		 $statement-> bind_param("s", $email);
		 $statement->execute();
		 $statement->store_result();
		 
		 if($statement->num_rows() > 1)
			 return TRUE;
		 
	 }
?>