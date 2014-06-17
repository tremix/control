<?php
require_once('config.php');
require_once(entities.'usuario.php');
$usuario = new usuario();
$mensaje = "";
if(isset($_REQUEST['actual'])){
	if($_REQUEST['actual']!="" and $_REQUEST['nueva']!="" and $_REQUEST['repetir']!=""){
		if($_REQUEST['nueva'] == $_REQUEST['repetir']){
			if($usuario->checkPassword($_SESSION['usuario']['id'], $_REQUEST['actual'])){
				if($usuario->updatePassword($_SESSION['usuario']['id'], $_REQUEST['nueva'])){
					$mensaje = "Contrase&ntilde;a cambiada exitosamente";
				}
			}else{
				$mensaje = "La contrase&ntilde;a especificada no es correcta.";
			}
		}else{
			$mensaje = "Los campos de contrase&ntilde;a nueva no coinciden.";
		}
	}else{
		$mensaje = "Debe escribir la contrase&ntilde;a antigua y la nueva.";
	}
}
?>
<form id="formCambiarClave" name="formCambiarClave" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<h1>
		CAMBIAR CONTRASE&Ntilde;A
		<img src="<?php echo images;?>icon_lock.png" <?php echo sizeImg3;?> />
	</h1>
	<br /><br />
	<p class="mensaje"><?php echo $mensaje;?></p>
	<br /><br />
	<table>
		<tr>
			<td>	
				<label for="actual">Contrase&ntilde;a actual:</label>
			</td>
			<td colspan="3">	
				<input type="password" id="actual" name="actual" />
			</td>
		</tr>
		<tr>
			<td>	
				<label for="nueva">Contrase&ntilde;a nueva:</label>
			</td>
			<td colspan="3">	
				<input type="password" id="nueva" name="nueva" />
			</td>
		</tr>
		<tr>
			<td>	
				<label for="repetir">Repetir contrase&ntilde;a:</label>
			</td>
			<td colspan="3">	
				<input type="password" id="repetir" name="repetir" />
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