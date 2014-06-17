// JavaScript Document
$(document).ready(initLogin);

function initLogin(){
	$("div#login").hide().fadeIn(1000);	
	$("div#cabeza, div#pie, div#info").hide().show(1000);
	
	$("#user").focus();
	var x = $("#formLogin");
	x.submit(comprobar);
}

function comprobar(){
	if($("#user").attr("value")=="" || $("#pass").attr("value")==""){		
		if($("#user").attr("value")==""){
			msj = "Debe ingresar el usuario. ";
			txt = "#user";
		}
		if($("#pass").attr("value")==""){
			msj = "Debe ingresar la clave.";
			txt = "#pass";
		}		
		if($("#user").attr("value")=="" && $("#pass").attr("value")==""){
			msj = "Debe ingresar el usuario y la clave. ";
			txt = "#user";
		}
		alert(msj);
		$(txt).focus();
		return false;
	}else{
		return true;
	}
}