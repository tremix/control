<?php
require_once('config.php');
require_once(templates.'header.php');

$mensaje = "";

if(!empty($_POST)){
	require_once(entities.'usuario.php');
	$usuario = new usuario();
	if($usuario->login($_POST['user'], $_POST['pass'])){
		if(isset($_SESSION['usuario'])){
			header('location: inicio.php');
		}else{
			$mensaje = "Su cuenta se encuentra desactivada.";
		}		
		
	}else{
		$mensaje = "El usuario o contrase&ntilde;a son incorrectos.";
	}
}
?>

<form id="formLogin" name="formLogin" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<script src="<?php echo scripts;?>login.js" language="javascript" type="text/javascript"></script>
	<div id="login">
		<table>
			<tr>
				<td colspan="2">
					<center>
						<img src="<?php echo images;?>icon_lock.png" <?php echo sizeImg4;?> />
					</center>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<h1>Ingreso al Sistema</h1>
				</td>
			</tr>
			<tr>
				<td>
					<label for="user">Usuario:</label>
				</td>
				<td>
					<input type="text" id="user" name="user" />
				</td>
			</tr>
			<tr>
				<td>
					<label for="pass">Contrase&ntilde;a:</label>
				</td>
				<td>
					<input type="password" id="pass" name="pass" />
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<center>
						<p><?php echo $mensaje;?></p>
					</center>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<center>
						<button type="submit" id="ingresar" name="ingresar">Ingresar</button>
					</center>
				</td>
			</tr>
		</table>
	</div>
</form>
<?php
require_once(templates.'footer.php');
?>