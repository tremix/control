// JavaScript Document
$(document).ready(initControl);

function initControl() {

    $("div#contenido").on("click", "a#nuevo, table#grilla a#editar", function(e) {
        $("div#intFormuEmergente").ajaxStop(function() {
            $("input#fechaControl").datepicker({
                changeMonth: true,
                changeYear: true
            });
        });
        e.preventDefault();
    });
    
    $("div#formuEmergente").on("change", "select#idCliente", function(e) {
        $("select#idProyecto").load("control_mant.php?idCliente=" + $(this).find(":selected").val() + " select#idProyecto option")
                .ajaxStart(mensajeCombo("div#agregarAnexo", "proyectos")).ajaxStop(mensajeVacio);
    });
    $("div#formuEmergente").on("change", "select#idProyecto", function(e) {
        $("select#idEtapa").load("control_mant.php?idProyecto=" + $(this).find(":selected").val() + " select#idEtapa option")
                .ajaxStart(mensajeCombo("div#agregarAnexo", "etapas")).ajaxStop(mensajeVacio);
    });
    $("div#formuEmergente").on("change", "select#idEtapa", function(e) {
        $("select#idActividad").load("control_mant.php?idEtapa=" + $(this).find(":selected").val() + " select#idActividad option")
                .ajaxStart(mensajeCombo("div#agregarAnexo", "actividades")).ajaxStop(mensajeVacio);
    });
}