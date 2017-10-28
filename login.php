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
				</div>
				
				<hr>
				
				<div class="panel-body">
					<div class="row">
						<div class="col-sm-12">
						
							<form id="login-form" action="#" method="post" role="form" style="display:block;">
								<div class="form-group">
									<input type="text" name="username" tabindex="1" class="form-control" placeholder="Nom d'utilisateur" value="">
								</div>
								<div class="form-group">
									<input type="password" id="password" tabindex="2" class="form-control" placeholder="Mot de passe" value="">
								</div>
								
								<br>
								
								<div class="form-group">
									<div class="row">
										<div class="col-sm-6 col-sm-offset-3">
											<input type="submit" name="login-submit" tabindex="3" class="form-control btn btn-login" value="Connexion">
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-sm-12">
											<div class="text-center">
												<a href="#" tabindex="4" class="forgot-password">Mot de passe oublié ?</a>
											</div>
										</div>
									</div>
								</div>
							</form>
							
							<form id="register-form" action="#" method="post" role="form" style="display:none">
								<div class="form-group">
									<input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Nom d'utilisateur" value="">
								</div>
								<div class="form-group">
									<input type="text" name="email" id="email" tabindex="1" class="form-control" placeholder="Email" value="">
								</div>
								<div class="form-group">
									<input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Mot de passe" value="">
								</div>
								<div class="form-group">
									<input type="text" name="confirm-password" id="confirm-password" tabindex="2" class="form-control" placeholder="Confirmer le mot de passe" value="">
								</div>
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