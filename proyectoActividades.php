<?php
require_once('config.php');
require_once(entities.'proyectoActividad.php');
require_once(resources.'general.php');
$proyectoActividad = new proyectoActividad();
$general = new general();
$idProyecto = $_REQUEST['idProyecto'];
echo $general->grilla($proyectoActividad->show($idProyecto), 'Actividades de proyecto', 'icon_annex.png', 'proyectoActividades_mant.php', true, true);
?>