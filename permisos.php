<?php
require_once('config.php');
require_once(templates.'header.php');
require_once(entities.'permiso.php');
require_once(resources.'general.php');
$permiso = new permiso();
$general = new general();

$mensaje = "";
?>
<form id="formGrilla" name="formGrilla" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<script src="<?php echo scripts;?>clientes.js" language="javascript" type="text/javascript"></script>
	<h1>
		PERMISOS
		<img src="<?php echo images;?>icon_permission.png" <?php echo sizeImg3;?> />
	</h1>
	<br /><br />
	<a href="permisos_mant.php" id="nuevo" name="nuevo">
		<img src="<?php echo images;?>icon_add.png" <?php echo sizeImg;?> />
		Nuevo Permiso
	</a>
	<br /><br />
	<label for="txtBuscar">Buscar:</label>
	<input type="text" id="txtBuscar" name="txtBuscar" size="100"  />
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
	
	$permiso->numRows($buscar);
	
	$paginacion = array("totalPag"=>$permiso->numRows, "actualPag"=>0, "cantPag"=>10, "colPag"=>"", "ascPag"=>1);
	foreach($paginacion as $key => $value){
		if(isset($_REQUEST[$key])){
			$paginacion[$key] = $_REQUEST[$key];
		}
	}
	
	$paginacion["totalPag"] = $permiso->numRows;
	
	echo $general->grilla($permiso->show($buscar, $paginacion), 'Lista de Permisos', 'icon_permission.png', 'permisos_mant.php', true, false, true, $paginacion);
	?>
</form>
<p class="loading"></p>
<?php
require_once(templates.'footer.php');
?>