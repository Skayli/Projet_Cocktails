$(document).ready(function() {
	
	$("pre code").each(function(){
		var html = $(this).html();
		var pattern = html.match(/\s*\n[\t\s]*/);
		$(this).html(html.replace(new RegExp(pattern, "g"),'\n'));
	});

	//Permet d'avoir un aliment
	$("#get-aliment #li-sousCategorie").click(function(){
		$("#search-aliment").val($(this).attr("value"));
		alert("Vous avez choisi : " + $("#search-aliment").val());
	});
		
		
		
	$('.li-submenu').mousedown(function(e) {
		
	});

	$('.li-submenu').click(function(e) {
		
	});

});