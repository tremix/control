<?php
require_once('config.php');
require_once(resources.'general.php');
require_once(entities.'cliente.php');
require_once(entities.'rubro.php');
require_once(entities.'contacto.php');
require_once(entities.'direccion.php');
$general = new general();
$cliente = new cliente();
$rubro = new rubro();
$contacto = new contacto();
$direccion = new direccion();

$opMant = "nu";
if(isset($_REQUEST['opMant'])){
	$opMant = $_REQUEST['opMant'];
}

$titulo = "";

$data = array(
		'idCliente'=>'',
		'idRubro'=>'NULL',
		'correCliente'=>'',
		'codCliente'=>'',
		'razsocCliente'=>'',
		'nomcomCliente'=>'',
		'rucCliente'=>'',
		'nroempCliente'=>'',
		'webCliente'=>'',
		'estCliente'=>'',
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
		$data['correCliente'] = $cliente->getCod();
		$data['codCliente'] = 'C' . str_pad($data['correCliente'], 4, "0", STR_PAD_LEFT);
		if(isset($_POST['razsocCliente']) and isset($_POST['rucCliente'])){
			if($_POST['razsocCliente']!="" and $_POST['rucCliente']!=""){
				$cliente->set($data);
				$id = $cliente->insert();
				if($id){
					$data['idCliente'] = $id;
					$opMant = "ed";
					$titulo = "EDITAR ";
					$mensaje = "Registro creado correctamente.";
				}else{
					$mensaje = "No se pudo realizar el registro.";
				}
			}else{
				$mensaje = "Debe llenar por lo menos la Raz&oacute;n Social y el RUC para registrar un cliente.";
			}
		}
		break;
	
	case 'li':
		$titulo = "EDITAR ";
		if(isset($_REQUEST['id'])){
			$id = $_REQUEST['id'];
			$cliente->get($id);
			if(is_array($cliente->setArray)){
				$data = $cliente->setArray;
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
		if($_POST['idCliente']<>''){
			$cliente->set($data);
			if($cliente->update()){
				$mensaje = "Registro editado correctamente.";
			}else{
				$mensaje = "No se ha podido editar el registro.";
			}
		}
		break;
	case 'el':
		if(isset($_REQUEST['id'])){
			if($cliente->updateStatus($_REQUEST['id'])){
				$mensaje = "Registro eliminado correctamente.";
			}else{
				$mensaje = "No se ha podido eliminar el registro.";
			}
		}
		break;

}

$idRubro = $general->combo($rubro->getCombo(), 'idRubro', '', $data['idRubro']);

$estCliente = array('A' => "CHECKED", 'I' => "");
$estCliente[$data['estCliente']] = "CHECKED";

?>
<form id="formClientesMant" name="formClientesMant" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<input type="hidden" id="opMant" name="opMant" value="<?php echo $opMant;?>" />
	<input type="hidden" id="idCliente" name="idCliente" value="<?php echo $data['idCliente'];?>" />
	<h1>
		<?php echo $titulo;?>CLIENTE
		<img src="<?php echo images;?>icon_customer.png" <?php echo sizeImg3;?> />
	</h1>
	<br /><br />
	<p class="mensaje"><?php echo $mensaje;?></p>
	<br /><br />
	<table>
		<tr>
			<td>	
				<label for="codCliente">C&oacute;digo:</label>
			</td>
			<td>	
				<input type="hidden" id="correCliente" name="correCliente" value="<?php echo $data['correCliente'];?>" />
				<input type="text" id="codCliente" name="codCliente" size="10" value="<?php echo $data['codCliente'];?>" readonly />
			</td>
			<td>	
				<label for="idRubro">Rubro:</label>
			</td>
			<td>	
				<?php echo $idRubro;?>
			</td>
		</tr>
		<tr>
			<td>	
				<label for="razsocCliente">Raz&oacute;n Social:</label>
			</td>
			<td colspan="3">	
				<input type="text" id="razsocCliente" name="razsocCliente" size="60" value="<?php echo $data['razsocCliente'];?>" />
			</td>
		</tr>
		<tr>
			<td>	
				<label for="nomcomCliente">Nombre Comercial:</label>
			</td>
			<td colspan="3">	
				<input type="text" id="nomcomCliente" name="nomcomCliente" size="60" value="<?php echo $data['nomcomCliente'];?>" />
			</td>
		</tr>
		<tr>
			<td>	
				<label for="rucCliente">RUC:</label>
			</td>
			<td>	
				<input type="text" id="rucCliente" name="rucCliente" size="11" value="<?php echo $data['rucCliente'];?>" />
			</td>
			<td>	
				<label for="nroempCliente">Nro Empleados:</label>
			</td>
			<td>	
				<input type="text" id="nroempCliente" name="nroempCliente" size="3" value="<?php echo $data['nroempCliente'];?>" />
			</td>
		</tr>
		<tr>
			<td>	
				<label for="webCliente">P&aacute;gina Web:</label>
			</td>
			<td colspan="3">	
				<input type="text" id="webCliente" name="webCliente" size="60" value="<?php echo $data['webCliente'];?>" />
			</td>
		</tr>
		<tr>
			<td>	
				<label for="estCliente">Estado:</label>
			</td>
			<td>	
				<label for='actEstCliente'>Activo</label>
				<input type="radio" id="actEstCliente" name="estCliente" value="A" <?php echo $estCliente['A'];?> />
				<label for='inaEstCliente'>Inactivo</label>
				<input type="radio" id="inaEstCliente" name="estCliente" value="I" <?php echo $estCliente['I'];?> />
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
<?php
	if($opMant=="ed" or $opMant=="li"){
?>
	<br /><br />
	<a href="contactos_mant.php" id="anexo">
		<img src="<?php echo images;?>icon_contact.png" <?php echo sizeImg;?> />
		Agregar Contacto
	</a> 
	<a href="direcciones_mant.php" id="anexo">
		<img src="<?php echo images;?>icon_address.png" <?php echo sizeImg;?> />
		Agregar Direcci&oacute;n
	</a>
	<br /><br />
	<div id="agregarAnexo">
	</div>
	<br /><br />
	<div id="contacto">
		<?php 
			echo $general->grilla($contacto->show($data['idCliente']), 'Contactos de cliente', 'icon_contact.png', 'contactos_mant.php', true, true);
		?>
	</div>
	<br /><br />
	<div id="direccion">
		<?php 
			echo $general->grilla($direccion->show($data['idCliente']), 'Direcciones de cliente', 'icon_address.png', 'direcciones_mant.php', true, true);
		?>
	</div>
<?php
	}
?>
</form>