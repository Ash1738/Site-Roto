
<?php
// validar 
	class utilizador {
		function validar($name, $email,$password, $passwordR) {
			if($name == null || $email == null || $password == null || $passwordR == null)
				return array('status'=>FALSE, 'msg'=>'Preencha os dados necessários');
			if(filter_var($email, FILTER_VALIDATE_EMAIL) == FALSE)
				return array('status'=>TRUE, 'msg'=>'Email inválido');
			if(strlen($password) < 6)
				return array('status'=>FALSE, 'msg'=>'A password tem de ter 6 carateres');
			if($password != $passwordR)
				return array('status'=>TRUE, 'msg'=>'As passes têm de coincidir');
			else
				return array('status'=>TRUE, 'msg'=>'Ez');
		}
	}

	
	
	//select from table
	$select = "SELECT * FROM users";
	$result = $connect->query($select);
	
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			echo "Id: " . $row["id"] . "<br>" . " Name: " . $row["name"] ."<br>" . " Email: " . $row["email"] ."<br>" . " Password: " . $row["password"] ."<br>" ;
		}
	}
	else {
		echo "No results.";
	};
	
	//UPDATE 
	$update = "UPDATE users SET name='Alfredo Coalho' WHERE id=1";
	$result = $connect->query($update);
	
	if ($result === TRUE) {
		echo "Nice lad";
	}
	else 
		echo "Not nice bois";
?>