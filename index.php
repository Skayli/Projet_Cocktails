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
	//et appeler la fonction diplay() pour les sous-catégories
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
    <link href="resources/css/bootstrap.css" rel="stylesheet">
	<link href="resources/css/style.css" rel="stylesheet">
		
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>

<body>
	<div class="wrap">
	<?php echo $header;?>
	
	
	
	<div class="container-fluid" id="navbar">
		<div class="container">
			<ul class="nav nav-pills" id="test">
				<li role="presentation" class="active">
					<a href="#" class="text-nav-bar">Accueil</a>
				</li>
				<li role="presentation" class="dropdown">
					<a href="#" class="dropdown-toggle text-nav-bar" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Aliments
						<span class="caret"></span>
					</a> 
					<input type="hidden" id="search-aliment" name="search-aliment" value="nothing">
					<?php echo $superCateg ?>
				</li>
				<li role="presentation">
					<a href="#" class="text-nav-bar">Recettes</a>
				</li>
				<li role="presentation">
					<a href="#" class="text-nav-bar">Inscription/Connexion</a>
				</li>

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
							<div class="input-group-btn">
								<button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
							</div>
						</div>
					</form>
				</div>
			
			</ul>
		</div>
	</div>
	
	

		<div class="container main-content">
		
			<?php include 'accueil.php' ?>
		
		</div>
		<div class="push"></div>
	</div>

	<?php echo $footer; ?>
	
	
 </body>
 
 
 <script>
	//Affiche le contenu des balises pre code a gauche
	$("pre code").each(function(){
		var html = $(this).html();
		var pattern = html.match(/\s*\n[\t\s]*/);
		$(this).html(html.replace(new RegExp(pattern, "g"),'\n'));
	});
	
	//Permet d'avoir un aliment
	$("#get-aliment #li-sousCategorie").click(function(){
		$("#search-aliment").val($(this).attr("value"));
		alert("Vous avez choisi : " + $("#search-aliment").val());
	});
	
	
	
	$('.li-submenu').mousedown(function(e) {
		
	});
	
	$('.li-submenu').click(function(e) {
		
	});
</script>
 

</html>