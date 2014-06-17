<?php
require_once('config.php');
require_once(templates.'header.php');
require_once(entities.'rol.php');
require_once(resources.'general.php');
$rol = new rol();
$general = new general();

$mensaje = "";
?>
<form id="formGrilla" name="formGrilla" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<h1>
		ROLES
		<img src="<?php echo images;?>icon_role.png" <?php echo sizeImg3;?> />
	</h1>
	<br /><br />
	<a href="roles_mant.php" id="nuevo" name="nuevo">
		<img src="<?php echo images;?>icon_add.png" <?php echo sizeImg;?> />
		Nuevo Rol
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
	
	$rol->numRows($buscar);
	
	$paginacion = array("totalPag"=>$rol->numRows, "actualPag"=>0, "cantPag"=>10, "colPag"=>"", "ascPag"=>1);
	foreach($paginacion as $key => $value){
		if(isset($_REQUEST[$key])){
			$paginacion[$key] = $_REQUEST[$key];
		}
	}
	
	$paginacion["totalPag"] = $rol->numRows;
	
	echo $general->grilla($rol->show($buscar, $paginacion), 'Lista de Roles', 'icon_role.png', 'roles_mant.php', true, false, true, $paginacion);
	?>
</form>
<p class="loading"></p>
<?php
require_once(templates.'footer.php');
?>