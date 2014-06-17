// JavaScript Document
$(document).ready(initEtapas);

function initEtapas() {

    $("div#formuEmergente").on("click", "button#guardarAnexo", function() {
        $.ajax({
            url: $(this).val(),
            type: "POST",
            data: $("form#formEtapasMant").serialize(),
            success: function(datos) {
                $("div#agregarAnexo").html(datos);
                $("div#actividad").load("actividades.php?idEtapa=" + $("input#idEtapa").val());
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
                $("div#actividad").load("actividades.php?idEtapa=" + $("input#idEtapa").val());
                $(this).show().delay(2500).hide('slow', function() {
                    $(this).html("").show();
                })
            });
        }
        e.preventDefault();
    });
}