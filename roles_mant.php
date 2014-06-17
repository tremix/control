<?php
require_once('config.php');
require_once(entities.'rol.php');
$rol = new rol();

$opMant = "nu";
if(isset($_REQUEST['opMant'])){
	$opMant = $_REQUEST['opMant'];
}

$titulo = "";

$data = array(
		'idRol'=>'',
		'nomRol'=>'',
		'estRol'=>'A'
);

foreach($data as $key => $value){
	if(isset($_POST[$key])){
		$data[$key] = $_POST[$key];
	}
}

$mensaje = "";

switch($opMant){
	case 'nu':
		$titulo = "CREAR ";
		if(isset($_POST['nomRol'])){
			if($_POST['nomRol']!=""){
				$rol->set($data);
				$id = $rol->insert();
				if($id){
					$data['idRol'] = $id;
					$opMant = "ed";
					$titulo = "EDITAR ";
					$mensaje = "Registro creado correctamente.";
				}else{
					$mensaje = "No se pudo realizar el registro.";
				}
			}else{
				$mensaje = "Debe escribir el nombre del rol para poder crearlo.";
			}
		}
		break;
	
	case 'li':
		$titulo = "EDITAR ";
		if(isset($_REQUEST['id'])){
			$id = $_REQUEST['id'];
			$rol->get($id);
			if(is_array($rol->setArray)){
				$data = $rol->setArray;
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
		if($_POST['idRol']<>''){
			$rol->set($data);
			if($rol->update()){
				$mensaje = "Registro editado correctamente.";
			}else{
				$mensaje = "No se ha podido editar el registro.";
			}
		}
		break;
	case 'el':
		if(isset($_REQUEST['id'])){
			if($rol->updateStatus($_REQUEST['id'])){
				$mensaje = "Registro eliminado correctamente.";
			}else{
				$mensaje = "No se ha podido eliminar el registro.";
			}
		}
		break;

}

?>
<form id="formClientesMant" name="formClientesMant" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<input type="hidden" id="opMant" name="opMant" value="<?php echo $opMant;?>" />
	<input type="hidden" id="idRol" name="idRol" value="<?php echo $data['idRol'];?>" />
	<h1>
		<?php echo $titulo;?>ROL
		<img src="<?php echo images;?>icon_role.png" <?php echo sizeImg3;?> />
	</h1>
	<br /><br />
	<p class="mensaje"><?php echo $mensaje;?></p>
	<br /><br />
	<table>
		<tr>
			<td>	
				<label for="nomRol">Nombre:</label>
			</td>
			<td>	
				<input type="text" id="nomRol" name="nomRol" value="<?php echo $data['nomRol'];?>" />
			</td>
			<td></td>
			<td></td>
		</tr>		
		<tr>
			<td colspan="2" class="cent">	
				<button type="button" id="cancelar" name="cancelar">Cancelar</button>
			</td>
			<td colspan="2" class="cent">
				<button type="button" id="guardar" name="guardar">Guardar</button>
			</td>
		</tr>
	</table>
</form>