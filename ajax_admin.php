<?php 
	require_once("utilizador.php");
	$utilizador = new utilizador();
	$type 	= $_POST['type'];

	
	switch($type)
	{
		case 'edit': 
			$id 	= $_POST['id'];
			$status = $_POST['status'] == 'true';
			$admin 	= $_POST['admin'] == 'true';
			
			if($id == null || $status === null || $admin === null)
			{
				echo json_encode(array('status' => FALSE, 'msg' => 'Faltam campos obrigatórios'));
				return;
			}
			
			if($utilizador->doesIdExistsAndIsNotAdmin($id) == FALSE)
			{
				echo json_encode(array('status' => FALSE, 'msg' => 'Ocorreu um erro inesperado..'));
				return;
			}
			
			$utilizador->edit($id, $status, $admin);
			echo json_encode(array('status' => TRUE, 'msg' => 'Porreiro, tudo OK!'));
			break;
			
		case 'delete':
			$id = $_POST['id'];
			
			if($id == null) 
			{
				echo json_encode(array('status' => FALSE, 'msg' => 'Id = null'));
				return;
			}
			
			if($utilizador->doesIdExistsAndIsNotAdmin($id) == FALSE)
			{
				echo json_encode(array('status' => FALSE, 'msg' => 'Ocorreu um erro inesperado..'));
				return;
			}
			
			$utilizador->delete($id);
			echo json_encode(array('status' => TRUE, 'msg' => 'Porreiro, tudo OK!'));
			break;
	}
?>