<?php
require_once('config.php');
require_once(templates.'header.php');
$mensaje = "";
?>
<script src="<?php echo scripts;?>inicio.js" language="javascript" type="text/javascript"></script>
<h1>
	INICIO
	<img src="<?php echo images;?>icon_home.png" <?php echo sizeImg3;?> />
</h1>
<p>Bienvenido, <?php echo $_SESSION['usuario']['nombre'];?>.</p>
<br /><br />

<link href="<?php echo css;?>grilla.css" type="text/css" rel="stylesheet" />
<div id="principalAlerta">
	<br />
	<h1>
		<a href="alertas.php">
			Alertas 
			<img src="<?php echo images;?>icon_alert3.png" <?php echo sizeImg;?> />
		</a>
	</h1>
	<p class="mensaje"><span><?php echo $mensaje;?></span></p>
	<img src="<?php echo images;?>icon_refresh.png" <?php echo sizeImg;?> id="refrescarAlerta" />
	<div id="contenedorAlerta">
		<?php
			require_once(resources.'pagina.php');
			$pagina = new pagina();
			echo $pagina->alertas();
		?>
	</div>
</div>
<?php
require_once(templates.'footer.php');
?>