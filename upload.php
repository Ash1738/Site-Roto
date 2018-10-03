<?php
   if(isset($_FILES['image'])){
      $errors= array();
	  $RandomAccountNumber = uniqid();
	  $file_original_name = $_FILES['image']['name'];
		$file_original_name = substr($file_original_name, -6);
      $file_name = $RandomAccountNumber . $file_original_name;
      $file_size =$_FILES['image']['size'];
      $file_tmp =$_FILES['image']['tmp_name'];
      $file_type=strtolower($_FILES['image']['type']);
	  $tmp = explode('.',$_FILES['image']['name']);
      $file_ext=strtolower(end($tmp));
      
      $expensions= array("jpeg","jpg","png");
      
      if(in_array($file_ext,$expensions)=== false){
         $errors[]="extension not allowed, please choose a JPEG or PNG file.";
      }
      
      if($file_size > 2097152){
         $errors[]='File size must be exactly 2 MB';
      }
      
      if(empty($errors)==true){
		 echo $file_original_name;
         move_uploaded_file($file_tmp,"uploads/".$file_name);
		 
		 session_start();
		 
		 require_once("utilizador.php");
		 $utilizador = new utilizador();
		 $utilizador->savePhotoPath('uploads/' . $file_name);
		 
         echo "Success";
      }else{
         print_r($errors);
      }
   }
?>