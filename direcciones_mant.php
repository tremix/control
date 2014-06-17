<?php
require_once('config.php');
require_once(resources.'general.php');
require_once(entities.'direccion.php');
require_once(entities.'pais.php');
require_once(entities.'departamento.php');
require_once(entities.'provincia.php');
require_once(entities.'distrito.php');
require_once(entities.'codigoPostal.php');
$general = new general();
$direccion = new direccion();
$pais = new pais();
$departamento = new departamento();
$provincia = new provincia();
$distrito = new distrito();
$codigoPostal = new codigoPostal();

$opMantDif = "nu";
if(isset($_REQUEST['opMantDif'])){
	$opMantDif = $_REQUEST['opMantDif'];
}

$titulo = "";

$data = array(		
		'idDireccion'=>'',
		'idCliente'=>'',
		'idDistrito'=>'NULL',
		'idCodigoPostal'=>'NULL',
		'idPais'=>'NULL',
		'idDepartamento'=>'NULL',
		'idProvincia'=>'NULL',
		'conteDireccion'=>'',
		'urbDireccion'=>'',
		'refDireccion'=>'',
		'princDireccion'=>'',
		'fechCrea'=>'',
		'fechEdita'=>'',
		'usuCrea'=>$_SESSION['usuario']['id'],
		'usuEdita'=>$_SESSION['usuario']['id']
);

foreach($data as $key => $value){
	if(isset($_REQUEST[$key])){
		$data[$key] = $_REQUEST[$key];
	}
}

$mensaje = "";

$showLayer = "";

switch($opMantDif){
	case 'nu':
		$titulo = "CREAR ";
		if(isset($_POST['conteDireccion'])){
			if($_POST['conteDireccion']!=""){
				$direccion->set($data);
				$id = $direccion->insert();
				if($id){
					$data['idDireccion'] = $id;
					$opMantDif = "ed";
					$titulo = "EDITAR ";
					$mensaje = "Registro creado correctamente.";
				}else{
					$mensaje = "No se pudo realizar el registro.";
				}
			}else{
				$mensaje = "Debe llena la direcci&oacute;n.";
			}
		}
		break;
	
	case 'li':
		$titulo = "EDITAR ";
		if(isset($_REQUEST['id'])){
			$id = $_REQUEST['id'];
			$direccion->get($id);
			if(is_array($direccion->setArray)){
				$data = $direccion->setArray;
				$opMantDif = "ed";
			}else{					
				$titulo = "NUEVO ";
				$mensaje = "No se ha podido cargar el registro.";
				$opMantDif = "nu";
			}
		}else{
			$titulo = "NUEVO ";
			$mensaje = "No se ha podido cargar el registro.";			
			$opMantDif = "nu";
		}
		break;
	case 'ed':
		$titulo = "EDITAR ";
		if($_POST['idDireccion']<>''){
			$direccion->set($data);
			if($direccion->update()){
				$mensaje = "Registro editado correctamente.";
			}else{
				$mensaje = "No se ha podido editar el registro.";
			}
		}
		break;
	case 'el':
		if(isset($_REQUEST['id'])){
			if($direccion->delete($_REQUEST['id'])){
				$mensaje = "Registro eliminado correctamente.";
			}else{
				$mensaje = "No se ha podido eliminar el registro.";
			}
		}
		break;
	case 'sh':
		if(isset($_REQUEST['id'])){
			$direccion->getMain($_REQUEST['id']);
			$dataAux = $direccion->setArray;
			
			$showLayer .= "<h2>";
			$showLayer .= "DIRECCI&Oacute;N";
			$showLayer .= "<img src='".images."icon_address.png' ".sizeImg." />";
			$showLayer .= "</h2>";
			$showLayer .= "<br />";
			
			if(is_array($dataAux)){
				$showLayer .= "<strong>{$dataAux['conteDireccion']}</strong>";
				$showLayer .= "<br />";
				$showLayer .= "<strong>Urbanizaci&oacute;n:</strong> {$dataAux['urbDireccion']}";
				$showLayer .= "<br />";
				$showLayer .= "<strong>Referencia:</strong> {$dataAux['refDireccion']}";
				$showLayer .= "<br />";
			}else{
				$showLayer .= "No se tienen direcciones para este cliente.";
			}
		}
		break;

}

