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
						
							<form id="login-form" action="#" method="post" role="form" style="display:block;">
								<div class="form-group">
									<input type="text" name="username" id="login-username" tabindex="1" class="form-control" placeholder="Nom d'utilisateur" value="">
								</div>
								<div class="form-group">
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
							
								<!-- Gerer envoie de mail si mot de passe perdu ? (necessite de configurer wamp)
								<div class="form-group">
									<div class="row">
										<div class="col-sm-12">
											<div class="text-center">
												<a href="#" tabindex="4" class="forgot-password">Mot de passe oublié ?</a>
											</div>
										</div>
									</div>
								</div>
								-->
							</form>
							
							<form id="register-form" action="#" method="post" role="form" style="display:none">
								<div class="form-group">
									<input type="text" name="register-username" id="register-username" tabindex="1" class="form-control" placeholder="Nom d'utilisateur" value="">
									<span class="msgError" id="register-username-error">Nom d'utilisateur incorrect</span>
								</div>
								<div class="form-group">
									<input type="text" name="email" id="register-email" tabindex="1" class="form-control" placeholder="Email" value="">
									<span class="msgError" id="register-email-error">Email incorrect</span>
								</div>
								<div class="form-group">
									<input type="password" name="password" id="register-password" tabindex="2" class="form-control" placeholder="Mot de passe" value="">
									<span class="msgError" id="register-password-error">Le mot de passe doit contenir 1 minuscule, 1 majuscule, 1 chiffre, 1 caractère spécial et au moins 6 caractères</span>
								</div>
								<div class="form-group">
									<input type="password" name="confirm-password" id="register-confirm-password" tabindex="2" class="form-control" placeholder="Confirmer le mot de passe" value="">
									<span class="msgError" id="register-confirm-password-error">Les mots de passe ne sont pas identiques</span>
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