<?php
require_once('config.php');
require_once(templates.'header.php');
require_once(entities.'usuario.php');
require_once(resources.'general.php');
$usuario = new usuario();
$general = new general();

$mensaje = "";
?>
<form id="formGrilla" name="formGrilla" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<script src="<?php echo scripts;?>usuarios.js" language="javascript" type="text/javascript"></script>
	<h1>
		USUARIOS
		<img src="<?php echo images;?>icon_user.png" <?php echo sizeImg3;?> />
	</h1>
	<br /><br />
	<a href="usuarios_mant.php" id="nuevo" name="nuevo">
		<img src="<?php echo images;?>icon_add.png" <?php echo sizeImg;?> />
		Nuevo Usuario
	</a>
	<br /><br />
	<label for="txtBuscar">Buscar:</label>
	<input type="text" id="txtBuscar" name="txtBuscar" size="100" />
	<button type="button" id="buscarGrilla" name="buscarGrilla">
		<img src="<?php echo images;?>icon_find.png" />
		BUSCAR
	</button>
	<br />
	<center><p class="mensaje"><?php echo $mensaje;?></p></center>
	<br />
	<?php
	
	$buscar = "";
	if(isset($_REQUEST['txtBuscar'])){
		$buscar = $_REQUEST['txtBuscar'];
	}
	
	$usuario->numRows($buscar);
	
	$paginacion = array("totalPag"=>$usuario->numRows, "actualPag"=>0, "cantPag"=>10, "colPag"=>"", "ascPag"=>1);
	foreach($paginacion as $key => $value){
		if(isset($_REQUEST[$key])){
			$paginacion[$key] = $_REQUEST[$key];
		}
	}
	
	$paginacion["totalPag"] = $usuario->numRows;
	
	echo $general->grilla($usuario->show($buscar, $paginacion), 'Lista de Usuarios', 'icon_user.png', 'usuarios_mant.php', true, false, true, $paginacion);
	?>
</form>
<p class="loading"></p>
<?php
require_once(templates.'footer.php');
?>