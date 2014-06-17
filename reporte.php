<?php
ob_start();
require_once('config.php');
require_once(resources.'general.php');
$general = new general();

$txtBuscar = $_REQUEST['txtBuscar'];
switch($_REQUEST['op']){
	case 'propGen':
		require_once(entities.'propuesta.php');
		$propuesta = new propuesta();
		$archivo = "propuestas";
		echo $general->grilla($propuesta->show($txtBuscar, '', false));
		break;
	case 'segGen':
		require_once(entities.'seguimiento.php');
		$seguimiento = new seguimiento();
		$archivo = "seguimiento";
		echo $general->grilla($seguimiento->showByPropuesta($txtBuscar, '', false));
		break;
	case 'cliGen':
		require_once(entities.'cliente.php');
		$cliente = new cliente();
		$archivo = "cliente";
		echo $general->grilla($cliente->show($txtBuscar, '', false));
		break;
}
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename={$archivo}.xls");
header("Pragma: no-cache");
header("Expires: 0");
ob_end_flush();
?>