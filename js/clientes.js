// JavaScript Document
$(document).ready(initClientes);

function initClientes() {

    $("div#formuEmergente").on("click", "button#guardarAnexo", function() {
        $.ajax({
            url: $(this).val(),
            type: "POST",
            data: $("form#formClientesMant").serialize(),
            success: function(datos) {
                $("div#agregarAnexo").html(datos);
                $("div#contacto").load("contactos.php?idCliente=" + $("input#idCliente").val());
                $("div#direccion").load("direcciones.php?idCliente=" + $("input#idCliente").val());
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
                $("div#contacto").load("contactos.php?idCliente=" + $("input#idCliente").val());
                $("div#direccion").load("direcciones.php?idCliente=" + $("input#idCliente").val());
                $(this).show().delay(2500).hide('slow', function() {
                    $(this).html("").show();
                })
            });
        }
        e.preventDefault();
    });
    $("div#formuEmergente").on("change", "select#idPais", function(e) {
        $("select#idDepartamento").load("direcciones_mant.php?idPais=" + $(this).find(":selected").val() + " select#idDepartamento option")
                .ajaxStart(mensajeCombo("div#agregarAnexo", "departamentos")).ajaxStop(mensajeVacio);
    });
    $("div#formuEmergente").on("change", "select#idDepartamento", function(e) {
        $("select#idProvincia").load("direcciones_mant.php?idDepartamento=" + $(this).find(":selected").val() + " select#idProvincia option")
                .ajaxStart(mensajeCombo("div#agregarAnexo", "provincias")).ajaxStop(mensajeVacio);
    });
    $("div#formuEmergente").on("change", "select#idProvincia", function(e) {
        $("select#idDistrito").load("direcciones_mant.php?idProvincia=" + $(this).find(":selected").val() + " select#idDistrito option")
                .ajaxStart(mensajeCombo("div#agregarAnexo", "distritos")).ajaxStop(mensajeVacio)
    });

    $("div#contenedorGrilla").on("mouseenter", "img#showContact, img#showAddress", function() {
        var pos = $(this).position();
        $("div#showLayer").show().css({left: (pos.left - 65), top: pos.top}).load($(this).attr("name") + " div#show");
    });

    $("div#contenedorGrilla").on("mouseleave", "img#showContact, img#showAddress", function() {
        $("div#showLayer").hide().html("");
    });

    $("div#contenido").on("click", "table#grilla img#showHistory", function(e) {
        $("div#emergente").fadeIn('slow');
        $("div#formuEmergente").fadeIn('slow');
        $("div#intFormuEmergente").load($(this).attr("name"));
        e.preventDefault();
    });

    $("a#reporte").click(function(e) {
        e.preventDefault();
        window.location = $(this).attr("name") + $("input#txtBuscar").val();
    });
}