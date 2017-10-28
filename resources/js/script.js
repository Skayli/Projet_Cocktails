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
	
	$(".btn-changePage").click(function(e) {
		$("#changePage").find('input[name="page"]').val($(this).attr("value"));
		$("#changePage").submit();
	});
	
/* PARTIE LOGIN */
	$(function() {

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

	});


/* PARTIE COCKTAILS */
});
