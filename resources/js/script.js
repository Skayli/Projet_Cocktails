$(document).ready(function() {
	
	$.ajaxSetup({ cache: false });
	
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
		
		//Formulaire de connexion
		$('#login-form').submit(function(e) {
			e.preventDefault();
				
			var form = this;
			var username = $('#login-username').val();
			var password = $('#login-password').val();
			
			if(!checkDataBaseForConnexion(username, password))
			{
				
				swal({
					title: '<i>Erreur de connexion</i>',
					type: 'error',
					html: "Connexion refusée : vérifiez login et mot de passe",
					showCloseButton: true,
					showCancelButton: false,
					focusConfirm: true,
					confirmButtonText: "Oops ..."
				})
			} else {
				swal({												//Alerte : succes de l'enregistement
				  type: 'success',
				  title: 'Bienvenue '+ username.toLowerCase().replace(/(^|\s|\-)([a-zéèêë])/g,function(u,v,w){return v+w.toUpperCase()}),
				  showConfirmButton: true,
				  focusConfirm: true,
				  confirmButtonText : "Retour à la page d'accueil",
				  allowOutsideClick:false
				}).then(function() {
					$.ajax ({
						'type':  'POST',
						'async': true,
						'url':   'index.php',
						'global':false,
						'dataType' : 'text',
						'data': { connecte:username },
						'success': function() {
							setTimeout(function () {
								form.submit();
							}, 500);
						}
					});
					
					
					
				})
			}
		});
		
		//Bouton de deconnexion : affichage d'une alert pour valider 
		$("#btn-deconnexion").click(function() {
			swal({
				title: 'Vous partez déjà ?',
				type: 'warning',
				focusCancel: true,
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: "Oui, on m'attend quelque part",
				cancelButtonText: 'Non, je reste encore un peu',
				allowOutsideClick: false,
			}).then(function () {		//Si deconnexion => destruction de tous les cookies et retrour à la page d'accueil
				$.each($.cookie(), function(key,val) {
					document.cookie = key + '=; Max-Age=0'
				});
				
				setTimeout(function() {
					location.href = location.pathname
				},100);
				
			}, function (dismiss) { //Sinon, on recharche la page
			  // dismiss can be 'cancel', 'overlay',
			  // 'close', and 'timer'
			  if (dismiss === 'cancel') {
				setTimeout(function () {
						location.reload();
				}, 100);
			  }
			  
			})	
		});
		
		//Ces fonctions permettent d'enlever les message d'erreur présent sur le formulaire 'INSCRIPTION'
		$('#register-username').focus(function() {
			document.getElementById("register-username-error").style.display="none";
		});
		
		$('#register-email').focus(function() {
			document.getElementById("register-email-error").style.display="none";
		});
		
		$('#register-password').focus(function() {
			document.getElementById("register-password-error").style.display="none";
		});
		
		$('#register-confirm-password').focus(function() {
			document.getElementById("register-confirm-password-error").style.display="none";
		});
	
		//Validation du formulaire "INSCRIPTION"
		$('#register-form').submit(function(e) {
			var form = this;
			
			$("#register-username").blur();
			$("#register-email").blur();
			$("#register-password").blur();
			$("#register-confirm-password").blur();
			
			//On empeche le formulaire de se valider
			e.preventDefault();
			
			//Recupération des données pour les valider nous meme
			var username = $('#register-username').val();
			var email = $('#register-email').val();
			var password = $('#register-password').val();
			var confirmPassword = $('#register-confirm-password').val();
			
			//Verification que l'utilisateur n'est pas deja inscrit
			var isUsernameOrEmaiNotlAlreadyUsed = checkDataBaseForUsernameAndEmail(username,email);
			
			//Si tout est bon, on enregistre les données, on affiche le bon déroulement des opérations et on retourne à la page d'accueil
			if(isUsernameOK(username) && isEmailOk(email) && isPasswordSafeEnough(password) && passwordAreIdentical(password, confirmPassword) && isUsernameOrEmaiNotlAlreadyUsed)
			{
				saveDataIntoJSONFile(username, email, password); //Sauvegarde dans 'user.json'
				
				
				swal({												//Alerte : succes de l'enregistement
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
				
			//Sinon, on affiche dans la console les soucis (debug) et on affiche une alerte qu'il y a un probleme (à modifier encore)
			} else {
				
				//debug
				console.log("username -> "+isUsernameOK(username));
				console.log("email -> "+isEmailOk(email));
				console.log("password strengh -> " + isPasswordSafeEnough(password));
				console.log("arePasswordIdentical ? -> " + passwordAreIdentical(password, confirmPassword));
				console.log("isUsernameOrEmaiNotlAlreadyUsed -> " + isUsernameOrEmaiNotlAlreadyUsed);
				
				if(!isUsernameOrEmaiNotlAlreadyUsed) //cas ou l'utilisateur est deja connu
				{
					swal({			
						title: '<i>Vous êtes déjà inscrits ?</i>',
						type: 'question',
						html:
							"Le nom d'utilisateur ou l'email est deja utilisé !",
						showCloseButton: true,
						showCancelButton: false,
						focusConfirm: true,
						confirmButtonText:
							"Ok"
					})
				} else {		//Sinon on affiche les informations à corriger
					swal({
						title: '<i>Renseignements Incorrects</i>',
						type: 'error',
						html:"Veuillez remplir le formulaire correctement",
						showCloseButton: true,
						showCancelButton: false,
						focusConfirm: true,
						confirmButtonText: "Compris !"
					})
					
					//Affichage des messages d'erreurs de chaque input concerné
					displayIfNeeded(isUsernameOK(username), document.getElementById("register-username-error"));
					displayIfNeeded(isEmailOk(email), document.getElementById("register-email-error"));
					displayIfNeeded(isPasswordSafeEnough(password), document.getElementById("register-password-error"));
					displayIfNeeded(passwordAreIdentical(password, confirmPassword), document.getElementById("register-confirm-password-error"));
				}
			}
				
		});
		
		//Verifie le format du nom d'utilisateur
		function isUsernameOK(username) 
		{
			var patternUsername = /^[a-záàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ]*\-?[a-záàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ]{2,}$/i;
			return username.match(patternUsername);
		}
		
		//Vérifie le format du mail de l'utilisateur
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
		
		//Verifie que les 2 mots de passe sont identiques
		function passwordAreIdentical(password, confirmPassword)
		{
			if(password.length > 5 && confirmPassword.length > 5)
			{
				return password == confirmPassword;
			} else {
				return false;
			}
		}

		//Sauvegarde les données dans le fichier 'users.json'
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
		
		//Vérifie qu'un username/email n'est pas deja present dans la "Base de Données" avant l'enregistrement
		function checkDataBaseForUsernameAndEmail(username, email)
		{	
			var check = false;
			
					$.ajax ({
						'global':false,
						'async':false,
						'cache':false,
						headers: {
							'Cache-Control': 'no-cache, no-store, must-revalidate', 
							'Pragma': 'no-cache', 
							'Expires': '0'
						},
						'url': 'users.json',
						'dataType':'json',
						'cache':'false',
						'success': function(data) {
							console.log(data);
							$.each(data, function(user, details) {
								if(username.toLowerCase() == details["username"].toLowerCase() || email.toLowerCase() == details["email"].toLowerCase())
								{
									check = true;
								}
							});
						}
					});
		
			return !check;
		}
		
		//Affiche le message d'erreur selon que l'état du booleen
		function displayIfNeeded(isOk, messageError)
		{
			if(isOk) {
				messageError.style.display = "none";
			} else {
				messageError.style.display = "inline-block";
			}
		}
		
		//Verifie que la connexion est correcte (que username et password correspondent)
		function checkDataBaseForConnexion(username, password)
		{
			var check = false;
			
					$.ajax ({
						'async':false,
						'global':false,
						'cache':false,
						headers: {
							'Cache-Control': 'no-cache, no-store, must-revalidate', 
							'Pragma': 'no-cache', 
							'Expires': '0'
						},
						'url': 'users.json',
						'dataType':'json',
						'cache':'false',
						'success': function(data) {
							console.log(data);
							$.each(data, function(user, details) {
								if(username.toLowerCase() == details["username"].toLowerCase() && password == details["password"])
								{
									check = true;
								}			
							});
						}
					});
					
			return check;
		}
		
/* PARTIE COCKTAILS */
	$(window).scroll(function () {
		if ($(this).scrollTop() > 50) {
			$('#back-to-top').fadeIn();
		} else {
			$('#back-to-top').fadeOut();
		}
	});
	// scroll body to 0px on click
	$('#back-to-top').click(function () {
		$('#back-to-top').tooltip('hide');
		$('body,html').animate({
			scrollTop: 0
		}, 800);
		return false;
	});
	
	$('#back-to-top').tooltip('show');
	
	$('.pretty-checkbox').click(function() {
		var indexCocktail = $(this).prop('id').split('-');
		
		if($(this).prop('checked'))
		{
			console.log("Ajout du cocktail à l'index " + indexCocktail[1]);
			$.ajax({
				type:"GET",
				url: 'updateCocktails.php',
				dataType: 'json',
				data: { ajoutCocktail:indexCocktail[1] },
				success:function() {alert("OK"); },
				failure:function() {alert("Error!"); }
			});
		} else {
			console.log("Retrait du cocktail à l'index " +  indexCocktail[1]);
		}
	});
	
});

		