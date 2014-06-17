<?php
require_once('config.php');
require_once(entities.'actividad.php');
require_once(resources.'general.php');
$actividad = new actividad();
$general = new general();
$idEtapa = $_REQUEST['idEtapa'];
echo $general->grilla($actividad->show($idEtapa), 'Actividades de etapa', 'icon_annex.png', 'actividades_mant.php', true, true);
?>