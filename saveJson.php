<?php
	//Enregistrement de l'utilisateur lors de son inscription
	$file = file_get_contents('users.json');
	
	$data = json_decode($file);
	
	unset($file);
	
	$data[] = array("username" => mb_convert_case($_GET["username"], MB_CASE_TITLE), "forename" => mb_convert_case($_GET["forename"], MB_CASE_TITLE), "name" => mb_convert_case($_GET["name"], MB_CASE_TITLE), "gender" => $_GET["gender"], "email" => strtolower($_GET["email"]), "password" => $_GET["password"], "dateNaissance" => $_GET["dateNaissance"], "adresse" => $_GET["adresse"], "codePostal" => $_GET["codePostal"], "ville" => $_GET["ville"], "telephone" => $_GET["telephone"]);
	
	file_put_contents('users.json',json_encode($data));
	
	unset($data);
	
?>