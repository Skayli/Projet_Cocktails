$(document).ready(function() {
	
	$.ajaxSetup({ cache: false });
	$('#register-cp').mask("99999");
	$('#register-telephone').mask("99 99 99 99 99");
	
/* PARTIE ACCUEIL*/	
	//Mise en forme des balise pre & code (sera surement inutile plus tard)
	$("pre code").each(function(){
		var html = $(this).html();
		var pattern = html.match(/\s*\n[\t\s]*/);
		$(this).html(html.replace(new RegExp(pattern, "g"),'\n'));
	});

	//Permet d'avoir un aliment (via l'input HIDDEN de la navbar)
	$(".getCategorie").click(function(event){
		event.stopPropagation();
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
		//Initialisation du format de l'input 'birth-date'
		$(function () {
            $('#register-birth-date').datetimepicker({
				format: 'DD/MM/YYYY',
				viewMode: 'years',
				showClear: true,
				maxDate: $.now(),
				minDate: new Date(1900,1,1),
			});
			
			$('#register-birth-date').val('');

			$('#data-dateNaissance').datetimepicker({
				format: 'DD/MM/YYYY',
				viewMode: 'days',
				showClear: true,
				maxDate: $.now(),
				minDate: new Date(1900,1,1),
				useCurrent: false
			});
				
        });

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
		
		//Cette fonction permet d'enlever les message d'erreur présent sur le formulaire 'INSCRIPTION'
		$('.form-control').focus(function() {
			$(this).next("span").css('display', 'none');
		});
		
		$('.register-switch').click(function() {
			$('#register-gender-error').css('display','none');
		});
	
		//Validation du formulaire "INSCRIPTION"
		$('#register-form').submit(function(e) {
			var form = this;
			
			$("#register-username").blur();
			$("#register-forename").blur();
			$("#register-name").blur();
			$("#register-email").blur();
			$("#register-password").blur();
			$("#register-confirm-password").blur();
			$('#register-birth-date').blur();
			$('#register-address').blur();
			$('#register-cp').blur();
			$('#register-town').blur();
			$('#register-telephone').blur();
			
			
			//On empeche le formulaire de se valider
			e.preventDefault();
			
			//Recupération des données pour les valider nous meme
			var username = $('#register-username').val();
			var forename = $('#register-forename').val();
			var name = $('#register-name').val();
			var gender = $("input[name=switch-gender]:checked").val();
			var email = $('#register-email').val();
			var password = $('#register-password').val();
			var confirmPassword = $('#register-confirm-password').val();
			
			//Verification que l'utilisateur n'est pas deja inscrit
			var isUsernameOrEmaiNotlAlreadyUsed = checkDataBaseForUsernameAndEmail(username,email);
			
			var dateNaissance = $('#register-birth-date').val();
			var adresse = $('#register-address').val();
			var codePostal = $('#register-cp').val();
			var ville = $('#register-town').val();
			var telephone = $('#register-telephone').val();
			
			//Si tout est bon, on enregistre les données, on affiche le bon déroulement des opérations et on retourne à la page d'accueil
			if(isUsernameOK(username) && isForenameOk(forename) && isNameOk(name) && isGenderSet(gender) && isEmailOk(email) && isPasswordSafeEnough(password) && passwordAreIdentical(password, confirmPassword) && isUsernameOrEmaiNotlAlreadyUsed && isDateNaissanceOk(dateNaissance) && isAdresseOk(adresse) && isCPOk(codePostal) && isVilleOk(ville) && isTelephoneOk(telephone))
			{
				saveDataIntoJSONFile(username, forename, name, gender, email, password, dateNaissance, adresse, codePostal, ville, telephone); //Sauvegarde dans 'user.json'
				
				
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
				console.log("username -> " + 						isUsernameOK(username));
				console.log("forename -> " + 						isUsernameOK(forename));
				console.log("name -> " + 							isUsernameOK(username));
				console.log("gender ->" + 							isGenderSet(gender));
				console.log("email -> "+ 							isEmailOk(email));
				console.log("password strengh -> " + 				isPasswordSafeEnough(password));
				console.log("arePasswordIdentical ? -> " + 			passwordAreIdentical(password, confirmPassword));
				console.log("isUsernameOrEmaiNotlAlreadyUsed -> " + isUsernameOrEmaiNotlAlreadyUsed);
				console.log("dateNaissance -> " + 					isDateNaissanceOk(dateNaissance));
				console.log("adresse -> " + 						isDateNaissanceOk(dateNaissance));
				console.log("codePostal -> " + 						isCPOk(codePostal));
				console.log("ville -> " + 							isVilleOk(ville));
				console.log("telephone -> " + 						isTelephoneOk(telephone));
				
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
					displayIfNeeded(isUsernameOK(username), 						 $("#register-username-error")); 		//username
					displayIfNeeded(isForenameOk(forename),							 $("#register-forename-error"));		//forename
					displayIfNeeded(isNameOk(name),									 $("#register-name-error"));			//name
					displayIfNeeded(isGenderSet(gender),							 $("#register-gender-error"));			//gender
					displayIfNeeded(isEmailOk(email), 								 $("#register-email-error"));			//email
					displayIfNeeded(isPasswordSafeEnough(password), 				 $("#register-password-error"));		//password
					displayIfNeeded(passwordAreIdentical(password, confirmPassword), $("#register-confirm-password-error"));//confirm password
					displayIfNeeded(isDateNaissanceOk(dateNaissance), 				 $("#register-birth-date-error"));		//birth date
					displayIfNeeded(isAdresseOk(adresse), 							 $("#register-address-error"));			//address
					displayIfNeeded(isCPOk(codePostal), 							 $("#register-cp-error"));				//cp
					displayIfNeeded(isVilleOk(ville), 								 $("#register-town-error"));			//town
					displayIfNeeded(isTelephoneOk(telephone), 						 $("#register-telephone-error"));		//telephone
				}
			}
				
		});
		
		//Verifie le format du nom d'utilisateur
		function isUsernameOK(username) 
		{
			var patternUsername = /^[a-záàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ]*\-?[a-záàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ]{2,}$/i;
			return username.match(patternUsername);
		}
		
		function isForenameOk(forname)
		{
			var patternForname = /^[a-záàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ]*\-?[a-záàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ]{2,}$/i;
			return forname.match(patternForname);
		}
		
		function isNameOk(name)
		{
			var patternName = /^[a-záàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ]+([\-\'\s]?[a-záàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ]{2,})+$/i;
			return name.match(patternName);
		}
		
		function isGenderSet(gender)
		{
			if(gender.length > 0)
				return true;
			
			return false;
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
		
		//Verifie que la date de naissance est OK
		function isDateNaissanceOk(dateNaissance) 
		{
			var patternDate = /(^(((0[1-9]|1[0-9]|2[0-8])[\/](0[1-9]|1[012]))|((29|30|31)[\/](0[13578]|1[02]))|((29|30)[\/](0[4,6,9]|11)))[\/](19|[2-9][0-9])\d\d$)|(^29[\/]02[\/](19|[2-9][0-9])(00|04|08|12|16|20|24|28|32|36|40|44|48|52|56|60|64|68|72|76|80|84|88|92|96)$)/;
			
			return dateNaissance.match(patternDate);
		}
		
		//Verifie que l'adresse (numero et rue) est OK
		function isAdresseOk(adresse)
		{
			var patternAdresse = /^[0-9]{1,4}[?:(?:[\,\. ]{1,2}(rue|impasse|allee|allée|boulevard|av|av.|bvd|bvd.){1}[a-zA-Zàâäéèêëïîôöùûüç\s]{2,}$/;
			
			return adresse.match(patternAdresse);
		}
		
		//Verifie que le code postal est Ok
		function isCPOk(codePostal)
		{
			return codePostal.length == 5;
		}
		
		//Verifie que le nom de la ville est Ok
		function isVilleOk(ville)
		{
			var patternVille = /^[a-záàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ]{2,}([\s\-]?[a-záàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ])*$/i;
			
			return ville.match(patternVille);
		}
		
		//Verifie que le numéro de téléphon est Ok
		function isTelephoneOk(telephone)
		{
			var patternTelephone = /^(0|\+33)[1-9]([-. ]?[0-9]{2}){4}$/;
			
			return telephone.match(patternTelephone);
		}

		//Sauvegarde les données dans le fichier 'users.json'
		function saveDataIntoJSONFile(username, forename, name, gender, email, password, dateNaissance, adresse, codePostal, ville, telephone)
		{
			$.ajax({
				type:"GET",
				url: 'saveJson.php',
				dataType:'json',
				data: { username:username, forename:forename, name:name, gender:gender, email:email, password:password, dateNaissance:dateNaissance, adresse:adresse, codePostal:codePostal, ville:ville, telephone:telephone },
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
				messageError.css("display", "none");
			} else {
				messageError.css("display","inline-block");
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
	
	$('#back-to-top').tooltip({shown:"ready"});
	$('.pretty-checkbox').tooltip({shown:"ready"});
	

	$('.pretty-checkbox').click(function() {
		var indexCocktail = $(this).prop('id').split('-');
		
		$(this).tooltip('hide');
		$(this).blur();
		
		if($(this).prop('checked'))
		{
			console.log("Ajout du cocktail à l'index " + indexCocktail[1]);
			$(this).attr("title","Retirer des favoris").tooltip("fixTitle");
			
			$.ajax({
				type:"GET",
				url: 'updateCocktails.php',
				dataType: 'json',
				async: false,
				data: { ajoutCocktail:indexCocktail[1] },
				success:function() {alert("OK"); },
				failure:function() {alert("Error!"); }
			});
			
		} else {
			console.log("Retrait du cocktail à l'index " +  indexCocktail[1]);
			$(this).attr("title", "Ajouter aux favoris").tooltip("fixTitle");
			
			$.ajax({
				type:"GET",
				url: 'updateCocktails.php',
				dataType: 'json',
				async: false,
				data: { retireCocktail:indexCocktail[1] },
				success:function() {alert("OK"); },
				failure:function() {alert("Error!"); }
			});
		}
		
		
	});
	
	$("#cocktailsPreferes").click(function() {
		console.log("click");
	});
	
/* PARTIE USERDATA */
	$("#display-data-input").click(function() {
		
		$(".data-input").each(function() {
			$(this).css('display','block');
		});
		
		$(".data-display").each(function() {
			$(this).css('display','none');
		});
		
		$("html, body").stop().animate({scrollTop:0}, 500);
	});
	
	$("#cancel-data").click(function() {
		
		$(".data-input").each(function() {
			$(this).css('display','none');
		});
		
		$(".data-display").each(function() {
			$(this).css('display','block');
		});
		
		$("html, body").stop().animate({scrollTop:0}, 500);
	});
	
	function isNewPasswordOk(oldUsername, newCurrentPassword, newNewPassword, newConfirmPassword) {
		var check = false;
		var checkOldPassword = false;

			if(newCurrentPassword.length != 0 || newNewPassword.length != 0 || newConfirmPassword.length != 0) {
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
							$.each(data, function(user, details) {
								if(oldUsername.toLowerCase() == details["username"].toLowerCase() && newCurrentPassword == details["password"])
								{
									checkOldPassword = true;
								} 
							});
						}
					});
			
				if(checkOldPassword && isPasswordSafeEnough(newNewPassword) && passwordAreIdentical(newNewPassword, newConfirmPassword)) {
					check = true;
				}
		
				return check;
			} else {
				return true;
			}
	}
	
	function isUsernameAlreadyUsed(oldUsername, newUsername) {
		var isUsernameAlreadyUsed = false;
		
		if(oldUsername.toLowerCase() != newUsername.trim().toLowerCase()) {
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
					$.each(data, function(user, details) {
						if(newUsername.trim().toLowerCase() == details["username"].toLowerCase()) {
							isUsernameAlreadyUsed = true;
						}
					});
				}
			});
		}

		
		return !isUsernameAlreadyUsed;
			
	}
	
	$("#save-data").click(function() {
		var oldUsername = $("#data-old-username").val();
		var newUsername = $("#data-username").val();
		var newForename = $("#data-forename").val();
		var newName = $("#data-name").val();
		var newGender = $("input[name=switch-gender]:checked").val();
		var newEmail = $("#data-email").val();
		var newCurrentPassword = $("#data-password-current").val();
		var newNewPassword = $("#data-password-new").val();
		var newConfirmPassword = $("#data-password-new-confirm").val();
		var newDateNaissance = $("#data-dateNaissance").val();
		var newAdresse = $("#data-adresse").val();
		var newCp = $("#data-cp").val();
		var newVille = $("#data-ville").val();
		var newTelephone = $("#data-telephone").val();
		
		console.clear();
	/* 	console.log(isUsernameOK(newUsername));
		console.log(isForenameOk(newForename));
		console.log(isNameOk(newName));
		console.log(isGenderSet(newGender));
		console.log(isEmailOk(newEmail));
		console.log(oldUsername);
		
		console.log(isNewPasswordOk(oldUsername, newCurrentPassword,newNewPassword, newConfirmPassword));
		
		console.log(isDateNaissanceOk(newDateNaissance));
		console.log(isAdresseOk(newAdresse));
		console.log(isCPOk(newCp));
		console.log(isVilleOk(newVille));
		console.log(isTelephoneOk(newTelephone)); */
		console.log(newUsername);
		 if(isUsernameOK(oldUsername) && isUsernameAlreadyUsed(oldUsername, newUsername) && isForenameOk(newForename) && isNameOk(newName) && isGenderSet(newGender) && isEmailOk(newEmail) && isNewPasswordOk(oldUsername, newCurrentPassword,newNewPassword, newConfirmPassword) && isDateNaissanceOk(newDateNaissance) && isAdresseOk(newAdresse) && isCPOk(newCp) && isVilleOk(newVille) && isTelephoneOk(newTelephone)) {
			console.log("ok");
		} else {
			console.log("non ok");
		}
		

	});
});

		