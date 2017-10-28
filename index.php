<?php
	include_once 'Includes/Header_Footer.inc.php';
	include_once 'Includes/Donnees.inc.php';

	//Tableau contennant les ingrédients de plus bas niveau
	$ingredients = array();
	
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
		if(array_key_exists("sous-categorie",$Hierarchie[$topCateg]))
		{
			$superCateg = $superCateg.'<li class="dropdown-submenu li-submenu"><a>'.$topCateg.'</a>';
		} 
		else 
		{
			$superCateg = $superCateg.'<li id="li-sousCategorie" value="'.$topCateg.'"><a tabindex="-1" href="#">'.$topCateg.'</a>';
			array_push($ingredients,$topCateg);
			
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
		global $ingredients;
		
		if(array_key_exists("sous-categorie",$Hierarchie[$categ]))
		{
			
			$superCateg = $superCateg.'<ul class="dropdown-menu">';
			
			foreach($Hierarchie[$categ]["sous-categorie"] as $sousCateg)
			{
				if(array_key_exists("sous-categorie", $Hierarchie[$sousCateg]))
				{
					$superCateg = $superCateg.'<li class="dropdown-submenu li-submenu"><a>'.$sousCateg.'</a>';
				}
				else 
				{
					$superCateg = $superCateg.'<li id="li-sousCategorie" value="'.$sousCateg.'"><a tabindex="-1" href="#">'.$sousCateg.'</a>';
					
					if(!in_array($sousCateg, $ingredients))
					{
						array_push($ingredients,$sousCateg);
					}
				}
				display($sousCateg);
			}	
			$superCateg = $superCateg.'</ul>';	
		}
	}
	//FIN display()
	$superCateg = $superCateg.'</ul>';
	asort($ingredients);
	
//Fin de la création du bouton avec tous les éléments
?>

<!DOCTYPE html>

<html>

<head>
<!-- Recupération des bibliotheques JS et jquery en ligne --> 
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	
<!-- Fichier créés -->	
    <link href="resources/css/bootstrap.css" rel="stylesheet">
	<link href="resources/css/style.css" rel="stylesheet">
		
	<script type="text/javascript" src="resources/js/script.js"></script>
	

</head>

<body>
	
	<!-- Div d'affichage : Contient toute la page sauf le footer -->
	<div class="wrap"> 
		<?php echo $header;?>
		
		<!-- BARRE DE NAVIGATION -->
		<div class="container-fluid" id="navbar">
			<div class="container">
			
			<form method="post" action="#" id="changePage">
				<ul class="nav nav-pills" id="test"><!-- La navbar contient une LISTE de tous les "boutons" | LI == BOUTON -->
				
				
					<li role="presentation" class="btn-navbar btn-changePage" value="accueil" ><!-- class="active" => bouton surligné -->
						<a href="#" class="text-nav-bar">Accueil</a><!-- Bouton vers la page d'accueil -->
					</li>
					
					<li role="presentation" class="dropdown btn-navbar"><!-- Bouton multi-liste avec tous les aliments -->
						<a href="#" class="dropdown-toggle text-nav-bar" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Aliments
							<span class="caret"></span>
						</a> 
						<input type="hidden" id="search-aliment" name="search-aliment" value="nothing"><!-- Input dans lequel on récupère la valeur de l'aliment "feuille" cliqué (cf "script.js") -->
						<?php echo $superCateg ?>
					</li>
					
					<li role="presentation" class="btn-navbar btn-changePage" value="recettes"><!-- Bouton qui affichera la page ou seront présentées toutes les recettes -->
						<a href="#" class="text-nav-bar">Recettes</a>
					</li>
					
					<li role="presentation" class="btn-navbar btn-changePage" value="login"><!-- Bouton qui affichera la page des formulaire de connexion/inscription (à convenir : comment sauvegarder les données d'un utilisateur) -->
						<a href="#" class="text-nav-bar">Inscription/Connexion</a>
					</li>
					
					<!-- Zone de saisie à droite, contenant une datalist -->
					<div class="col-sm-5 col-md-5 pull-right">
						<form class="navbar-form" role="search">
							<div class="input-group">
								<input list="browsers" class="form-control" placeholder="Rechercher">
								<datalist id="browsers">
								  <?php foreach($ingredients as $allIngredients => $nom)
								  {
									  echo '<option value="'.$nom.'" />';
								  } ?>
								</datalist>
								<div class="input-group-btn"><!-- Bouton avec la loupe pour lancer la recherche -->
									<button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
								</div>
							</div>
						</form>
					</div>
				
				<input type="hidden" name="page"/>
				
				</ul>
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
			
				<?php
					if(isset($_POST["page"]) && ($_POST["page"] == "accueil" || $_POST["page"] == "login") || $_POST["page"] == "recettes")
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