<?php 

	//Mise à jour des cocktails favoris après un click sur "ajouter" ou "retirer" des favoris
	$file = file_get_contents('users.json');
	
	$data = json_decode($file);
	
	unset($file);

	if(isset($_GET["ajoutCocktail"]))
	{
		foreach($data as $user)
		{
			if($user->username == $_COOKIE["user"]["username"])
			{
				
				$user->cocktailsPreferes[] = $_GET["ajoutCocktail"];
				
				setCookie("user[cocktailsPreferes]", json_encode($user->cocktailsPreferes), time() + 60*60*24*365);
				$_COOKIE["user"]["cocktailsPreferes"] = json_encode($user->cocktailsPreferes);

			}
		}	
		
	} 

	if(isset($_GET["retireCocktail"]))
	{
		
		foreach($data as $user)
		{
			if($user->username == $_COOKIE["user"]["username"])
			{
				$user->cocktailsPreferes = array_diff($user->cocktailsPreferes, [$_GET["retireCocktail"]]);
				$user->cocktailsPreferes = array_values($user->cocktailsPreferes);
				
				setCookie("user[cocktailsPreferes]", json_encode($user->cocktailsPreferes), time() + 60*60*24*365);
				$_COOKIE["user"]["cocktailsPreferes"] = json_encode($user->cocktailsPreferes);
			}
		}
	}
	
	file_put_contents('users.json',json_encode($data));
	
	unset($data);
	

?>