<?php
require_once('config.php');
require_once(resources.'general.php');
require_once(entities.'tipoPropuesta.php');
$general = new general();
$tipoPropuesta = new tipoPropuesta();

$data = array(
			'idTipoPropuesta'=>'',
			'nomTipoPropuesta'=>'',
			'codTipoPropuesta'=>'',
			'descrTipoPropuesta'=>''
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
		if(isset($_POST['nomTipoPropuesta'])){
			if($_POST['nomTipoPropuesta']!="" and $_POST['codTipoPropuesta']!=""){
				$tipoPropuesta->set($data);
				$id = $tipoPropuesta->insert();
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
				$mensaje = "Debe escribir el nombre y la descripci&oacuten;n para crear un tipo de propuesta.";
			}
		}
		break;
	
	case 'li':
		$titulo = "EDITAR ";
		if(isset($_REQUEST['id'])){
			$id = $_REQUEST['id'];
			$tipoPropuesta->get($id);
			if(is_array($tipoPropuesta->setArray)){
				$data = $tipoPropuesta->setArray;
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
		if($_POST['idTipoPropuesta']<>''){
			$tipoPropuesta->set($data);
			if($tipoPropuesta->update()){
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

?>
<form id="formGrilla" name="formGrilla" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<input type="hidden" id="opMant" name="opMant" value="<?php echo $opMant;?>" />
	<input type="hidden" id="idTipoPropuesta" name="idTipoPropuesta" value="<?php echo $data['idTipoPropuesta'];?>" />
	<h1>
		<?php echo $titulo;?>TIPO DE PROPUESTA
	</h1>
	<br /><br />
	<p class="mensaje"><span><?php echo $mensaje;?></span></p>
	<br /><br />
	<table>
		<tr>
			<td>	
				<label for="nomTipoPropuesta">Nombre:</label>
			</td>
			<td>	
				<input type="text" id="nomTipoPropuesta" name="nomTipoPropuesta" value="<?php echo $data['nomTipoPropuesta'];?>" />
			</td>
			<td>	
				<label for="codTipoPropuesta">C&oacute;digo:</label>
			</td>
			<td>	
				<input type="text" id="codTipoPropuesta" name="codTipoPropuesta" value="<?php echo $data['codTipoPropuesta'];?>" />
			</td>
		</tr>
		<tr>
			<td>	
				<label for="descrTipoPropuesta">Descripci&oacute;n:</label>
			</td>
			<td colspan="3">	
				<textarea id="descrTipoPropuesta" name="descrTipoPropuesta" cols="60" rows="5"><?php echo $data['descrTipoPropuesta'];?></textarea>
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
	echo $general->grilla($tipoPropuesta->show(), 'Tipo de Propuesta', '', 'tipoPropuesta.php');
?>