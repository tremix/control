// JavaScript Document
$(document).ready(initPropuestas);

function initPropuestas() {
    $("div#formuEmergente").on("click", "button#guardarAnexo", function() {
        $.ajax({
            url: $(this).val(),
            type: "POST",
            data: $("form#formPropuestasMant").serialize(),
            success: function(datos) {
                $("div#agregarAnexo").html(datos);
                $("div#seguimiento").load("seguimientos.php?idPropuesta=" + $("input#idPropuesta").val());
            },
            error: function() {
                $("div#agregarAnexo").html("<p id='mensaje'>No se pudieron enviar los datos.</p>");
            },
            beforeSend: function() {
                var loading = "";
                loading += "<br /><br /><br /><br /><br />";
                loading += "<br /><br /><br /><br /><br />";
                loading += "<br /><br /><br /><br /><br />";
                loading += "<center><img src='img/loading.gif' /></center>";
                loading += "<p class='loading'>Cargando...</p>";
                $("div#agregarAnexo").html(loading);
            }
        });
    });


    $("div#formuEmergente").on("click", "a#eliminarDif", function(e) {
        if (confirm("\xbfEst\xe1 seguro que desea eliminar el registro?")) {
            $("div#agregarAnexo").load($(this).attr("href") + " p.mensaje", function() {
                $("div#seguimiento").load("seguimientos.php?idPropuesta=" + $("input#idPropuesta").val());
                $(this).show().delay(2500).hide('slow', function() {
                    $(this).html("").show();
                })
            });
        }
        e.preventDefault();
    });
    $("div#formuEmergente").on("change", "select#idCliente", function(e) {
        $("p.mensaje").load("propuestas_mant.php?idCliente=" + $(this).find(":selected").val(), function(datos) {
            $("input#codPropuesta").val($(datos).find("input#codPropuesta").val());
            $("input#correPropuesta").val($(datos).find("input#correPropuesta").val());
        })
                .ajaxStart(mensajeCombo("div#intFormuEmergente", "c&oacute;digo")).ajaxStop(mensajeVacio);
    });
    $("div#formuEmergente").on("click", "a#anexo, a#editarDif", function(e) {
        $("div#agregarAnexo").ajaxStop(function() {
            $("input#sigacSeguimiento").timepicker();
        });
        e.preventDefault();
    });

    $("div#contenido").on("click", "a#nuevo, table#grilla a#editar", function(e) {
        $("div#intFormuEmergente").ajaxStop(function() {
            $("input#fechestiPropuesta, input#fechPropuesta").datepicker({
                changeMonth: true,
                changeYear: true
            });
        });
        e.preventDefault();
    });

    $("div#contenedorGrilla").on("mouseenter", "img#showTrace", function() {
        var pos = $(this).position();
        $("div#showLayer").show().css({left: (pos.left - 65), top: pos.top}).load($(this).attr("name") + " div#show");
    });

    $("div#contenedorGrilla").on("mouseleave", "img#showTrace", function() {
        $("div#showLayer").hide().html("");
    });

    $("div#formuEmergente").on("change", "select#idTipoPropuesta", function(e) {
        $("select#idTipoArea").load("propuestas_mant.php?idTipoPropuesta=" + $(this).find(":selected").val() + " select#idTipoArea option")
                .ajaxStart(mensajeCombo("form#formPropuestasMant", "areas")).ajaxStop(mensajeVacio);
    });
    $("div#formuEmergente").on("change", "select#idTipoArea", function(e) {
        $("select#idTipoServicio").load("propuestas_mant.php?idTipoArea=" + $(this).find(":selected").val() + " select#idTipoServicio option")
                .ajaxStart(mensajeCombo("form#formPropuestasMant", "servicios")).ajaxStop(mensajeVacio);
    });

    $("a#reporte").click(function(e) {
        e.preventDefault();
        window.location = $(this).attr("name") + $("input#txtBuscar").val();
    });

    $("input#linkHidden").ready(function() {
        if ($("input#linkHidden").val() != "") {
            $("div#emergente").fadeIn('slow');
            $("div#formuEmergente").fadeIn('slow');
            $("div#intFormuEmergente").load("propuestas_mant.php?opMant=li&id=" + $("input#linkHidden").val());
        }
    });
}