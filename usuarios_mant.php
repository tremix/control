<?php
require_once('config.php');
require_once(resources.'general.php');
require_once(entities.'usuario.php');
require_once(entities.'rol.php');
require_once(entities.'nivel.php');
require_once(entities.'cargo.php');
$general = new general();
$usuario = new usuario();
$rol = new rol();
$nivel = new nivel();
$cargo = new cargo();

$opMant = "nu";
if(isset($_REQUEST['opMant'])){
	$opMant = $_REQUEST['opMant'];
}

$titulo = "";

$data = array(
		'idUsuario'=>'',
		'idRol'=>'NULL',
		'idCargo'=>'NULL',
		'idNivel'=>'NULL',
		'nomUsuario'=>'',
		'apeUsuario'=>'',
		'loginUsuario'=>'',
		'passUsuario'=>'',
		'emailUsuario'=>'',
		'fechnacUsuario'=>'',
		'sexUsuario'=>'',
		'estUsuario'=>'',
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

switch($opMant){
	case 'nu':
		$titulo = "CREAR ";
		$data['passUsuario'] = $general->generarClave();
		$boolCorreo = $general->validarCorreo($data['emailUsuario']);
		if(isset($_POST['apeUsuario']) and isset($_POST['nomUsuario']) and isset($_POST['loginUsuario'])){
			if($_POST['apeUsuario']!="" and $_POST['nomUsuario']!="" and $_POST['loginUsuario']!="" and $boolCorreo){
				$usuario->set($data);
				$id = $usuario->insert();
				if($id){
					$mensaje = "<p>Se te ha registrado como usuario en la Intranet DHO Consultores, tus datos son los siguientes:</p>";
					$mensaje .= "<br />";
					$mensaje .= "<strong>Usuario:</strong> {$data['loginUsuario']}";
					$mensaje .= "<br />";
					$mensaje .= "<strong>Contrase&ntilde;a:</strong> {$data['passUsuario']}";
					$mensaje .= "<br />";
					$mensaje .= "<br />";
					$mensaje .= "<p>Puedes cambiar tu contrase&ntilde;a desde la Intranet haciendo click en tu nombre debajo de la hora,";
					$mensaje .= "all&iacute; encontrar&aacute;s tus datos principales y una opci&oacute;n para hacerlo.</p>";
					$mensaje .= "<br />";
					$mensaje .= "<p>Puedes ingresar a la Intranet haciendo click <a href='".baseURL."'>aqu&iacute;</a>";
					
					$general->enviarMail($data['emailUsuario'], "Se te ha creado un usuario en la Intranet DHO Consultores", $mensaje);
					$mensaje = "";
					
					$data['idUsuario'] = $id;
					$opMant = "ed";
					$titulo = "EDITAR ";
					$mensaje = "Registro creado correctamente. La contrase&ntilde;a del usuario ser&aacute; enviada a la direcci&oacute;n de correo electr&oacute;nico especificado.";
				}else{
					$mensaje = "No se pudo realizar el registro.";
				}
			}else{
				$mensaje = "Debe llenar por lo menos los apellidos, nombres, DNI y direcci&oacute;n de correo electr&oacute;nico del usuario.";
				if($boolCorreo){
					$mensaje .= " El direcci&oacute;n de correo electr&oacute;nico no tiene el formato correcto.";
				}
			}
		}
		break;
	
	case 'li':
		$titulo = "EDITAR ";
		if(isset($_REQUEST['id'])){
			$id = $_REQUEST['id'];
			$usuario->get($id);
			if(is_array($usuario->setArray)){
				$data = $usuario->setArray;
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
		if($_POST['idUsuario']<>''){
			$usuario->set($data);
			if($usuario->update()){
				$mensaje = "Registro editado correctamente.";
			}else{
				$mensaje = "No se ha podido editar el registro.";
			}
		}
		break;
	case 'el':
		if(isset($_REQUEST['id'])){
			if($usuario->updateStatus($_REQUEST['id'])){
				$mensaje = "Registro eliminado correctamente.";
			}else{
				$mensaje = "No se ha podido eliminar el registro.";
			}
		}
		break;

}

$idRol = $general->combo($rol->getCombo(), 'idRol', '', $data['idRol']);
$idNivel = $general->combo($nivel->getCombo(), 'idNivel', '', $data['idNivel']);
$idCargo = $general->combo($cargo->getCombo(), 'idCargo', '', $data['idCargo']);

$estUsuario = array('A' => "CHECKED", 'I' => "");
$estUsuario[$data['estUsuario']] = "CHECKED";

$sexUsuario = array('M' => "CHECKED", 'F' => "");
$sexUsuario[$data['sexUsuario']] = "CHECKED";

?>
<form id="formUsuariosMant" name="formUsuariosMant" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<input type="hidden" id="opMant" name="opMant" value="<?php echo $opMant;?>" />
	<input type="hidden" id="idUsuario" name="idUsuario" value="<?php echo $data['idUsuario'];?>" />
	<h1>
		<?php echo $titulo;?>USUARIO
		<img src="<?php echo images;?>icon_user.png" <?php echo sizeImg3;?> />
	</h1>
	<br /><br />
	<p class="mensaje"><?php echo $mensaje;?></p>
	<br /><br />
	<table>
		<tr>
			<td>	
				<label for="idNivel">&Aacute;rea:</label>
			</td>
			<td>	
				<?php echo $idNivel;?>
			</td>
			<td>	
				<label for="idCargo">Cargo:</label>
			</td>
			<td>	
				<?php echo $idCargo;?>
			</td>
		</tr>
		<tr>
			<td>	
				<label for="apeUsuario">Apellidos:</label>
			</td>
			<td>	
				<input type="text" id="apeUsuario" name="apeUsuario" size="40" value="<?php echo $data['apeUsuario'];?>" />
			</td>
			<td>	
				<label for="nomUsuario">Nombre:</label>
			</td>
			<td>	
				<input type="text" id="nomUsuario" name="nomUsuario" size="40" value="<?php echo $data['nomUsuario'];?>" />
			</td>
		</tr>
		<tr>
			<td>	
				<label for="loginUsuario">DNI:</label>
			</td>
			<td>	
				<input type="text" id="loginUsuario" name="loginUsuario" value="<?php echo $data['loginUsuario'];?>" />
			</td>
			<td>	
				<label for="fechnacUsuario">Fecha de nacimiento:</label>
			</td>
			<td>	
				<input type="text" id="fechnacUsuario" name="fechnacUsuario" value="<?php echo $data['fechnacUsuario'];?>" />
			</td>
		</tr>
		<tr>
			<td>	
				<label for="emailUsuario">E-mail:</label>
			</td>
			<td>	
				<input type="text" id="emailUsuario" name="emailUsuario" size="50" value="<?php echo $data['emailUsuario'];?>" />
			</td>
			<td>	
				<label for="idRol">Tipo de usuario:</label>
			</td>
			<td>	
				<?php echo $idRol;?>
			</td>
		</tr>
		<tr>
			<td>	
				<label for="sexUsuario">Sexo:</label>
			</td>
			<td>
				<label for='mascSexUsuario'>Masculino</label>
				<input type="radio" id="mascSexUsuario" name="sexUsuario" value="A" <?php echo $sexUsuario['M'];?> />
				<label for='femSexUsuario'>Femenino</label>
				<input type="radio" id="femSexUsuario" name="sexUsuario" value="I" <?php echo $sexUsuario['F'];?> />
			</td>
			<td>	
				<label for="estUsuario">Estado:</label>
			</td>
			<td>	
				<label for='actEstUsuario'>Activo</label>
				<input type="radio" id="actEstUsuario" name="estUsuario" value="A" <?php echo $estUsuario['A'];?> />
				<label for='inaEstUsuario'>Inactivo</label>
				<input type="radio" id="inaEstUsuario" name="estUsuario" value="I" <?php echo $estUsuario['I'];?> />
			</td>
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