<?php
require_once('config.php');
require_once(entities.'direccion.php');
require_once(resources.'general.php');
$direccion = new direccion();
$general = new general();
$idCliente = $_REQUEST['idCliente'];
echo $general->grilla($direccion->show($idCliente), 'Direcciones de cliente', 'icon_address.png', 'direcciones_mant.php', true, true);
?>