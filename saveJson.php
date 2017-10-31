<?php
	$file = file_get_contents('users.json');
	
	$data = json_decode($file);
	
	unset($file);
	
	$data[] = array('user'=> array("username" => mb_convert_case($_GET["username"], MB_CASE_TITLE), "email" => strtolower($_GET["email"]), "password" => $_GET["password"]));
	
	file_put_contents('users.json',json_encode($data));
	
	unset($data);
	
?>