<?php
require_once('config.php');
require_once(entities.'seguimiento.php');
require_once(entities.'accion.php');
require_once(entities.'alerta.php');
require_once(resources.'general.php');
$seguimiento = new seguimiento();
$accion = new accion();
$alerta = new alerta();
$general = new general();

$opMantDif = "nu";
if(isset($_REQUEST['opMantDif'])){
	$opMantDif = $_REQUEST['opMantDif'];
}

$titulo = "";

$data = array(		
		'idSeguimiento'=>'',
		'idPropuesta'=>'NULL',
		'idAccion'=>'NULL',
		'sigacSeguimiento'=>'',
		'comenSeguimiento'=>'',
		'alerSeguimiento'=>true,
		'fechCrea'=>'',
		'usuCrea'=>$_SESSION['usuario']['id']
);

foreach($data as $key => $value){
	if(isset($_POST[$key])){
		$data[$key] = $_POST[$key];
	}
}

$mensaje = "";

$showLayer = "";

switch($opMantDif){
	case 'nu':
		$titulo = "AGREGAR ";
		if(isset($_POST['comenSeguimiento'])){
			if($_POST['comenSeguimiento']!=""){

				if(!isset($_POST['alerSeguimiento'])){
					$data['alerSeguimiento'] = false;
				}
				$seguimiento->set($data);
				if($seguimiento->insert()){
					$mensaje = "Registro creado correctamente.";
					if($data['alerSeguimiento']){
						require_once(entities.'propuesta.php');
						require_once(entities.'usuario.php');
						$propuesta = new propuesta();
						$usuario = new usuario();
						
						$comercial = "";
						$tecnico = "";
						
						$propuesta->get($data['idPropuesta']);
						$datosPropuesta = $propuesta->setArray;
						
						if(is_numeric($datosPropuesta['idUsuarioComercial'])){
							$usuario->get($datosPropuesta['idUsuarioComercial']);
							$comercial = $usuario->setArray;
							
							
							$dataAler = array(
								"idAlerta"=>"", 
								"idUsuario"=>$datosPropuesta['idUsuarioComercial'], 
								"idRol"=>"NULL", 
								"conteAlerta"=>$data['comenSeguimiento'],
								"linkAlerta"=>"",
								"nomlinkAlerta"=>'',
								"fechAlerta"=>$data['sigacSeguimiento'],
								"fechCrea"=>"",
								"usuCrea"=>0
							);
							$alerta->set($dataAler);
							$alerta->insert();
						}
						
						if(is_numeric($datosPropuesta['idUsuarioTecnico'])){
							$usuario->get($datosPropuesta['idUsuarioTecnico']);
							$tecnico = $usuario->setArray;
							
							/*$dataAler = array(
								"idAlerta"=>"", 
								"idUsuario"=>$datosPropuesta['idUsuarioTecnico'], 
								"idRol"=>"NULL", 
								"conteAlerta"=>$data['comenSeguimiento'],
								"linkAlerta"=>"",
								"nomlinkAlerta"=>'',
								"fechAlerta"=>$data['sigacSeguimiento'],
								"fechCrea"=>"",
								"usuCrea"=>0
							);
							$alerta->set($dataAler);
							$alerta->insert();*/
						}
						
						if(is_array($comercial)){
							$general->enviarCita($comercial['emailUsuario'], "Seguimiento de Propuesta {$datosPropuesta['codPropuesta']}", $data['comenSeguimiento'], $data['sigacSeguimiento'], $data['sigacSeguimiento']);
						}
						if(is_array($tecnico)){
							$general->enviarCita($tecnico['emailUsuario'], "Seguimiento de Propuesta {$datosPropuesta['codPropuesta']}", $data['comenSeguimiento'], $data['sigacSeguimiento'], $data['sigacSeguimiento']);
						}
					}
					$data = array(		
							'idSeguimiento'=>'',
							'idPropuesta'=>'NULL',
							'idAccion'=>'NULL',
							'sigacSeguimiento'=>'',
							'comenSeguimiento'=>'',
							'alerSeguimiento'=>true,
							'fechCrea'=>'',
							'usuCrea'=>$_SESSION['usuario']['id']
					);
				}else{
					$mensaje = "No se pudo realizar el registro.";
				}
			}else{
				$mensaje = "Debe llenar el comentario del seguimiento.";
			}
		}
		break;
	case 'li':
		$titulo = "EDITAR ";
		if(isset($_REQUEST['id'])){
			$id = $_REQUEST['id'];
			$seguimiento->get($id);
			if(is_array($seguimiento->setArray)){
				$data = $seguimiento->setArray;
				$opMantDif = "ed";
			}else{					
				$titulo = "NUEVO ";
				$mensaje = "No se ha podido cargar el registro.";
				$opMantDif = "nu";
			}
		}else{
			$titulo = "NUEVO ";
			$mensaje = "No se ha podido cargar el registro.";			
			$opMantDif = "nu";
		}
		break;
	case 'ed':
		$titulo = "EDITAR ";
		if($_POST['idSeguimiento']<>''){
			if(!isset($_POST['alerSeguimiento'])){
				$data['alerSeguimiento'] = false;
			}
			$seguimiento->set($data);
			if($seguimiento->update()){
				$mensaje = "Registro editado correctamente.";
			}else{
				$mensaje = "No se ha podido editar el registro.";
			}
		}
		break;
	case 'el':
		/*if(isset($_REQUEST['id'])){
			if($seguimiento->delete($_REQUEST['id'])){*/
				$mensaje = "Los registros de seguimiento no pueden ser eliminados.";
			/*}else{
				$mensaje = "No se ha podido eliminar el registro.";
			}
		}*/
		break;
	case 'sh':
		if(isset($_REQUEST['id'])){
			$seguimiento->getLast($_REQUEST['id']);
			$dataAux = $seguimiento->setArray;
			
			$showLayer .= "<h2>";
			$showLayer .= "SEGUIMIENTO";
			$showLayer .= "<img src='".images."icon_trace.png' ".sizeImg." />";
			$showLayer .= "</h2>";
			$showLayer .= "<br />";
			
			if(is_array($dataAux)){
				$showLayer .= "<strong>Acci&oacute;n:</strong> {$dataAux['accion']}";
				$showLayer .= "<br />";
				$showLayer .= "<strong>Siguiente acci&oacute;n:</strong> {$dataAux['sigac']}";
				$showLayer .= "<br />";
				$showLayer .= "<strong>Comentario:</strong> {$dataAux['comentario']}";		
			}else{
				$showLayer .= "No se tienen seguimientos para esta propuesta.";
			}
		}
		break;

}
$idAccion = $general->combo($accion->getCombo(), 'idAccion', '', $data['idAccion']);

