<?php
require_once('config.php');
require_once(templates.'header.php');
require_once(entities.'usuario.php');
require_once(resources.'general.php');
$usuario = new usuario();
$general = new general();

$mensaje = "";
?>
<script src="<?php echo scripts;?>anexos.js" language="javascript" type="text/javascript"></script>
<h1>
	ANEXOS
	<img src="<?php echo images;?>icon_annex.png" <?php echo sizeImg3;?> />
</h1>
<br /><br />
<ul id="listaLink">
	<li>
		<a href="cargo.php" id="nuevo">Cargos</a>
	</li>
	<li>
		<a href="nivel.php" id="nuevo">&Aacute;reas de empresa</a>
	</li>
	<li>
		<a href="rubro.php" id="nuevo">Rubro de Cliente</a>
	</li>
	<li>
		<a href="situacion.php" id="nuevo">Situaci&oacute;n de Propuesta</a>
	</li>
	<li>
		<a href="tipoPropuesta.php" id="nuevo">Tipo de Propuesta</a>
	</li>
	<li>
		<a href="tipoArea.php" id="nuevo">&Aacute;rea de Propuesta</a>
	</li>
	<li>
		<a href="tipoServicio.php" id="nuevo">Servicio de Propuesta</a>
	</li>
</ul>
<?php
require_once(templates.'footer.php');
?>