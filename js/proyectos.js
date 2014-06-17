// JavaScript Document
$(document).ready(initProyectos);

function initProyectos() {

    $("div#formuEmergente").on("click", "button#guardarAnexo", function() {
        $.ajax({
            url: $(this).val(),
            type: "POST",
            data: $("form#formProyectosMant").serialize(),
            success: function(datos) {
                $("div#agregarAnexo").html(datos);
                $("div#proyectoEtapa").load("proyectoEtapas.php?idProyecto=" + $("input#idProyecto").val());
                $("div#proyectoActividad").load("proyectoActividades.php?idProyecto=" + $("input#idProyecto").val());
                $("div#responsable").load("responsables.php?idProyecto=" + $("input#idProyecto").val());
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
                $("div#proyectoEtapa").load("proyectoEtapas.php?idProyecto=" + $("input#idProyecto").val());
                $("div#proyectoActividad").load("proyectoActividades.php?idProyecto=" + $("input#idProyecto").val());
                $("div#responsable").load("responsables.php?idProyecto=" + $("input#idProyecto").val());
                $(this).show().delay(2500).hide('slow', function() {
                    $(this).html("").show();
                });
            });
        }
        e.preventDefault();
    });

    $("div#formuEmergente").on("click", "a#anexo, a#editarDif", function(e) {
        $("div#agregarAnexo").ajaxStop(function() {
            $("input#fechaInicioProyectoActividad, input#fechaFinalProyectoActividad").datepicker({
                changeMonth: true,
                changeYear: true
            });
        });
        e.preventDefault();
    });

    $("div#formuEmergente").on("change", "select#idEtapaAux", function(e) {
        $("select#idActividad").load("proyectoActividades_mant.php?idEtapaAux=" + $(this).find(":selected").val() + " select#idActividad option")
                .ajaxStart(mensajeCombo("div#agregarAnexo", "actividades")).ajaxStop(mensajeVacio);
    });

    $("input#linkHidden").ready(function() {
        if ($("input#linkHidden").val() != "") {
            $("div#emergente").fadeIn('slow');
            $("div#formuEmergente").fadeIn('slow');
            $("div#intFormuEmergente").load("proyectos_mant.php?opMant=li&id=" + $("input#linkHidden").val());
        }
    });
}