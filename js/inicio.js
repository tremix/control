// JavaScript Document
$(document).ready(initInicio);
function initInicio(){
	setInterval(refrescarAlertas, 60000);
	$("img#refrescarAlerta").on("click", refrescarAlertas);
	$("div#principalAlerta").on("click", "a#accionAlerta", function(e){
		$("div#principalAlerta p.mensaje").load($(this).attr("href") + " p.mensaje span", function(){
			refrescarAlertas();
		   $(this).show().delay(2000).hide('slow', function(){
				$(this).html("").show();
			});
		});
		e.preventDefault();
	});
	$("div#principalAlerta").on("click", "a[target='_blank']", function(e){
		var dir = $(this).parent('td').parent('tr').find('a#accionAlerta').attr('href');
		$("div#principalAlerta p.mensaje").load(dir + " p.mensaje span", function(){
			refrescarAlertas();
		   $(this).show().delay(2000).hide('slow', function(){
				$(this).html("").show();
			});
		});
	});
}

function refrescarAlertas(){
	$("div#contenedorAlerta").load('inicio.php div#contenedorAlerta table');
	$("div#contenedorAlerta").ajaxStart(function(){
		var loading = "";
		loading += "<br /><br /><br /><br /><br />";
		loading += "<img src='img/loading.gif' />";
		loading += "<p class='loading'>Cargando...</p>";
		$("div#contenedorAlerta").html(loading);
	});
}