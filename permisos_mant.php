<?php
require_once('config.php');
require_once(resources.'general.php');
require_once(entities.'permiso.php');
require_once(entities.'rol.php');
require_once(entities.'usuario.php');
require_once(entities.'formulario.php');
$general = new general();
$permiso = new permiso();
$rol = new rol();
$usuario = new usuario();
$formulario = new formulario();

$data = array(
			'idPermiso'=>'',
			'idUsuario'=>'NULL',
			'idRol'=>'NULL',
			'idFormulario'=>'NULL',
			'permiFormulario'=>'',
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

$opMant = "nu";
if(isset($_REQUEST['opMant'])){
	$opMant = $_REQUEST['opMant'];
}

$titulo = "";

switch($opMant){
	case 'nu':
		$titulo = "CREAR ";
		if(isset($_POST['idFormulario'])){
			if($_POST['idFormulario']!=""){
				$permiso->set($data);
				$id = $permiso->insert();
				if($id){
					$mensaje = "Permiso creado correctamente.";
					$data = array(
								'idPermiso'=>'',
								'idUsuario'=>'NULL',
								'idRol'=>'NULL',
								'idFormulario'=>'NULL',
								'permiFormulario'=>'NULL',
								'fechCrea'=>'',
								'fechEdita'=>'',
								'usuCrea'=>$_SESSION['usuario']['id'],
								'usuEdita'=>$_SESSION['usuario']['id']
					);
				}else{
					$mensaje = "No se pudo crear el permiso.";
				}
			}else{
				$mensaje = "Debe seleccionar un formulario para crear el permiso.";
			}
		}
		break;
	
	case 'li':
		$titulo = "EDITAR ";
		if(isset($_REQUEST['id'])){
			$id = $_REQUEST['id'];
			$permiso->get($id);
			if(is_array($permiso->setArray)){
				$data = $permiso->setArray;
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
		if($_POST['idPermiso']<>''){
			$permiso->set($data);
			if($permiso->update()){
				$mensaje = "Registro editado correctamente.";
			}else{
				$mensaje = "No se ha podido editar el registro.";
			}
		}
		break;
	case 'el':
		if(isset($_REQUEST['id'])){
			if($permiso->delete($_REQUEST['id'])){
				$mensaje = "Registro eliminado correctamente.";
			}else{
				$mensaje = "No se ha podido eliminar el registro.";
			}
		}
		break;

}

$idRol = $general->combo($rol->getCombo(), 'idRol', '', $data['idRol']);
$idUsuario = $general->combo($usuario->getCombo(), 'idUsuario', '', $data['idUsuario']);
$idFormulario = $general->combo($formulario->getCombo(), 'idFormulario', '', $data['idFormulario']);

?>
<form id="formPermisosMant" name="formPermisosMant" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<input type="hidden" id="opMant" name="opMant" value="<?php echo $opMant;?>" />
	<input type="hidden" id="idPermiso" name="idPermiso" value="<?php echo $data['idPermiso'];?>" />
	<h1>
		<?php echo $titulo;?>PERMISO
		<img src="<?php echo images;?>icon_permission.png" <?php echo sizeImg3;?> />
	</h1>
	<br /><br />
	<p>Seleccione un Tipo de Usuario o un Usuario en especial. Si quiere que el permiso sea para todos los usuarios no seleccione ninguna de las dos opciones.</p>
	<br /><br />
	<p class="mensaje"><span><?php echo $mensaje;?></span></p>
	<br /><br />
	<table>
		<tr>
			<td>	
				<label for="idRol">Por Tipo de Usuario:</label>
			</td>
			<td>	
				<?php echo $idRol;?>
			</td>
			<td>	
				<label for="idUsuario">A Usuario Espec&iacute;fico:</label>
			</td>
			<td>	
				<?php echo $idUsuario;?>
			</td>
		</tr>
		<tr>
			<td>	
				<label for="idFormulario">Formulario:</label>
			</td>
			<td>	
				<?php echo $idFormulario;?>
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