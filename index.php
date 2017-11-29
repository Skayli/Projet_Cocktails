<?php
	include_once 'Includes/Header_Footer.inc.php';
	include_once 'Includes/Donnees.inc.php';
	
	asort($Hierarchie);
	
//Creation du bouton avec tous les aliments
	
	//Initialisation de la liste
	$superCateg = '
		<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu" id="get-aliment">';
	
	//Boucle qui va créer les premier éléments 
	//et appeler la fonction diplay() pour les sous-catégories (cf: https://arche.univ-lorraine.fr/pluginfile.php/486869/mod_resource/content/6/ProjetPhpRecettesCuisine.WEB2.2017.pdf )
	//!! Cette partie peut surement être améliorée (modifier la fonction diplay() afin de n'appeler qu'elle dans la boucle par exemple)
	foreach($Hierarchie["Aliment"]["sous-categorie"] as $topCateg)
	{
		//Le test sert à savoir s'il faut créer un sous*menu parce que l'élément possède des sous-catégories
		if(array_key_exists("sous-categorie",$Hierarchie[$topCateg]))
		{
			$superCateg = $superCateg.'<li class="dropdown-submenu li-submenu getCategorie" value="'.$topCateg.'"><a tabindex="-1" href="#">'.$topCateg.'</a>';
		} 
		else 
		{
			$superCateg = $superCateg.'<li class="getCategorie" value="'.$topCateg.'"><a tabindex="-1" href="#">'.$topCateg.'</a>';
		}
		
		display($topCateg);
	}
	
	//@params
	//$categ: element du tableau $Hierarchie[] qui possède une sous catégorie
	//Crée un sous-menu, et rapelle la fonction si une sous catégorie possède elle-même une sous catégorie
	function display($categ)
	{
		global $Hierarchie;
		global $superCateg;
		
		if(array_key_exists("sous-categorie",$Hierarchie[$categ]))
		{
			
			$superCateg = $superCateg.'<ul class="dropdown-menu">';
			
			foreach($Hierarchie[$categ]["sous-categorie"] as $sousCateg)
			{
				if(array_key_exists("sous-categorie", $Hierarchie[$sousCateg]))
				{
					$superCateg = $superCateg.'<li class="dropdown-submenu li-submenu getCategorie"  value="'.$sousCateg.'"><a tabindex="-1" href="#">'.$sousCateg.'</a>';
				}
				else 
				{
					$superCateg = $superCateg.'<li class="getCategorie" value="'.$sousCateg.'"><a tabindex="-1" href="#">'.$sousCateg.'</a>';
				}
				display($sousCateg);
			}	
			$superCateg = $superCateg.'</ul>';
		}
	}
	//FIN display() 
	
	$superCateg = $superCateg.'</ul>'; //Fermeture de la liste des categories
	
//Fin de la création du bouton avec tous les éléments

//Gestion de la connexion : enregistrement en cookie des informations sauvegardées sur le serveur
	if(isset($_POST["username"])) {
		
		//Enregistrement du nom de l'utilisateur
		setCookie("user[username]", mb_convert_case($_POST["username"], MB_CASE_TITLE), time() + 60*60*24*365);
		$_COOKIE["user"]["username"] = mb_convert_case($_POST["username"], MB_CASE_TITLE);
		
		//Recupération des cocktails préférés et enregistrement dans les cookies
		$file = file_get_contents('users.json');
		$data = json_decode($file);
		unset($file);

		foreach($data as $user)
		{
			if($user->username == $_COOKIE["user"]["username"])
			{	
				setCookie("user[forename]", $user->forename, time() + 60*60*24*365);
				$_COOKIE["user"]["forename"] = $user->forename;
				
				setCookie("user[name]", $user->name, time() + 60*60*24*365);
				$_COOKIE["user"]["name"] = $user->name;
				
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
				
				if(isset($user->cocktailsPreferes))
				{
					setCookie("user[cocktailsPreferes]", json_encode($user->cocktailsPreferes), time() + 60*60*24*365);
					$_COOKIE["user"]["cocktailsPreferes"] = json_encode($user->cocktailsPreferes);
				}
			}
		}		
		
		unset($data);
	}
	
?>

<!DOCTYPE html>

<html>

<head>
<!-- Recupération des bibliotheques JS et jquery en ligne --> 
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.2/sweetalert2.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.0/jquery.cookie.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.2/locale/fr.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.js"></script>
	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.2/sweetalert2.min.css" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pretty-checkbox@3.0/dist/pretty-checkbox.min.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" />

	
<!-- Fichier créés -->	
    <link href="resources/css/bootstrap.css" rel="stylesheet">
	<link href="resources/css/style.css" rel="stylesheet">
		
	<script type="text/javascript" src="resources/js/script.js"></script>
	

