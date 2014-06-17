<?php
require_once('config.php');
require_once(entities.'responsable.php');
require_once(resources.'general.php');
$responsable = new responsable();
$general = new general();
$idProyecto = $_REQUEST['idProyecto'];
echo $general->grilla($responsable->show($idProyecto), 'Responsables de proyecto', 'icon_customer.png', 'responsables_mant.php', true, true);
?>