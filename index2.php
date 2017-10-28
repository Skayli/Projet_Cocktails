<?php

include_once 'Includes/Header_Footer.inc.php';
include_once 'Includes/Donnees.inc.php';


	$echo = "";
	$ingr = "";
	$superCateg = "";
	$arrSuperCateg = array();
	
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
		}
		
		display($topCateg);
	}
	
	//@params
	//$categ: element du tableau $Hierarchie[] qui possède une sous catégorie
	//Crée un sous-menu, et rapelle la fonction si une sous catégorie possède une sous catégorie
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
					$superCateg = $superCateg.'<li class="dropdown-submenu li-submenu"><a>'.$sousCateg.'</a>';
				}
				else 
				{
					$superCateg = $superCateg.'<li id="li-sousCategorie" value="'.$sousCateg.'"><a tabindex="-1" href="#">'.$sousCateg.'</a>';
				}
				display($sousCateg);
			}	
			$superCateg = $superCateg.'</ul>';	
		}
	}
	//FIN display()
	
	$superCateg = $superCateg.'</ul>';
	
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
	<?php echo $header; ?>
	
	<div class="container-fluid" id="navbar">
		<div class="container">
		
		
		

		
		
			<ul class="nav nav-pills" id="test">
				<li role="presentation">
					<a href="#" class="text-nav-bar">Home</a>
				</li>
				<li role="presentation" class="dropdown">
					<a href="#" class="dropdown-toggle text-nav-bar" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Aliments
						<span class="caret"></span>
					</a> 
					<input type="hidden" id="search-aliment" name="search-aliment" value="nothing">
					<?php echo $superCateg ?>
				</li>
				<li role="presentation">
					<a href="#" class="text-nav-bar">Help</a>
				</li>
			</ul>


		
		
		</div>
	</div>
	
	

		<div class="container main-content">
						
				<h1>HTML Ipsum Presents</h1>

				<p><strong>Pellentesque habitant morbi tristique</strong> senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. <em>Aenean ultricies mi vitae est.</em> Mauris placerat eleifend leo. Quisque sit amet est et sapien ullamcorper pharetra. Vestibulum erat wisi, condimentum sed, <code>commodo vitae</code>, ornare sit amet, wisi. Aenean fermentum, elit eget tincidunt condimentum, eros ipsum rutrum orci, sagittis tempus lacus enim ac dui. <a href="#">Donec non enim</a> in turpis pulvinar facilisis. Ut felis.</p>

				<h2>Header Level 2</h2>

				<ol>
				   <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</li>
				   <li>Aliquam tincidunt mauris eu risus.</li>
				</ol>

				<blockquote><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus magna. Cras in mi at felis aliquet congue. Ut a est eget ligula molestie gravida. Curabitur massa. Donec eleifend, libero at sagittis mollis, tellus est malesuada tellus, at luctus turpis elit sit amet quam. Vivamus pretium ornare est.</p></blockquote>

				<h3>Header Level 3</h3>

				<ul>
				   <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</li>
				   <li>Aliquam tincidunt mauris eu risus.</li>
				</ul>
				
				<pre><code>
				#header h1 a {
				  display: block;
				  width: 300px;
				  height: 80px;
				}
				</code></pre>
					
			
				<h1>HTML Ipsum Presents</h1>

				<p><strong>Pellentesque habitant morbi tristique</strong> senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. <em>Aenean ultricies mi vitae est.</em> Mauris placerat eleifend leo. Quisque sit amet est et sapien ullamcorper pharetra. Vestibulum erat wisi, condimentum sed, <code>commodo vitae</code>, ornare sit amet, wisi. Aenean fermentum, elit eget tincidunt condimentum, eros ipsum rutrum orci, sagittis tempus lacus enim ac dui. <a href="#">Donec non enim</a> in turpis pulvinar facilisis. Ut felis.</p>

				<h2>Header Level 2</h2>

				<ol>
				   <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</li>
				   <li>Aliquam tincidunt mauris eu risus.</li>
				</ol>

				<blockquote><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus magna. Cras in mi at felis aliquet congue. Ut a est eget ligula molestie gravida. Curabitur massa. Donec eleifend, libero at sagittis mollis, tellus est malesuada tellus, at luctus turpis elit sit amet quam. Vivamus pretium ornare est.</p></blockquote>

				<h3>Header Level 3</h3>

				<ul>
				   <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</li>
				   <li>Aliquam tincidunt mauris eu risus.</li>
				</ul>
				
				<pre><code>
				#header h1 a {
				  display: block;
				  width: 300px;
				  height: 80px;
				}
				</code></pre> 
			
		
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