// JavaScript Document
$(document).ready(initGeneral);

function initGeneral() {
    $("div#contenido").on("click", "a#nuevo, table#grilla a#editar", function(e) {
        $("div#emergente").fadeIn('slow');
        $("div#formuEmergente").fadeIn('slow');
        $("div#intFormuEmergente").load($(this).attr("href"));
        e.preventDefault();
    });
    $("div#contenido").on("click", "a#eliminar", function(e) {
        if (confirm("\xbfEst\xe1 seguro que desea eliminar el registro?")) {
            $("p.mensaje").load($(this).attr("href") + " p.mensaje", function() {
                $(this).show().delay(10000).hide('slow', function() {
                    $(this).html("").show();
                });
                refrescarGrilla();
            });
        }
        e.preventDefault();
    });
    $("div#contenido").on("click", "button#buscarGrilla", function() {
        refrescarGrilla();
    });
    $("div#contenido").on("keypress", "input#txtBuscar", function(e) {
        if (e.keyCode == 13) {
            refrescarGrilla();
            e.preventDefault();
        }
    });
    $("img#close, div#emergente").on("click", function(e) {
        cerrarEmergente();
        e.preventDefault();
    });
    $("div#intFormuEmergente").on("click", "button#cancelar", function(e) {
        cerrarEmergente();
        refrescarGrilla();
        e.preventDefault();
    });
    $("div#intFormuEmergente").on("click", "button#guardar", function() {
        $.ajax({
            url: $("div#intFormuEmergente form").attr("action"),
            type: "POST",
            data: $("div#intFormuEmergente form").serialize(),
            success: function(datos) {
                $("div#intFormuEmergente").html(datos);
                refrescarGrilla();
            },
            error: function() {
                $("div#intFormuEmergente").html("<p id='mensaje'>No se pudieron enviar los datos.</p>");
            },
            beforeSend: function() {
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

    $("div#formuEmergente").on("click", "a#anexo, a#editarDif", function(e) {
        $("div#agregarAnexo").hide().load($(this).attr("href"), function() {
            $(this).slideDown('slow');
        });
        e.preventDefault();
    });

    $("div#formuEmergente").on("click", "button#cancelarAnexo", function(e) {
        $("div#agregarAnexo").slideUp('slow', function() {
            $(this).html("").show();
        });
        e.preventDefault();
    });
}

function cerrarEmergente() {
    $("div#emergente").fadeOut('slow');
    $("div#formuEmergente").fadeOut('slow', function() {
        $("div#intFormuEmergente").html("");
    });
}

function mensajeCombo(selector, adicional) {
    var loading = "";
    loading += "<img src='img/loading.gif' width='24' height='24' /> Cargando " + adicional + "...";
    $(selector + " p.mensaje").html(loading);
}

function mensajeVacio() {
    $("p.mensaje").html("");
}