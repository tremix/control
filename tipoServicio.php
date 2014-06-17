<?php
require_once('config.php');
require_once(resources.'general.php');
require_once(entities.'tipoServicio.php');
require_once(entities.'tipoArea.php');
$general = new general();
$tipoServicio = new tipoServicio();
$tipoArea = new tipoArea();

$data = array(
			'idTipoServicio'=>'',
			'idTipoArea'=>'NULL',
			'nomTipoServicio'=>'',
			'codTipoServicio'=>'',
			'descrTipoServicio'=>''
);

foreach($data as $key => $value){
	if(isset($_POST[$key])){
		$data[$key] = $_POST[$key];
	}
}

$mensaje = "";

$opMant = "nu";
if(isset($_REQUEST['opMant'])){
	$opMant = $_REQUEST['opMant'];
}

$titulo = "";

switch($opMant){
	case 'nu':
		$titulo = "CREAR ";
		if(isset($_POST['nomTipoServicio'])){
			if($_POST['nomTipoServicio']!="" and $_POST['codTipoServicio']!="" and $_POST['idTipoArea']!="NULL"){
				$tipoServicio->set($data);
				$id = $tipoServicio->insert();
				if($id){
					$mensaje = "Registro creado correctamente.";
					foreach($data as $key => $value){
						if(isset($_POST[$key])){
							$data[$key] = "";
						}
					}
				}else{
					$mensaje = "No se pudo crear el registro.";
				}
			}else{
				$mensaje = "Debe escribir el nombre y la descripci&oacuten;n y seleccionar el tipo de &aacute;rea para crear un servicio.";
			}
		}
		break;
	
	case 'li':
		$titulo = "EDITAR ";
		if(isset($_REQUEST['id'])){
			$id = $_REQUEST['id'];
			$tipoServicio->get($id);
			if(is_array($tipoServicio->setArray)){
				$data = $tipoServicio->setArray;
				$opMant = "ed";
			}else{					
				$titulo = "NUEVO ";
				$mensaje = "No se ha podido cargar el registro.";
				$opMant = "nu";
			}
		}else{
			$titulo = "NUEVO ";
			$mensaje = "No se ha podido cargar el registro.";			
			$opMant = "nu";
		}
		break;
	case 'ed':
		$titulo = "EDITAR ";
		if($_POST['idTipoServicio']<>''){
			$tipoServicio->set($data);
			if($tipoServicio->update()){
				$mensaje = "Registro editado correctamente.";
			}else{
				$mensaje = "No se ha podido editar el registro.";
			}
		}
		break;
	case 'el':
		$mensaje = "Los cargos creados no pueden ser eliminados.";
		break;

}

$idTipoArea = $general->combo($tipoArea->getCombo(), 'idTipoArea', '', $data['idTipoArea']);

?>
<form id="formGrilla" name="formGrilla" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<input type="hidden" id="opMant" name="opMant" value="<?php echo $opMant;?>" />
	<input type="hidden" id="idTipoServicio" name="idTipoServicio" value="<?php echo $data['idTipoServicio'];?>" />
	<h1>
		<?php echo $titulo;?>SERVICIO
	</h1>
	<br /><br />
	<p class="mensaje"><span><?php echo $mensaje;?></span></p>
	<br /><br />
	<table>
		<tr>
			<td>
                            <label for="idTipoArea">&Aacute;rea:</label>
			</td>
			<td>
				<?php echo $idTipoArea;?>
			</td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>	
				<label for="nomTipoServicio">Nombre:</label>
			</td>
			<td>	
				<input type="text" id="nomTipoServicio" name="nomTipoServicio" value="<?php echo $data['nomTipoServicio'];?>" />
			</td>
			<td>	
				<label for="codTipoServicio">C&oacute;digo:</label>
			</td>
			<td>	
				<input type="text" id="codTipoServicio" name="codTipoServicio" value="<?php echo $data['codTipoServicio'];?>" />
			</td>
		</tr>
		<tr>
			<td>	
				<label for="descrTipoServicio">Descripci&oacute;n:</label>
			</td>
			<td colspan="3">	
				<textarea id="descrTipoServicio" name="descrTipoServicio" cols="60" rows="5"><?php echo $data['descrTipoServicio'];?></textarea>
			</td>
		</tr>
		<tr>
			<td colspan="2" class="cent">	
				<button type="button" id="cancelar" name="cancelar">Cancelar</button>
			</td>
			<td colspan="2" class="cent">
				<button type="button" id="guardarAnexo">Guardar</button>
			</td>
		</tr>
	</table>
</form>
<br /><br />
<?php 
	echo $general->grilla($tipoServicio->show(), 'Servicio', '', 'tipoServicio.php');
?>