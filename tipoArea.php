<?php
require_once('config.php');
require_once(resources.'general.php');
require_once(entities.'tipoArea.php');
require_once(entities.'tipoPropuesta.php');
$general = new general();
$tipoArea = new tipoArea();
$tipoPropuesta = new tipoPropuesta();

$data = array(
			'idTipoArea'=>'',
			'idTipoPropuesta'=>'NULL',
			'nomTipoArea'=>'',
			'codTipoArea'=>'',
			'descrTipoArea'=>''
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
		if(isset($_POST['nomTipoArea'])){
			if($_POST['nomTipoArea']!="" and $_POST['codTipoArea']!="" and $_POST['idTipoPropuesta']!="NULL"){
				$tipoArea->set($data);
				$id = $tipoArea->insert();
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
				$mensaje = "Debe escribir el nombre y la descripci&oacuten;n y seleccionar el tipo de propuesta para crear un &aacute;rea.";
			}
		}
		break;
	
	case 'li':
		$titulo = "EDITAR ";
		if(isset($_REQUEST['id'])){
			$id = $_REQUEST['id'];
			$tipoArea->get($id);
			if(is_array($tipoArea->setArray)){
				$data = $tipoArea->setArray;
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
		if($_POST['idTipoArea']<>''){
			$tipoArea->set($data);
			if($tipoArea->update()){
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

$idTipoPropuesta = $general->combo($tipoPropuesta->getCombo(), 'idTipoPropuesta', '', $data['idTipoPropuesta']);

?>
<form id="formGrilla" name="formGrilla" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<input type="hidden" id="opMant" name="opMant" value="<?php echo $opMant;?>" />
	<input type="hidden" id="idTipoArea" name="idTipoArea" value="<?php echo $data['idTipoArea'];?>" />
	<h1>
		<?php echo $titulo;?>&Aacute;REA
	</h1>
	<br /><br />
	<p class="mensaje"><span><?php echo $mensaje;?></span></p>
	<br /><br />
	<table>
		<tr>
			<td>
				<label for="idTipoPropuesta">Tipo de Propuesta:</label>
			</td>
			<td>
				<?php echo $idTipoPropuesta;?>
			</td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>	
				<label for="nomTipoArea">Nombre:</label>
			</td>
			<td>	
				<input type="text" id="nomTipoArea" name="nomTipoArea" value="<?php echo $data['nomTipoArea'];?>" />
			</td>
			<td>	
				<label for="codTipoArea">C&oacute;digo:</label>
			</td>
			<td>	
				<input type="text" id="codTipoArea" name="codTipoArea" value="<?php echo $data['codTipoArea'];?>" />
			</td>
		</tr>
		<tr>
			<td>	
				<label for="descrTipoArea">Descripci&oacute;n:</label>
			</td>
			<td colspan="3">	
				<textarea id="descrTipoArea" name="descrTipoArea" cols="60" rows="5"><?php echo $data['descrTipoArea'];?></textarea>
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
	echo $general->grilla($tipoArea->show(), '&Aacute;rea', '', 'tipoArea.php');
?>