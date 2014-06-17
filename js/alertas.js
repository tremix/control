// JavaScript Document
$(document).ready(initUsuarios);

function initUsuarios(){
	$("div#contenido").on("click", "a#nuevo, table#grilla a#editar", function(e){
		$("div#intFormuEmergente").ajaxStop(function(){
			$("input#fechAlerta").datepicker();
		});
		e.preventDefault();
	});	
}