</head>

<body>
	
	<!-- Div d'affichage : Contient toute la page sauf le footer -->
	<div class="wrap"> 
		<?php echo $header;?>
		
		<?php if(isset($_COOKIE["user"])) { ?>
			
			<span class="btn-changePage <?php if(isset($_POST['page'])&& $_POST['page'] == 'userData') { echo 'active '; } ?>" id="userInfo" value="userData"><?php echo $_COOKIE["user"]["username"]; ?></span>
			
		<?php } ?>
		
		
		<!-- BARRE DE NAVIGATION -->
		<div class="container-fluid" id="navbar">
			<div class="container">
			
				<ul class="nav nav-pills" id="test"><!-- La navbar contient une LISTE de tous les "boutons" | LI == BOUTON -->
				
				
					<li role="presentation" class="<?php if(isset($_POST['page'])&& $_POST['page'] == 'accueil' || !isset($_POST["page"])) { echo 'active '; } ?> btn-navbar btn-changePage" value="accueil" ><!-- class="active" => bouton surligné -->
						<a href="#" class="text-nav-bar">Accueil</a><!-- Bouton vers la page d'accueil -->
					</li>
					
					<li role="presentation" class="dropdown btn-navbar"><!-- Bouton multi-liste avec tous les aliments -->
						<a href="#" class="dropdown-toggle text-nav-bar" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Ingrédients
							<span class="caret"></span>
						</a> 
						<input type="hidden" id="search-aliment" name="search-aliment" value="nothing"><!-- Input dans lequel on récupère la valeur de la categorie cliquée (cf "script.js") -->
						<?php echo $superCateg ?>
					</li>
					
					<li role="presentation" class="<?php if(isset($_POST['page'])&& $_POST['page'] == 'recettes') { echo 'active '; } ?> btn-navbar btn-changePage" value="recettes"><!-- Bouton qui affichera la page ou seront présentées toutes les recettes -->
						<a href="#" class="text-nav-bar">Cocktails</a>
					</li>
					
					<?php if(isset($_COOKIE["user"])) { ?>
						<li role="presentation" class="btn-navbar" id="btn-deconnexion">
							<a href="#" class="text-nav-bar">Deconnexion</a>
						</li>
					<?php } else { ?>					
						<li role="presentation" class="<?php if(isset($_POST['page'])&& $_POST['page'] == 'login') { echo 'active '; } ?> btn-navbar btn-changePage" value="login"><!-- Bouton qui affichera la page des formulaire de connexion/inscription (à convenir : comment sauvegarder les données d'un utilisateur) -->
							<a href="#" class="text-nav-bar">Inscription/Connexion</a>
						</li>
					<?php } ?>
					
					<!--<!-- Zone de saisie à droite, contenant une datalist 
					<div class="col-sm-5 col-md-5 pull-right">
						<form class="navbar-form" role="search">
							<div class="input-group">
								<input list="browsers" class="form-control" placeholder="Rechercher">
								<datalist id="browsers">
								  <?/*php foreach($ingredients as $allIngredients => $nom)
								  {
									  echo '<option value="'.$nom.'" />';
								  } */?>
								</datalist>
								<div class="input-group-btn"><!-- Bouton avec la loupe pour lancer la recherche 
									<button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
								</div>
							</div>
						</form>
					</div> -->
				
				</ul>
				
			<form method="post" action="#" id="changePage">
				<input type="hidden" name="page"/>
			</form>
			
			</div>
		</div>
		
		<!-- //BARRE DE NAVIGATION --> 
		
		<!-- CONTENU PRINCIPAL -->
		<!--
		L'idée est de séparer les différents contenus dans différentes pages (au format PHP) 
		et d'include la bonne quand nécessaire (selon le bouton de la navbar cliqué, on affiche accueil.php, login.php, etc ... 
		-->
		<div class="container main-content">
			<!-- Bouton pour retourner en haut de la page -->
		<a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top" role="button" title="Cliquez pour retourner en haut de la page" data-toggle="tooltip" data-placement="left"><span class="glyphicon glyphicon-chevron-up"></span></a> 
				<?php
					if(isset($_POST["page"]) && ($_POST["page"] == "accueil" || $_POST["page"] == "login" || $_POST["page"] == "recettes") || $_POST["page"] == "userData")
					{
						include($_POST["page"].'.php');
					} else {
						include("accueil.php");
					}
				?>
			
		</div>
		<!-- //CONTENU PRINCIPAL -->
		
		<!-- Div d'affichage : pousse le footer pour qu'il ne soit pas au dessus du texte de bas de page -->
		<div class="push"></div>

	
	</div>
	<!-- //WRAP -->
	
	
	<?php echo $footer; ?>
	
 </body>

</html>