$idPais = $general->combo($pais->getCombo(), 'idPais', '', $data['idPais']);
$idDepartamento = $general->combo($departamento->getCombo($data['idPais']), 'idDepartamento', '', $data['idDepartamento']);
$idProvincia = $general->combo($provincia->getCombo($data['idDepartamento']), 'idProvincia', '', $data['idProvincia']);
$idDistrito = $general->combo($distrito->getCombo($data['idProvincia']), 'idDistrito', '', $data['idDistrito']);
$idCodigoPostal = $general->combo($codigoPostal->getCombo(), 'idCodigoPostal', '', $data['idCodigoPostal']);

$princDireccion = "";
if($data['princDireccion']){
	$princDireccion = "CHECKED";
}


?>
<input type="hidden" id="opMantDif" name="opMantDif" value="<?php echo $opMantDif;?>" />
<input type="hidden" id="idDireccion" name="idDireccion" value="<?php echo $data['idDireccion'];?>" />
<h1>
	<?php echo $titulo;?>DIRECCI&Oacute;N
	<img src="<?php echo images;?>icon_address.png" <?php echo sizeImg3;?> />
</h1>
<br /><br />
<div id="show"><?php echo $showLayer;?></div>
<p class="mensaje"><?php echo $mensaje;?></p>
<br /><br />
<table>
	<tr>
		<td>	
			<label for="idPais">Pa&iacute;s:</label>
		</td>
		<td>	
			<?php echo $idPais;?>
		</td>
		<td>	
			<label for="idDepartamento">Departamento:</label>
		</td>
		<td>	
			<?php echo $idDepartamento;?>
		</td>
	</tr>
	<tr>
		<td>	
			<label for="idProvincia">Provincia:</label>
		</td>
		<td>	
			<?php echo $idProvincia;?>
		</td>
		<td>	
			<label for="idDistrito">Distrito:</label>
		</td>
		<td>	
			<?php echo $idDistrito;?>
		</td>
	</tr>
	<tr>
		<td>	
			<label for="conteDireccion">Direcci&oacute;n:</label>
		</td>
		<td colspan="3">	
			<input type="text" id="conteDireccion" name="conteDireccion" size="60" value="<?php echo $data['conteDireccion'];?>" />
		</td>
	</tr>
	<tr>
		<td>	
			<label for="urbDireccion">Urbanizaci&oacute;n:</label>
		</td>
		<td colspan="3">	
			<input type="text" id="urbDireccion" name="urbDireccion" size="60" value="<?php echo $data['urbDireccion'];?>" />
		</td>
	</tr>
	<tr>
		<td>	
			<label for="refDireccion">Referencia:</label>
		</td>
		<td colspan="3">	
			<input type="text" id="refDireccion" name="refDireccion" size="60" value="<?php echo $data['refDireccion'];?>" />
		</td>
	</tr>
	<tr>
		<td>	
			<label for="idCodigoPostal">C&oacute;digo Postal:</label>
		</td>
		<td>	
			<?php echo $idCodigoPostal;?>
		</td>
		<td>	
			<label for="princDireccion">Principal:</label>
		</td>
		<td>
			<input type="checkbox" id="princDireccion" name="princDireccion" value="1" <?php echo $princDireccion;?> />
		</td>
	</tr>		
	<tr>
		<td colspan="2" class="cent">	
			<button type="button" id="cancelarAnexo" name="cancelarAnexo">Cancelar</button>
		</td>
		<td colspan="2" class="cent">
			<button type="button" id="guardarAnexo" name="guardarAnexo" value="direcciones_mant.php">Guardar</button>
		</td>
	</tr>
</table>