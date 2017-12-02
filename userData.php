<?php

	$user = $_COOKIE["user"];
	
	$username = $user["username"];
	$prenom = $user["forename"];
	$nom = $user["name"];
	$genre = $user["gender"];
	$email = $user["email"];
	$hiddenPassword = preg_replace("|.|","*",$user["password"]);
	$dateNaissance = $user["dateNaissance"];
	$adresse = $user["adresse"];
	$cp = $user["codePostal"];
	$ville = $user["ville"];
	$telephone = $user["telephone"];

?>

	<h1>Vos données personnelles</h1>
	
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1">
			<div class="panel">
				
				
				<div class="panel-body">
					<div class="row">
					
						<div class="col-sm-12">
							<div class="form-grou">
								<label for="data-username">Nom d'utilisateur : </label>
								<input type="text" id="data-username" tabindex="2" class="form-control data-input" placeholder="Nom d'utilisateur" value="<?php echo $username; ?>">
								<span class="data-display"><?php echo $username; ?></span>
								<input id="data-old-username" type="hidden" value="<?php echo $username; ?>">
										
							</div>
							
							<hr />


							<div class="form-grou">
								<label for="data-username">Prénom : </label>
								<input type="text" id="data-forename" tabindex="2" class="form-control data-input" placeholder="Prénom" value="<?php echo $prenom; ?>">
								<span class="data-display"><?php echo $prenom; ?></span>
							</div>
						
							<hr />
							
							<div class="form-grou">
								<label for="data-username">Nom : </label>
								<input type="text" id="data-name" tabindex="2" class="form-control data-input" placeholder="Nom" value="<?php echo $nom; ?>">
								<span class="data-display"><?php echo $nom; ?></span>
							</div>
							
							<hr />
							
							<div class="form-grou">
								<label for="data-gender">Sexe : </label>
								
									<div class="data-input">
										<div class="pretty p-switch">
											<input type="radio" name="switch-gender" class="register-switch" id="register-switch-homme" value="homme" <?php if($genre == "homme") { echo "checked"; }?>/>
												<div class="state p-info switch-gender">
													<label>un homme</label>
												</div>
										</div>
										
										<div class="pretty p-switch">
											<input type="radio" name="switch-gender" class="register-switch" id="register-switch-femme" value="femme" <?php if($genre == "femme") { echo "checked"; }?>/>
												<div class="state p-danger switch-gender">
													<label>une femme</label>
												</div>
										</div>
									</div>
										
								<span class="data-display"><?php echo $genre; ?></span>
							</div>
							
							<hr />
							
							<div class="form-grou">
								<label for="data-email">Email : </label>
								<input type="text" id="data-email" tabindex="2" class="form-control data-input" placeholder="Email" value="<?php echo $email; ?>">
								<span class="data-display"><?php echo $email; ?></span>
							</div>
							
							<hr />
							
							<div class="form-grou">
								<label for="data-password">Mot de passe : </label>
								<input type="password" id="data-password-current" tabindex="2" class="form-control data-input data-input-password" placeholder="Mot de passe actuel" value="">
								<input type="password" id="data-password-new" tabindex="2" class="form-control data-input data-input-password" placeholder="Nouveau mot de passe" value="">
								<input type="password" id="data-password-new-confirm" tabindex="2" class="form-control data-input " placeholder="Confirmer le nouveau mot de passe" value="">
								<span class="data-display"><?php echo $hiddenPassword; ?></span>
							</div>
							
							<hr />
							
							<div class="form-grou">
								<label for="data-username">Date de naissance : </label>
								<input type="text" id="data-dateNaissance" tabindex="2" class="form-control date data-input" placeholder="Date de naissance" value="<?php echo $dateNaissance; ?>">
								<span class="data-display"><?php echo $dateNaissance; ?></span>
							</div>
							
							<hr />
							
							<div class="form-grou">
								<label for="data-email">Adresse : </label>
								<input type="text" id="data-adresse" tabindex="2" class="form-control data-input" placeholder="Adresse" value="<?php echo $adresse; ?>">
								<span class="data-display"><?php echo $adresse; ?></span>
							</div>
							
							<hr />
							
							<div class="form-grou">
								<label for="data-cp">Code Postal : </label>
								<input type="text" id="data-cp" tabindex="2" class="form-control data-input" placeholder="Code postal" value="<?php echo $cp; ?>">
								<span class="data-display"><?php echo $cp; ?></span>
							</div>
							
							<hr />
							
							<div class="form-grou">
								<label for="data-ville">Ville : </label>
								<input type="text" id="data-ville" tabindex="2" class="form-control data-input" placeholder="Ville" value="<?php echo $ville; ?>">
								<span class="data-display"><?php echo $ville; ?></span>
							</div>
							
							<hr />
							
							<div class="form-grou">
								<label for="data-telehpone">Telephone : </label>
								<input type="text" id="data-telephone" tabindex="2" class="form-control data-input" placeholder="Numéro de téléphone" value="<?php echo $telephone; ?>">
								<span class="data-display"><?php echo $telephone; ?></span>
							</div>
							
							<hr />
							
							<div class="data-display">
								<input id="display-data-input" type="button" value="Modifier" class="btn btn-primary">
							</div>
							
							<div class="data-input">
								<input id="save-data" type="button" value="Savegarder" class="btn btn-success">
								<input id="cancel-data" type="button" value="Annuler" class="btn btn-danger">
							</div>
							
						</div>
						
					</div>
				</div>
				
			</div>
		</div>
	</div>