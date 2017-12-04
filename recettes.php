	<?php 
	
		$images = glob("Photos/*.jpg");
		
		asort($Recettes);
		
		$tabIngredients; //Pour contenir tous les ingredients et sous-categories lors d'une recherche
		$superCategories; //Contient les super-categories de la recherche pour le fil d'ariane
		
		//Modification du tableau Recettes lors d'une recherche afin d'avoir une seule fonction de création de la page
		if(isset($_POST["ingredient"]) && $_POST["ingredient"] != "") {
			
			$ingredientRecherche = $_POST["ingredient"];
			
			$tabRecettes = array();
			
			$tabIngredients = array();
			$tabIngredients[] = $ingredientRecherche;
			
			$superCategories = array();
			$superCategories[] = $ingredientRecherche;
			
			getSousCategories($ingredientRecherche);
			getSuperCategories($ingredientRecherche);
			
			foreach($Recettes as $recette => $details) {
				if(count(array_intersect($details["index"], $tabIngredients))) {
					$tabRecettes[] = $details;
				}
			}
			$Recettes = $tabRecettes;
		}
		
		function getSousCategories($sousCateg) {
			global $Hierarchie;
			global $tabIngredients;
	
				if(array_key_exists("sous-categorie", $Hierarchie[$sousCateg]))
				{
					foreach($Hierarchie[$sousCateg]["sous-categorie"] as $sousSousCateg) 
					{
						$tabIngredients[] = $sousSousCateg;
						getSousCategories($sousSousCateg);
					}
				}
		}
		
		function getSuperCategories($categorie) {
			global $Hierarchie;
			global $superCategories;
			
			if(array_key_exists("super-categorie", $Hierarchie[$categorie]))
				{
					$superCategories[] = $Hierarchie[$categorie]["super-categorie"][0];
					getSuperCategories($Hierarchie[$categorie]["super-categorie"][0]);	
				}
		}
		
		function hasAPhoto($titreCocktail)
		{
			global $images;
			$titreCocktail = str_replace(" ", "_", $titreCocktail).".jpg";
			$titreCocktail = str_replace("'", "", $titreCocktail);
			$hasAPhoto = false;
		
			foreach($images as $index => $titreImage)
			{	
				if(!strcasecmp($titreCocktail, str_replace("Photos/","",$titreImage)))
				{
					return $titreImage;
				}
			}
			
			return $hasAPhoto;
		}
				
		//Enleve les accents présents (afin de pouvoir faire des comparaisons)
		function suppr_accents($str, $encoding='utf-8')
		{
			// transformer les caractères accentués en entités HTML
			$str = htmlentities($str, ENT_NOQUOTES, $encoding);
		 
			// remplacer les entités HTML pour avoir juste le premier caractères non accentués
			// Exemple : "&ecute;" => "e", "&Ecute;" => "E", "à" => "a" ...
			$str = preg_replace('#&([A-za-z])(?:acute|grave|cedil|circ|orn|ring|slash|th|tilde|uml);#', '\1', $str);
		 
			// Remplacer les ligatures tel que : , Æ ...
			// Exemple "œ" => "oe"
			$str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str);
			// Supprimer tout le reste
			$str = preg_replace('#&[^;]+;#', '', $str);
		 
			return $str;
		}
		
		//Retourne un tableau des ingrédients du cocktail en parametre
		function getAllIngredients($indexCocktail)
		{
			global $Recettes;
			return explode("|",$Recettes[$indexCocktail]["ingredients"]);
		}
		
		//Retourne un tableau des préparation du cocktail en parametre
		function getPreparation($indexCocktail)
		{
			global $Recettes;
			// /([^\.!\?]+[\.!\?]+)|([^\.!\?]+$)/
			/*  /([^.!?\s][^.!?]*(?:[.!?](?![\'\"]?\s|$)[^.!?]*)*[.!?]?[\'\"]?(?=\s|$))/ */
			$chars = preg_split('/([^\.!\?]+[\.!\?]+)|([^\.!\?]+$)/', $Recettes[$indexCocktail]["preparation"], -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE); 
			return $chars;
			// return multiexplode(array(". ","!"),$Recettes[$indexCocktail]["preparation"]);
		}
		
		//Pour utiliser la fonction explode avec plusieurs délimiteurs
		function multiexplode ($delimiters,$string) {
			$ready = str_replace($delimiters, $delimiters[0], $string);
			$launch = explode($delimiters[0], $ready);
			return  $launch;
		}
		
		function isCocktailPrefere($titre)
		{
			if(isset($_COOKIE["user"]["cocktailsPreferes"]) && is_array(json_decode($_COOKIE["user"]["cocktailsPreferes"])) && (in_array($titre, json_decode($_COOKIE["user"]["cocktailsPreferes"]))))
			{
				return true;
			} else {
				return false;
			}
		}
		
		function getCocktailsPreferes() {
			$tabCocktailsPreferes = array();
			global $Recettes;
			foreach($Recettes as $recette => $details) {
				if(isCocktailPrefere($details["titre"])) {
					$tabCocktailsPreferes[] = $details;
				}
			}
			
			return $tabCocktailsPreferes;
		}
	?>
	
	
	
	<h1>Cocktails</h1>
	
	<?php 
		if(isset($_POST["divCocktails"])) {
			$Recettes = getCocktailsPreferes();
		}
	?>
	
			<div class="allCocktails">
			
					<?php 
					if(isset($_POST["ingredient"]) && $_POST["ingredient"] != "") {
							array_pop($superCategories);
							echo "<p id='fil-ariane'>Ingrédients : ".implode(" > ", array_reverse($superCategories))."</p>";
					} else {
						if(isset($_POST["divCocktails"])) {
							
					?>
					<p>Mes cocktails favoris !</p>
					
						<?php } else { ?>
					<p>Retrouvez tous les cocktails et leur recette !</p>
					
					<?php 
						}
					}
					
						if(isset($_COOKIE["user"]))
						{
							if(!isset($_POST["divCocktails"])) {
					?>
						<form method="POST" action="">
							<input type="submit" class="btn btn-primary" id="cocktailsPreferes" type="button" value="Mes cocktails préférés" name="all"/>
							<input type="hidden" name="page" value="recettes">
							<input type="hidden" name="divCocktails" value="preferes">
						</form>
					<?php	} else { ?>
						<form method="POST" action="">
							<input type="submit" class="btn btn-primary" id="cocktailsPreferes" type="button" value="Tous les cocktails" name="all"/>
							<input type="hidden" name="page" value="recettes">
						</form>
					<?php 
						
							}
						}
						
						foreach($Recettes as $index => $details)
						{
							//Pour mettre à la ligne la partie entre parenthese dans les titres (et faire plus propre)
							$arr = explode("(", $details["titre"], 2);
							$titre = $arr[0];
							$parenthese = isset($arr[1]) ? '('.$arr[1] : '';
					?>
							
						<div class="col-sm-10 thumbnail col-sm-offset-1">

						<!-- Affichage du titre -->
						<h3 class="thumbnail-title"><?php echo $titre.'<br />'.$parenthese ?></h3>
								
					<?php
							//Affichage de la photo si le cocktail en a une dans le dossier Photos
							if(hasAPhoto(suppr_accents($details["titre"])))
							{
								echo '<br /> <img src="'.hasAPhoto(suppr_accents($details["titre"])).'" class="img" /><br />';
							} else {
								echo '<br /> <img src="resources/images/no_img.jpg" class="img" /><br />';
							}
					?>		
						<hr class='cocktails-hr'>
						
						<!-- Affichage des ingrédients du cocktail -->
						<div class="details ingredients"> <h4 class="title-details">Ingrédients</h4>
					
					<?php
							$ingredients = getAllIngredients($index); //Recupération des ingrédients sous la forme d'un tableau en passant l'index du cocktail pour y accéder directement
							
							foreach($ingredients as $listeIngredients)
							{
								echo '<span class="listeDetails">'.$listeIngredients."</span><br />";
							}
							
					?>
						
						</div>
										
						<hr class='cocktails-hr'>
									
						<!-- Affichage de la preparation, de la meme façon que les ingredients ! -->
						<div class="details preparation"> <h4 class="title-details">Préparation</h4>
							
					<?php
							$preparation = getPreparation($index);
							
							foreach($preparation as $listePreparation)
							{
								if($listePreparation != " ")
									echo '<span class="listeDetails">'.$listePreparation."</span><br />";
							}
							
					?>
					
						<br /></div>
					
					<?php		
							if(isset($_COOKIE["user"]))
							{
					?>
								<div class="pretty p-icon p-toggle p-plain p-smooth" >
									<input type="checkbox" class="pretty-checkbox" id="checkbox-<?php echo $details["titre"]; ?>" <?php if(isCocktailPrefere($details["titre"])) { echo "checked"; } ?> role="button" title="<?php if(isCocktailPrefere($details["titre"])) { echo "Retirer des favoris"; } else { echo "Ajouter aux favoris"; } ?>" data-toggle="tooltip" data-placement="top"/>
									<div class="state p-off">
										<i class="icon glyphicon glyphicon-heart-empty" ></i>
									</div>
									<div class="state p-on p-danger-o">
										<i class="icon glyphicon glyphicon-heart"></i>
									</div>
								</div>
					<?php
							}
					?>	
					
						</div>
						
					<?php 
						} 
					?>
			</div>