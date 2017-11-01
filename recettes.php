	<?php 
	
		$images = glob("Photos/*.jpg");
		
		foreach($images as $index => $titre)
				$titre = strtolower(str_replace("Photos/","",$titre));
		
		
		asort($Recettes);
		
		/*foreach($Recettes as $index => $details)
		{
				
				if(hasAPhoto(suppr_accents($details["titre"])))
				{
					echo 'Image de '.$details["titre"].' : <img src="'.hasAPhoto(suppr_accents($details["titre"])).'" class="img-thumbnail" /><br />';
				} else {
					echo 'Image de '.$details["titre"].' : Aucune image disponible';
				}
		
		}*/
		
		function hasAPhoto($titreCocktail)
		{
			global $images;
			$titreCocktail = str_replace(" ", "_", $titreCocktail).".jpg";
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
		
	?>
	
	<h1>Cocktails</h1>
		<p>Retrouvez tous les cocktails et leur recette !</p>
		
		<div class="row">
			
					<?php
					
						foreach($Recettes as $index => $details)
						{
							$arr = explode("(", $details["titre"], 2);
							$titre = $arr[0];
							$parenthese = isset($arr[1]) ? '('.$arr[1] : '';
					
							
							echo '<div class="col-sm-12 thumbnail">';
							
							echo '<h4 class="thumbnail-title">'.$titre.'<br />'.$parenthese.'</h4>';
								if(hasAPhoto(suppr_accents($details["titre"])))
								{
									echo '<br /> <img src="'.hasAPhoto(suppr_accents($details["titre"])).'" class="img" /><br />';
								} else {
									echo '<br /> <img src="resources/images/no_img.jpg" class="img" /><br />';
								}
											
							echo '</div>';
							
						}
					?>
		</div>
					