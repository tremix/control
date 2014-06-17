<?php
require_once('config.php');
require_once(entities.'seguimiento.php');
require_once(resources.'general.php');
$seguimiento = new seguimiento();
$general = new general();
$idPropuesta = $_REQUEST['idPropuesta'];
echo $general->grilla($seguimiento->show($_REQUEST['idPropuesta']), 'Seguimiento de Propuesta', 'icon_trace.png', 'seguimientos_mant.php', true, true);
?>