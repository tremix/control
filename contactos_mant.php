<?php
require_once('config.php');
require_once(entities.'contacto.php');
$contacto = new contacto();

$opMantDif = "nu";
if(isset($_REQUEST['opMantDif'])){
	$opMantDif = $_REQUEST['opMantDif'];
}

$titulo = "";

$data = array(		
		'idContacto'=>'',
		'idCliente'=>'',
		'nomContacto'=>'',
		'apeContacto'=>'',
		'cargoContacto'=>'',
		'emailContacto'=>'',
		'tfijoContacto'=>'',
		'tdirecContacto'=>'',
		'tcel1Contacto'=>'',
		'tcel2Contacto'=>'',
		'obsContacto'=>'',
		'princContacto'=>false,
		'fechCrea'=>'',
		'fechEdita'=>'',
		'usuCrea'=>$_SESSION['usuario']['id'],
		'usuEdita'=>$_SESSION['usuario']['id']
);

foreach($data as $key => $value){
	if(isset($_POST[$key])){
		$data[$key] = $_POST[$key];
	}
}

$mensaje = "";

$showLayer = "";

switch($opMantDif){
	case 'nu':
		$titulo = "CREAR ";
		if(isset($_POST['nomContacto']) and isset($_POST['apeContacto'])){
			if($_POST['nomContacto']!="" and $_POST['apeContacto']!=""){
				$contacto->set($data);
				if($data['princContacto']){
					$contacto->updatePrinc($data['idCliente']);
				}
				$id = $contacto->insert();
				if($id){
					$data['idContacto'] = $id;
					$opMantDif = "ed";
					$titulo = "EDITAR ";
					$mensaje = "Registro creado correctamente.";
				}else{
					$mensaje = "No se pudo realizar el registro.";
				}
			}else{
				$mensaje = "Debe llenar por lo menos el nombre y el apellido del contacto.";
			}
		}
		break;
	
	case 'li':
		$titulo = "EDITAR ";
		if(isset($_REQUEST['id'])){
			$id = $_REQUEST['id'];
			$contacto->get($id);
			if(is_array($contacto->setArray)){
				$data = $contacto->setArray;
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
		if($_POST['idContacto']<>''){
			$contacto->set($data);
			if($data['princContacto']){
				$contacto->updatePrinc($data['idCliente']);
			}
			if($contacto->update()){
				$mensaje = "Registro editado correctamente.";
			}else{
				$mensaje = "No se ha podido editar el registro.";
			}
		}
		break;
	case 'el':
		if(isset($_REQUEST['id'])){
			if($contacto->delete($_REQUEST['id'])){
				$mensaje = "Registro eliminado correctamente.";
			}else{
				$mensaje = "No se ha podido eliminar el registro.";
			}
		}
		break;
	case 'sh':
		if(isset($_REQUEST['id'])){
			$contacto->getMain($_REQUEST['id']);
			$dataAux = $contacto->setArray;
			
			$showLayer .= "<h2>";
			$showLayer .= "CONTACTO";
			$showLayer .= "<img src='".images."icon_contact.png' ".sizeImg." />";
			$showLayer .= "</h2>";
			$showLayer .= "<br />";
			
			if(is_array($dataAux)){
				$showLayer .= "<strong>{$dataAux['nomContacto']} {$dataAux['apeContacto']}</strong>";
				$showLayer .= "<br />";
				$showLayer .= "<strong>Cargo:</strong> {$dataAux['cargoContacto']}";
				$showLayer .= "<br />";
				$showLayer .= "<strong>E-mail:</strong> {$dataAux['emailContacto']}";
				$showLayer .= "<br />";
				$showLayer .= "<strong>Fijo:</strong> {$dataAux['tfijoContacto']}";
				$showLayer .= "<br />";
				$showLayer .= "<strong>Celular:</strong> {$dataAux['tcel1Contacto']}";		
				$showLayer .= "<br />";
				$showLayer .= "<strong>Observaci&oacute;n:</strong> {$dataAux['obsContacto']}";			
			}else{
				$showLayer .= "No se tienen contactos para este cliente.";
			}
		}
		break;

}

$princContacto = "";
if($data['princContacto']){
	$princContacto = "CHECKED";
}

?>
<input type="hidden" id="opMantDif" name="opMantDif" value="<?php echo $opMantDif;?>" />
<input type="hidden" id="idContacto" name="idContacto" value="<?php echo $data['idContacto'];?>" />
<h1>
	<?php echo $titulo;?>CONTACTO
	<img src="<?php echo images;?>icon_contact.png" <?php echo sizeImg3;?> />
</h1>
<br /><br />
<div id="show"><?php echo $showLayer;?></div>
<p class="mensaje"><?php echo $mensaje;?></p>
<br /><br />
<table>
	<tr>
		<td>	
			<label for="nomContacto">Nombre:</label>
		</td>
		<td>	
			<input type="text" id="nomContacto" name="nomContacto" size="50" value="<?php echo $data['nomContacto'];?>" />
		</td>
		<td>	
			<label for="apeContacto">Apellidos:</label>
		</td>
		<td>	
			<input type="text" id="apeContacto" name="apeContacto" size="50" value="<?php echo $data['apeContacto'];?>" />
		</td>
	</tr>
	<tr>
		<td>	
			<label for="cargoContacto">Cargo:</label>
		</td>
		<td>	
			<input type="text" id="cargoContacto" name="cargoContacto" size="30" value="<?php echo $data['cargoContacto'];?>" />
		</td>
		<td>	
			<label for="emailContacto">E-mail:</label>
		</td>
		<td colspan="3">	
			<input type="text" id="emailContacto" name="emailContacto" size="40" value="<?php echo $data['emailContacto'];?>" />
		</td>
	</tr>
	<tr>
		<td>	
			<label for="tfijoContacto">Tel. Fijo:</label>
		</td>
		<td>	
			<input type="text" id="tfijoContacto" name="tfijoContacto" size="12" value="<?php echo $data['tfijoContacto'];?>" />
		</td>
		<td>	
			<label for="tdirecContacto">Tel. Directo:</label>
		</td>
		<td>	
			<input type="text" id="tdirecContacto" name="tdirecContacto" size="12" value="<?php echo $data['tdirecContacto'];?>" />
		</td>
	</tr>
	<tr>
		<td>	
			<label for="tcel1Contacto">Celular 1:</label>
		</td>
		<td>	
			<input type="text" id="tcel1Contacto" name="tcel1Contacto" size="12" value="<?php echo $data['tcel1Contacto'];?>" />
		</td>
		<td>	
			<label for="tcel2Contacto">Celular 2:</label>
		</td>
		<td>	
			<input type="text" id="tcel2Contacto" name="tcel2Contacto" size="12" value="<?php echo $data['tcel2Contacto'];?>" />
		</td>
	</tr>
		<tr>
			<td>	
				<label for="obsContacto">Observaci&oacute;n:</label>
			</td>
			<td colspan="3">	
				<textarea id="obsContacto" name="obsContacto" cols="60" rows="5"><?php echo $data['obsContacto'];?></textarea>
			</td>
		</tr>
	<tr>
		<td>	
			<label for="princContacto">Principal:</label>
		</td>
		<td>
			<input type="checkbox" id="princContacto" name="princContacto" value="1" <?php echo $princContacto;?> />
		</td>
	</tr>		
	<tr>
		<td colspan="2" class="cent">	
			<button type="button" id="cancelarAnexo" name="cancelarAnexo">Cancelar</button>
		</td>
		<td colspan="2" class="cent">
			<button type="button" id="guardarAnexo" name="guardarAnexo" value="contactos_mant.php">Guardar</button>
		</td>
	</tr>
</table>