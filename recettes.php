	<?php 
	
		$images = glob("Photos/*.jpg");		
		asort($Recettes);
	
		
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
			$chars = preg_split('/([^.!?\s][^.!?]*(?:[.!?](?![\'\"]?\s|$)[^.!?]*)*[.!?]?[\'\"]?(?=\s|$))/', $Recettes[$indexCocktail]["preparation"], -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE); 
			return $chars;
			// return multiexplode(array(". ","!"),$Recettes[$indexCocktail]["preparation"]);
		}
		
		//Pour utiliser la fonction explode avec plusieurs délimiteurs
		function multiexplode ($delimiters,$string) {
			$ready = str_replace($delimiters, $delimiters[0], $string);
			$launch = explode($delimiters[0], $ready);
			return  $launch;
		}
		
		function isCocktailPrefere($index)
		{
			if(isset($_COOKIE["user"]["cocktailsPreferes"]) && is_array(json_decode($_COOKIE["user"]["cocktailsPreferes"])) && (in_array($index, json_decode($_COOKIE["user"]["cocktailsPreferes"]))))
			{
				return true;
			} else {
				return false;
			}
		}
	?>
	 

	
	<h1>Cocktails</h1>

		<p>Retrouvez tous les cocktails et leur recette !</p>
		

			<div class="allCocktails">
					<?php
					
						if(isset($_COOKIE["user"]))
						{
					?>
						<input class="btn btn-primary" id="cocktailsPreferes" type="button" value="Mes cocktails préférés"/>	
					<?php 
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
									<input type="checkbox" class="pretty-checkbox" id="checkbox-<?php echo $index; ?>" <?php if(isCocktailPrefere($index)) { echo "checked"; } ?> role="button" title="<?php if(isCocktailPrefere($index)) { echo "Retirer des favoris"; } else { echo "Ajouter aux favoris"; } ?>" data-toggle="tooltip" data-placement="top"/>
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
			
			<div class="cocktailsPreferes">
				<?php 
					if(isset($_COOKIE["user"]))
					{
				?>
					<div class="col-sm-10 col-sm-offset-1">
						<input class="btn btn-primary" id="allCocktails" type="button" value="Tous les cocktails">
					</div>
					
				<?php	
					}
				?>
			
		</div>