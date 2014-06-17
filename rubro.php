<?php
require_once('config.php');
require_once(resources.'general.php');
require_once(entities.'rubro.php');
$general = new general();
$rubro = new rubro();

$data = array(
			'idRubro'=>'',
			'nomRubro'=>''
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
		if(isset($_POST['nomRubro'])){
			if($_POST['nomRubro']!=""){
				$rubro->set($data);
				$id = $rubro->insert();
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
				$mensaje = "Debe escribir el nombre para crear un rubro.";
			}
		}
		break;
	
	case 'li':
		$titulo = "EDITAR ";
		if(isset($_REQUEST['id'])){
			$id = $_REQUEST['id'];
			$rubro->get($id);
			if(is_array($rubro->setArray)){
				$data = $rubro->setArray;
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
		if($_POST['idRubro']<>''){
			$rubro->set($data);
			if($rubro->update()){
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
	<input type="hidden" id="idRubro" name="idRubro" value="<?php echo $data['idRubro'];?>" />
	<h1>
		<?php echo $titulo;?>RUBRO
	</h1>
	<br /><br />
	<p class="mensaje"><span><?php echo $mensaje;?></span></p>
	<br /><br />
	<table>
		<tr>
			<td>	
				<label for="nomRubro">Nombre:</label>
			</td>
			<td>	
				<input type="text" id="nomRubro" name="nomRubro" value="<?php echo $data['nomRubro'];?>" />
			</td>
			<td></td>
			<td></td>
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
	echo $general->grilla($rubro->show(), 'Cargos de Empresa', '', 'rubro.php');
?>