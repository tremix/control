<?php
require_once('config.php');
require_once(resources.'general.php');
require_once(entities.'cliente.php');
require_once(entities.'propuesta.php');
require_once(entities.'seguimiento.php');

$general = new general();
$cliente = new cliente();
$propuesta = new propuesta();
$seguimiento = new seguimiento();

$cliente->get($_REQUEST['id']);
$dataCliente = $cliente->setArray;

$dataPropuesta = $propuesta->getByCliente($_REQUEST['id']);
?>
<h1>
	HISTORIAL DE <?php echo strtoupper($dataCliente['nomcomCliente']);?>
	<img src="<?php echo images;?>icon_history.png" <?php echo sizeImg3;?> />
</h1>
<br /><br />
<?php
	if(is_array($dataPropuesta)){
		for($i=1; $i<=count($dataPropuesta); $i++){
?>
			<table id="grilla" class="marginadoChico">
				<thead>
					<tr>
						<td colspan="4">
                        	<center>
                        		<a href="propuestas.php?id=<?php echo $dataPropuesta[$i]['id'];?>">
                                	PROPUESTA <?php echo $dataPropuesta[$i]['codigo'];?>
								</a>
							</center>
                        </td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="alt">Tipo de Propuesta:</td>
						<td><?php echo $dataPropuesta[$i]['tipoPropuesta'];?></td>
						<td class="alt">Tipo de Servicio:</td>
						<td><?php echo $dataPropuesta[$i]['tipoServicio'];?></td>
					</tr>
					<tr>
						<td class="alt">&Aacute;rea:</td>
						<td><?php echo $dataPropuesta[$i]['area'];?></td>
						<td class="alt"></td>
						<td></td>
					</tr>
					<tr>
						<td class="alt">Responsable comercial:</td>
						<td><?php echo $dataPropuesta[$i]['comercial'];?></td>
						<td class="alt">Responsable t&eacute;cnico:</td>
						<td><?php echo $dataPropuesta[$i]['tecnico'];?></td>
					</tr>
					<tr>
						<td class="alt">Moneda:</td>
						<td><?php echo $dataPropuesta[$i]['moneda'];?></td>
						<td class="alt">Monto:</td>
						<td><?php echo number_format(round($dataPropuesta[$i]['monto'], 2), 2, ",", ".");?></td>
					</tr>
					<tr>
						<td class="alt">Descripci&oacute;n:</td>
						<td colspan="3"><?php echo $dataPropuesta[$i]['descripcion'];?></td>
					</tr>
				</tbody>
			</table>
			<br />
			<?php
				echo $general->grilla($seguimiento->show($dataPropuesta[$i]['id']), 'Seguimiento de Propuesta '.$dataPropuesta[$i]['codigo'], '', '', false, true);
			?>
			<br /><br />
<?php
		}
	}else{
		echo '<p>Este cliente no tiene propuestas registradas.</p>';
	}
?>