<?php
require_once('config.php');
require_once(templates.'header.php');

require_once(entities.'usuario.php');
require_once(entities.'cargo.php');
require_once(entities.'nivel.php');
require_once(entities.'rol.php');

$usuario = new usuario();
$cargo = new cargo();
$nivel = new nivel();
$rol = new rol();

$yo = $_SESSION['usuario'];
$icon = "icon_male.png";
$sexo = "Masculino";
if($yo['sexo']=="F"){
	$icon = "icon_female.png";
	$sexo = "Femenino";
}
$usuario->get($yo['id']);
$completo = $usuario->setArray;
$edad = $usuario->getAgeByID($yo['id']);
$rol = $rol->getByID($yo['id']);
$cargo = $cargo->getNameByID($yo['id']);
$nivel = $nivel->getNameByID($yo['id']);
?>
<link href="<?php echo css;?>grilla.css" type="text/css" rel="stylesheet" />
<h1>
	<img src="<?php echo images.$icon;?>" <?php echo sizeImg3;?> />
	<?php echo $yo['nombre'].' '.$yo['apellido'];?>
</h1>
<br />
<p>A continuaci&oacute;n podr&aacute;s ver la informaci&oacute;n principal de tu cuenta:</p>
<br /><br />
<table id="grilla" class="marginado">
	<thead>
		<tr>
			<td colspan="4"><center>INFORMACI&Oacute;N DEL USUARIO</center></td>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="alt">Apellidos:</td>
			<td><?php echo $yo['apellido'];?></td>
			<td class="alt">Nombres:</td>
			<td><?php echo $yo['nombre'];?></td>
		</tr>
		<tr>
			<td class="alt">&Aacute;rea:</td>
			<td><?php echo $nivel;?></td>
			<td class="alt">Cargo:</td>
			<td><?php echo $cargo;?></td>
		</tr>
		<tr>
			<td class="alt">Edad:</td>
			<td><?php echo $edad;?> a&ntilde;os</td>
			<td class="alt">E-mail:</td>
			<td><?php echo $completo['emailUsuario'];?></td>
		</tr>
		<tr>
			<td class="alt">Sexo:</td>
			<td><?php echo $sexo;?></td>
			<td class="alt">Tipo de usuario:</td>
			<td><?php echo $rol['nombre'];?></td>
		</tr>
		<tr>
			<td class="alt">DNI:</td>
			<td><?php echo $completo['loginUsuario'];?></td>
			<td class="alt">Contrase&ntilde;a:</td>
			<td>
				******** 
				<a href="cambiar_clave.php" id="nuevo"><img src="<?php echo images;?>icon_edit.png" <?php echo sizeImg;?> /></a>
			</td>
		</tr>
	</tbody>
</table>
<?php
require_once(templates.'footer.php');
?>