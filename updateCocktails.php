<?php 

	$file = file_get_contents('users.json');
	
	$data = json_decode($file);
	
	unset($file);
	
	print_r($data);

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
				
		}
		
	}
	
	file_put_contents('users.json',json_encode($data));
	
	unset($data);
	

?>