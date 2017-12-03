<?php

	$oldUsername = $_GET["oldUsername"];
	
	$newUsername = $_GET["newUsername"];
	$newPrenom = $_GET["newForename"];
	$newNom = $_GET["newName"];
	$newGenre = $_GET["newGender"];
	$newEmail = $_GET["newEmail"];
	$newPassword = $_GET["newPassword"];
	$newDateNaissance = $_GET["newDateNaissance"];
	$newAdresse = $_GET["newAdresse"];
	$newCp = $_GET["newCp"];
	$newVille = $_GET["newVille"];
	$newTelephone = $_GET["newTelephone"];
	
	
	$file = file_get_contents('users.json');
	
	$data = json_decode($file);
	
	unset($file);
	
	foreach($data as $user)
	{
		if($user->username == $oldUsername)
		{
			$user->username = $newUsername;
			$user->forename = $newPrenom;
			$user->name = $newNom;
			
			if($newPassword != "") {
				$user->password = $newPassword;
			} 
			
			$user->gender = $newGenre;
			$user->email = $newEmail;
			$user->dateNaissance = $newDateNaissance;
			$user->adresse = $newAdresse;
			$user->codePostal = $newCp;
			$user->ville = $newVille;
			$user->telephone = $newTelephone;
			
			setCookie("user[username]", $user->username, time() + 60*+60*24*365);
			$_COOKIE["user"]["username"] = $user->username;
			
			setCookie("user[forename]", $user->forename, time() + 60*60*24*365);
			$_COOKIE["user"]["forename"] = $user->forename;
				
			setCookie("user[name]", $user->name, time() + 60*60*24*365);
			$_COOKIE["user"]["name"] = $user->name;
			
			setCookie("user[password]", $user->password, time() + 60*60*24*365);
			$_COOKIE["user"]["password"] = $user->password;
			
			setCookie("user[gender]", $user->gender, time() + 60*60*24*365);
			$_COOKIE["user"]["gender"] = $user->gender;
					
			setCookie("user[email]", $user->email, time() + 60*60*24*365);
			$_COOKIE["user"]["email"] = $user->email;
						
			setCookie("user[password]", $user->password, time() + 60*60*24*365);
			$_COOKIE["user"]["password"] = $user->password;
				
			setCookie("user[dateNaissance]", $user->dateNaissance, time() + 60*60*24*365);
			$_COOKIE["user"]["dateNaissance"] = $user->dateNaissance;
					
			setCookie("user[adresse]", $user->adresse, time() + 60*60*24*365);
			$_COOKIE["user"]["adresse"] = $user->adresse;
				
			setCookie("user[codePostal]", $user->codePostal, time() + 60*60*24*365);
			$_COOKIE["user"]["odePostal"] = $user->codePostal;
						
			setCookie("user[ville]", $user->ville, time() + 60*60*24*365);
			$_COOKIE["user"]["ville"] = $user->ville;
					
			setCookie("user[telephone]", $user->telephone, time() + 60*60*24*365);
			$_COOKIE["user"]["telephone"] = $user->telephone;
		}
	
	}
	
	file_put_contents('users.json',json_encode($data));
	
	unset($data);
?>