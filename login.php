	<!--Formulaires de connexion et d'inscription--> 
	<div class="row">
		<div class="col-sm-6 col-sm-offset-3">
			<div class="panel panel-login">
			
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-6">
							<a href="#" class="active" id="login-form-link">Connexion</a>
						</div>
						<div class="col-xs-6">
							<a href="#" id="register-form-link">Inscription</a>
						</div>
					</div>
					
					<hr>
					
				</div>
				
				<div class="panel-body">
					<div class="row">
						<div class="col-sm-12">
							<!--Partie connexion-->
							<form id="login-form" action="#" method="post" role="form" style="display:block;">
								<div class="form-group">
									<label for="login-username">Nom d'utilisateur</label>
									<input type="text" name="username" id="login-username" tabindex="1" class="form-control" placeholder="Nom d'utilisateur" value="">
								</div>
								<div class="form-group">
									<label for="login-password">Mot de passe</label>
									<input type="password" id="login-password" tabindex="2" class="form-control" placeholder="Mot de passe" value="">
								</div>
								
								<br>
								
								<div class="form-group">
									<div class="row">
										<div class="col-sm-6 col-sm-offset-3">
											<input type="submit" name="login-submit" tabindex="3" class="form-control btn btn-login" value="Connexion">
										</div>
									</div>
								</div>
							
							</form>
							
							<form id="register-form" action="#" method="post" role="form" style="display:none">
							<!--Partie inscription-->
								<div class="form-group">
									<label for="register-username">Nom d'utilisateur</label>
									<input type="text" name="register-username" id="register-username" tabindex="1" class="form-control" placeholder="Nom d'utilisateur" value="">
									<span class="msgError" id="register-username-error">Nom d'utilisateur incorrect</span>
								</div>
								
								<div class="form-group">
								<label for="register-forename">Prénom</label>
									<input type="text" name="forename" id="register-forename" tabindex="1" class="form-control" placeholder="Prénom" value="">
									<span class="msgError" id="register-forename-error">Format incorrect</span>
								</div>
								
								<div class="form-group">
									<label for="register-name">Nom</label>
									<input type="text" name="name" id="register-name" tabindex="1" class="form-control" placeholder="Nom" value="">
									<span class="msgError" id="register-name-error">Format incorrect</span>
								</div>

								<div class="form-group">
									<div class="form-register-switch">
										<label for="switch">Vous etes : </label>
										<div class="pretty p-switch">
											<input type="radio" name="switch-gender" class="register-switch" id="register-switch-homme" value="homme" />
											<div class="state p-info switch-gender">
												<label>un homme</label>
											</div>
										</div>
										
										<div class="pretty p-switch">
											<input type="radio" name="switch-gender" class="register-switch" id="register-switch-femme" value="femme" />
											<div class="state p-danger switch-gender">
												<label>une femme</label>
											</div>
										</div>
										<span class="msgError" id="register-gender-error">Choisissez une possibilité</span>
									</div>
								</div>

								<div class="form-group">
									<label for="register-email">Email</label>
									<input type="text" name="email" id="register-email" tabindex="1" class="form-control" placeholder="Email" value="">
									<span class="msgError" id="register-email-error">Email incorrect</span>
								</div>
								<div class="form-group">
									<label for="register-password">Mot de passe</label>
									<input type="password" name="password" id="register-password" tabindex="2" class="form-control" placeholder="Mot de passe" value="">
									<span class="msgError" id="register-password-error">Le mot de passe doit contenir 1 minuscule, 1 majuscule, 1 chiffre, 1 caractère spécial et au moins 6 caractères</span>
								</div>
								<div class="form-group">
									<label for="register-confirm-password">Confirmer le mot de passe</label>
									<input type="password" name="confirm-password" id="register-confirm-password" tabindex="2" class="form-control" placeholder="Confirmer le mot de passe" value="">
									<span class="msgError" id="register-confirm-password-error">Les mots de passe ne sont pas identiques</span>
								</div>
								
								<div class="form-group">
									<label for="register-birth-date">Date de naissance</label>
									<input type="text" class="form-control" name="birth-date" id="register-birth-date" tabindex="2" class="form-control" placeholder="Date de naissance" value="">
									<span class="msgError" id="register-birth-date-error">Date incorrecte</span>
								</div>
								<div class="form-group">
									<label for="register-address">Numéro et rue</label>
									<input type="text" name="address" id="register-address" tabindex="2" class="form-control" placeholder="Numéro et rue" value="">
									<span class="msgError" id="register-address-error">Format de l'adresse incorrect</span>
								</div>
								<div class="form-group">
									<label for="register-cp">Code postal</label>
									<input type="text" name="cp" id="register-cp" tabindex="2" class="form-control" placeholder="Code postal" value="">
									<span class="msgError" id="register-cp-error">Code postal incorrect</span>
								</div>
								<div class="form-group">
									<label for="register-town">Ville</label>
									<input type="text" name="town" id="register-town" tabindex="2" class="form-control" placeholder="Ville" value="">
									<span class="msgError" id="register-town-error">Ville incorrecte</span>
								</div>
								<div class="form-group">
									<label for="register-telephone">Numéro de téléphone</label>
									<input type="text" name="telephone" id="register-telephone" tabindex="2" class="form-control" placeholder="Numéro de téléphone" value="">
									<span class="msgError" id="register-telephone-error">Numéro de téléphone incorrect</span>
								</div>
								<br>
								
								<div class="form-group">
									<div class="row">
										<div class="col-sm-6 col-sm-offset-3">
											<input type="submit" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-register" value="Inscription">
										</div>
									</div>
								</div>
							</form>
												
						</div>
					</div>
				</div>
				
			</div>
		</div>
	</div>