$alerSeguimiento = "";
if($data['alerSeguimiento']){
	$alerSeguimiento = "CHECKED";
}

?>
<input type="hidden" id="opMantDif" name="opMantDif" value="<?php echo $opMantDif;?>" />
<input type="hidden" id="idSeguimiento" name="idSeguimiento" value="<?php echo $data['idSeguimiento'];?>" />
<h1>
	<?php echo $titulo;?>SEGUIMIENTO
	<img src="<?php echo images;?>icon_trace.png" <?php echo sizeImg3;?> />
</h1>
<br /><br />
<div id="show"><?php echo $showLayer;?></div>
<p class="mensaje"><?php echo $mensaje;?></p>
<br /><br />
<table>
	<tr>
		<td>	
			<label for="idAccion">Siguiente acci&oacute;n:</label>
		</td>
		<td>	
			<?php echo $idAccion;?>
		</td>
		<td>	
			<label for="sigacSeguimiento">Fecha de siguiente acci&oacute;n:</label>
		</td>
		<td>	
			<input type="text" id="sigacSeguimiento" name="sigacSeguimiento" size="20" value="<?php echo $data['sigacSeguimiento'];?>" />
		</td>
	</tr>
	<tr>
		<td>	
			<label for="alerSeguimiento">Alerta:</label>
		</td>
		<td>	
			<input type="checkbox" id="alerSeguimiento" name="alerSeguimiento" value="1" <?php echo $alerSeguimiento;?> />
		</td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td>	
			<label for="comenSeguimiento">Comentario:</label>
		</td>
		<td colspan="3">	
			<textarea id="comenSeguimiento" name="comenSeguimiento" cols="60" rows="5"><?php echo $data['comenSeguimiento'];?></textarea>
		</td>
	</tr>
	<tr>
		<td colspan="2" class="cent">	
			<button type="button" id="cancelarAnexo" name="cancelarAnexo">Cancelar</button>
		</td>
		<td colspan="2" class="cent">
			<button type="button" id="guardarAnexo" name="guardarAnexo" value="seguimientos_mant.php">Guardar</button>
		</td>
	</tr>
</table>