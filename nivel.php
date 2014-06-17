<?php
require_once('config.php');
require_once(resources.'general.php');
require_once(entities.'nivel.php');
$general = new general();
$nivel = new nivel();

$data = array(
			'idNivel'=>'',
			'nomNivel'=>'',
			'depenNivel'=>'NULL'
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
		if(isset($_POST['nomNivel'])){
			if($_POST['nomNivel']!=""){
				$nivel->set($data);
				$id = $nivel->insert();
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
				$mensaje = "Debe escribir el nombre para crear un &aacute;rea de empresa.";
			}
		}
		break;
	
	case 'li':
		$titulo = "EDITAR ";
		if(isset($_REQUEST['id'])){
			$id = $_REQUEST['id'];
			$nivel->get($id);
			if(is_array($nivel->setArray)){
				$data = $nivel->setArray;
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
		if($_POST['idNivel']<>''){
			$nivel->set($data);
			if($nivel->update()){
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

$depenNivel = $general->combo($nivel->getCombo(), 'depenNivel', '', $data['depenNivel']);

?>
<form id="formGrilla" name="formGrilla" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<input type="hidden" id="opMant" name="opMant" value="<?php echo $opMant;?>" />
	<input type="hidden" id="idNivel" name="idNivel" value="<?php echo $data['idNivel'];?>" />
	<h1>
		<?php echo $titulo;?>&Aacute;REA
	</h1>
	<br /><br />
	<p class="mensaje"><span><?php echo $mensaje;?></span></p>
	<br /><br />
	<table>
		<tr>
			<td>	
				<label for="nomNivel">Nombre:</label>
			</td>
			<td>	
				<input type="text" id="nomNivel" name="nomNivel" value="<?php echo $data['nomNivel'];?>" />
			</td>
			<td>
				<label for="depenNivel">Depende de:</label>
			</td>
			<td>
				<?php echo $depenNivel;?>
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
	echo $general->grilla($nivel->show(), '&Aacute;reas de Empresa', '', 'nivel.php');
?>