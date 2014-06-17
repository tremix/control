<?php
require_once('config.php');
require_once(entities.'contacto.php');
require_once(resources.'general.php');
$contacto = new contacto();
$general = new general();
$idCliente = $_REQUEST['idCliente'];
echo $general->grilla($contacto->show($idCliente), 'Contactos de cliente', 'icon_contact.png', 'contactos_mant.php', true, true);
?>