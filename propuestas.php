<?php
require_once('config.php');
require_once(templates.'header.php');
require_once(entities.'propuesta.php');
require_once(resources.'general.php');
$propuesta = new propuesta();
$general = new general();

$id = "";
if(isset($_REQUEST['id'])){
	$id = $_REQUEST['id'];
}

$mensaje = "";
?>
<form id="formGrilla" name="formGrilla" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<script src="<?php echo scripts;?>propuestas.js" language="javascript" type="text/javascript"></script>
    <input type="hidden" id="linkHidden" name="linkHidden" value="<?php echo $id;?>" />
	<h1>
		PROPUESTAS
		<img src="<?php echo images;?>icon_proposal.png" <?php echo sizeImg3;?> />
	</h1>
	<br /><br />
	<a href="propuestas_mant.php" id="nuevo" name="nuevo">
		<img src="<?php echo images;?>icon_add.png" <?php echo sizeImg;?> />
		Nueva Propuesta
	</a>
	  - 
	  <a href="#" id="reporte" name="reporte.php?op=propGen&txtBuscar=">
		<img src="<?php echo images;?>icon_excel.png" <?php echo sizeImg;?> />
		Exportar Propuestas en Excel
	</a>
	  - 
	  <a href="#" id="reporte" name="reporte.php?op=segGen&txtBuscar=">
		<img src="<?php echo images;?>icon_excel.png" <?php echo sizeImg;?> />
		Exportar Seguimientos en Excel
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
	
	$propuesta->numRows($buscar);
	
	$paginacion = array("totalPag"=>$propuesta->numRows, "actualPag"=>0, "cantPag"=>50, "colPag"=>"", "ascPag"=>1);
	foreach($paginacion as $key => $value){
		if(isset($_REQUEST[$key])){
			$paginacion[$key] = $_REQUEST[$key];
		}
	}
	
	$paginacion["totalPag"] = $propuesta->numRows;
	
	echo $general->grilla($propuesta->show($buscar, $paginacion), 'Lista de Propuestas', 'icon_proposal.png', 'propuestas_mant.php', true, false, true, $paginacion);
	?>
</form>
<p class="loading"></p>
<?php
require_once(templates.'footer.php');
?>