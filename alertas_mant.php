<?php
require_once('config.php');
require_once(resources.'general.php');
require_once(entities.'alerta.php');
require_once(entities.'rol.php');
require_once(entities.'usuario.php');
$general = new general();
$alerta = new alerta();
$rol = new rol();
$usuario = new usuario();

$data = array(
			'idAlerta'=>'',
			'idUsuario'=>'NULL',
			'idRol'=>'NULL',
			'conteAlerta'=>'',
			'linkAlerta'=>'',
			'nomlinkAlerta'=>'',
			'fechAlerta'=>'',
			'fechCrea'=>'',
			'usuCrea'=>$_SESSION['usuario']['id'],
);

foreach($data as $key => $value){
	if(isset($_POST[$key])){
		$data[$key] = $_POST[$key];
	}
}

$mensaje = "";

$op = "cre";
if(isset($_REQUEST['opMant'])){
	$op = $_REQUEST['opMant'];
}

switch($op){
	case 'cre':		
		if(isset($_POST['conteAlerta']) and isset($_POST['fechAlerta'])){
			if($_POST['conteAlerta']!="" and $_POST['fechAlerta']!=""){
				$alerta->set($data);
				$id = $alerta->insert();
				if($id){
					$mensaje = "Alerta generada correctamente.";
					$data = array(
								'idAlerta'=>'',
								'idUsuario'=>'NULL',
								'idRol'=>'NULL',
								'conteAlerta'=>'',
								'linkAlerta'=>'',
								'nomlinkAlerta'=>'',
								'fechAlerta'=>'',
								'fechCrea'=>'',
								'usuCrea'=>$_SESSION['usuario']['id'],
					);
				}else{
					$mensaje = "No se pudo generar la alerta.";
				}
			}else{
				$mensaje = "Debe llenar por lo menos el contenido y la fecha para generar una alerta.";
			}
		}
		break;
	case 'lei':
		require_once(entities.'leidoAlerta.php');
		$leidoAlerta = new leidoAlerta();
		$data['idLeidoAlerta'] = "";
		$data['idAlerta'] = $_REQUEST['id'];
		$data['idUsuario'] = $_SESSION['usuario']['id'];
		$data['fechCrea'] = "";
		$leidoAlerta->set($data);
		if($leidoAlerta->insert()){
			$mensaje = "La alerta se ha marcado como le&iacute;da.";
		}else{
			$mensaje = "No se ha podido marcar la alerta.";
		}
		break;
	case 'env':		
		$alerta->get($_REQUEST['id']);
		$aler = $alerta->setArray;
		
		if($aler['creador']>0){
			$creador =  $usuario->getNameByID($aler['creador']);
		}else{
			$creador = "el Sistema";
		}
		
		$cuerpo = $aler['contenido'] . " <a href='{$aler['link']}'>{$aler['nomLink']}</a>. Creado para el {$aler['fecha']}. "; 
		$cuerpo .= "La alerta fue creada por $creador.";
		
		if($general->enviarMail($_SESSION['usuario']['email'], "Alerta del Sistema", $cuerpo)){
			$mensaje = "La alerta se ha enviado a su correo electr&oacute;nico.";
		}else{
			$mensaje = "La alerta no ha podido ser enviada.";
		}
		break;
}

$idRol = $general->combo($rol->getCombo(), 'idRol', '', $data['idRol']);
$idUsuario = $general->combo($usuario->getCombo(), 'idUsuario', '', $data['idUsuario']);

?>
<form id="formAlertasMant" name="formAlertasMant" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<h1>
		CREAR ALERTA
		<img src="<?php echo images;?>icon_alert3.png" <?php echo sizeImg3;?> />
	</h1>
	<br /><br />
	<p>Seleccione un Tipo de Usuario o un Usuario en especial. Si quiere que la alerta llegue a todos los usuarios no seleccione ninguna de las dos opciones.</p>
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
				<label for="conteAlerta">Contenido:</label>
			</td>
			<td colspan="3">	
				<textarea id="conteAlerta" name="conteAlerta" cols="60" rows="5"><?php echo $data['conteAlerta'];?></textarea>
			</td>
		</tr>
		<tr>
			<td>	
				<label for="fechAlerta">Fecha de alerta:</label>
			</td>
			<td colspan="3">	
				<input type="text" id="fechAlerta" name="fechAlerta" />
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