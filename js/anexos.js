// JavaScript Document
$(document).ready(function(){
	$("div#intFormuEmergente").on("click", "table#grilla a#editar, table#grilla a#eliminar", function(e){
		$("div#emergente").fadeIn('slow');
		$("div#formuEmergente").fadeIn('slow');
		$("div#intFormuEmergente").load($(this).attr("href"));
		e.preventDefault();
	});	
	$("div#intFormuEmergente").on("click", "button#guardarAnexo", function(){
		$.ajax({
				url: $("div#intFormuEmergente form").attr("action"), 
				type: "POST",
				data: $("div#intFormuEmergente form").serialize(), 
				success: function(datos){$("div#intFormuEmergente").html(datos);},			   
				error: function(){$("div#intFormuEmergente").html("<p id='mensaje'>No se pudieron enviar los datos.</p>");},
				beforeSend: function(){
					var loading = "";
					loading += "<br /><br /><br /><br /><br />";
					loading += "<br /><br /><br /><br /><br />";
					loading += "<br /><br /><br /><br /><br />";
					loading += "<center><img src='img/loading.gif' /></center>";
					loading += "<p class='loading'>Cargando...</p>";
					$("div#intFormuEmergente").html(loading);
				}
		});
	});
});