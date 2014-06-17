<?php
require_once('config.php');
require_once(entities.'proyectoEtapa.php');
require_once(resources.'general.php');
$proyectoEtapa = new proyectoEtapa();
$general = new general();
$idProyecto = $_REQUEST['idProyecto'];
echo $general->grilla($proyectoEtapa->show($idProyecto), 'Etapas de proyecto', 'icon_project.png', 'proyectoEtapas_mant.php', true, true);
?>