$(document).ready(function() {
	
/* PARTIE ACCUEIL*/	
	//Mise en forme des balise pre & code (sera surement inutile plus tard)
	$("pre code").each(function(){
		var html = $(this).html();
		var pattern = html.match(/\s*\n[\t\s]*/);
		$(this).html(html.replace(new RegExp(pattern, "g"),'\n'));
	});

	//Permet d'avoir un aliment (via l'input HIDDEN de la navbar)
	$("#get-aliment #li-sousCategorie").click(function(){
		$("#search-aliment").val($(this).attr("value"));
		alert("Vous avez choisi : " + $("#search-aliment").val());
	});
	
	//Gestion du bouton de la navbar surligné
	$(".btn-navbar").click(function(e) {
		$(".btn-navbar").removeClass('active');
		$(this).addClass("active");
	});
	
	//Changement de page : envoie de la page via la valeur du bouton cliqué et soumission du formulaire "changePage" afin de charger le bon 'include'
	$(".btn-changePage").click(function(e) {
		$("#changePage").find('input[name="page"]').val($(this).attr("value"));
		$("#changePage").submit();
	});
	
/* PARTIE LOGIN */

		$('#login-form-link').click(function(e) {
			$("#login-form").delay(100).fadeIn(100);
			$("#register-form").fadeOut(100);
			$('#register-form-link').removeClass('active');
			$(this).addClass('active');
			e.preventDefault();
		});
		
		$('#register-form-link').click(function(e) {
			$("#register-form").delay(100).fadeIn(100);
			$("#login-form").fadeOut(100);
			$('#login-form-link').removeClass('active');
			$(this).addClass('active');
			e.preventDefault();
		});
		
		$('#login-form').submit(function() {
			var username = $('#login-username').val();
			var password = $('#login-password').val();
			
			return false;
		});
	
		//Validation du formulaire "INSCRIPTION"
		$('#register-form').submit(function(e) {
			var form = this;
			
			e.preventDefault();
			
			var username = $('#register-username').val();
			var email = $('#register-email').val();
			var password = $('#register-password').val();
			var confirmPassword = $('#register-confirm-password').val();
			
			var isUsernameOrEmaiNotlAlreadyUsed = checkDataBaseForUsernameAndEmail(username,email);
			
			if(isUsernameOK(username) && isEmailOk(email) && isPasswordSafeEnough(password) && passwordAreIdentical(password, confirmPassword) && isUsernameOrEmaiNotlAlreadyUsed)
			{
				saveDataIntoJSONFile(username, email, password);
				
				swal({
				  type: 'success',
				  title: 'Inscription complète !',
				  showConfirmButton: true,
				  focusConfirm: true,
				  confirmButtonText : "Retour à la page d'accueil",
				  allowOutsideClick:false
				}).then(function() {
					setTimeout(function () {
						form.submit();
					}, 500);
				})

			} else {
						
				e.preventDefault();
				
				console.clear();
				console.log("username -> "+isUsernameOK(username));
				console.log("email -> "+isEmailOk(email));
				console.log("password strengh -> " + isPasswordSafeEnough(password));
				console.log("arePasswordIdentical ? -> " + passwordAreIdentical(password, confirmPassword));
				console.log("isUsernameOrEmaiNotlAlreadyUsed -> " + isUsernameOrEmaiNotlAlreadyUsed);
				
				swal(
				  'Oops...',
				  'Verifiez vos informations !',
				  'error'
				)
			
			}
				
		});
		
		function isUsernameOK(username) 
		{
			var patternUsername = /^[a-záàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ]*\-?[a-záàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ]{2,}$/i;
			return username.match(patternUsername);
		}
		
		function isEmailOk(email)
		{
			var patternMail = /^(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])$/;
			
			return email.match(patternMail);
		}
		
		//Verifie si un password est assez fort (6 caractères mini, 1 minuscule, 1 majuscule, 1 chiffre et 1 caractère spécial(parmi !@#$^&%*()+=-[]/\:<>?,._))
		function isPasswordSafeEnough(password)
		{
			var patternPasswordStrengh = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\!\@\#\$\^\&\%\*\(\)\+\=\-\[\]\\\/\{\}\|\:\<\>\?\,\.\_\€])(?=.{6,})/;
			
			return password.match(patternPasswordStrengh);
		}
		
		function passwordAreIdentical(password, confirmPassword)
		{
			if(password.length > 5 && confirmPassword.length > 5)
			{
				return password == confirmPassword;
			} else {
				return false;
			}
		}

		function saveDataIntoJSONFile(username,email,password)
		{
			$.ajax({
				type:"GET",
				url: 'saveJson.php',
				dataType:'json',
				data: { username:username, email:email, password:password },
				success:function() {alert("OK"); },
				failure:function() {alert("Error!"); }
			});
		}
		
		function checkDataBaseForUsernameAndEmail(username, email)
		{	
			var check = false;
					$.ajax ({
						'async':false,
						'global':false,
						'url': 'users.json',			
						'success': function(data) {
							
							$.each(data, function(user, userObject) {
								
								$.each(userObject, function(userObject, userDetails) {
									
									if(username.toLowerCase() == userDetails["username"].toLowerCase() || email.toLowerCase() == userDetails["email"])
									{
										console.log("test");
										check = true;
									}
									
								});					
								
							});
						}
					});
			return !check;
		}
		
/* PARTIE COCKTAILS */
});
