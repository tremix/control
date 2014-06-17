// JavaScript Document
$(document).ready(initAdicionalesProyecto);

function initAdicionalesProyecto() {

    $("div#contenido").on("click", "a#nuevo, table#grilla a#editar", function(e) {
        $("div#intFormuEmergente").ajaxStop(function() {
            $("input#fechaAdicionalProyecto").datepicker({
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
}