<?php
require_once('config.php');
require_once(resources . 'general.php');
require_once(entities . 'propuesta.php');
require_once(entities . 'cliente.php');
require_once(entities . 'tipoPropuesta.php');
require_once(entities . 'tipoServicio.php');
require_once(entities . 'tipoArea.php');
require_once(entities . 'moneda.php');
require_once(entities . 'usuario.php');
require_once(entities . 'situacion.php');
require_once(entities . 'seguimiento.php');
require_once(entities . 'alerta.php');
require_once(entities . 'proyecto.php');
$general = new general();
$cliente = new cliente();
$propuesta = new propuesta();
$tipoPropuesta = new tipoPropuesta();
$tipoServicio = new tipoServicio();
$tipoArea = new tipoArea();
$moneda = new moneda();
$usuario = new usuario();
$situacion = new situacion();
$seguimiento = new seguimiento();
$alerta = new alerta();
$proyecto = new proyecto();

$opMant = "nu";
if (isset($_REQUEST['opMant'])) {
    $opMant = $_REQUEST['opMant'];
}

$titulo = "";

$data = array(
    'idPropuesta' => '',
    'idCliente' => 'NULL',
    'idUsuarioComercial' => $_SESSION['usuario']['id'],
    'idUsuarioTecnico' => 'NULL',
    'idMoneda' => 'NULL',
    'idTipoServicio' => 'NULL',
    'idTipoArea' => 'NULL',
    'idTipoPropuesta' => 'NULL',
    'idSituacion' => 'NULL',
    'correPropuesta' => '',
    'codPropuesta' => '',
    'varPropuesta' => '',
    'fechPropuesta' => '',
    'comiPropuesta' => false,
    'liciPropuesta' => false,
    'porcPropuesta' => 0,
    'descrPropuesta' => '',
    'montoPropuesta' => '',
    'fechestiPropuesta' => '',
    'aproPropuesta' => false,
    'estPropuesta' => '',
    'fechCrea' => '',
    'fechEdita' => '',
    'usuCrea' => $_SESSION['usuario']['id'],
    'usuEdita' => $_SESSION['usuario']['id']
);

foreach ($data as $key => $value) {
    if (isset($_REQUEST[$key])) {
        $data[$key] = $_REQUEST[$key];
    }
}

$mensaje = "";
$soloLectura = "";

switch ($opMant) {
    case 'nu':
        $titulo = "CREAR ";
        $data['correPropuesta'] = $propuesta->getCod($data['idCliente']);
        $data['codPropuesta'] = 'P' . str_pad($cliente->getCodByID($data['idCliente']), 4, "0", STR_PAD_LEFT);
        $data['codPropuesta'] .= str_pad($data['correPropuesta'], 2, "0", STR_PAD_LEFT);
        if (isset($_POST['idCliente']) and isset($_POST['codPropuesta'])) {
            if ($_POST['idCliente'] != "NULL" and $_POST['codPropuesta'] != "" and $_POST['descrPropuesta'] != "" and $_POST['idTipoServicio'] != "NULL" and $_POST['idSituacion'] != "NULL") {
                if ($_POST['idTipoArea'] == 'NULL') {
                    $data['idTipoArea'] = $tipoServicio->getTipoAreaByID($data['idTipoServicio']);
                    $data['idTipoPropuesta'] = $tipoArea->getTipoPropuestaByID($data['idTipoArea']);
                }
                $propuesta->set($data);
                $id = $propuesta->insert();
                if ($id) {

                    $data['idPropuesta'] = $id;
                    $opMant = "ed";
                    $titulo = "EDITAR ";
                    $mensaje = "Registro creado correctamente.";

                    //Utilizamos este trozo de código para convertir el registro en solo lectura
                    //cuando ya se ha convertido en proyecto.
                    if ($situacion->getNameByID($data['idSituacion']) == 'SI') {

                        $dataProyecto = array(
                            'idProyecto' => NULL,
                            'idPropuesta' => $data['idPropuesta'],
                            'costoHoraProyecto' => 0,
                            'esFacturableProyecto' => false,
                            'estadoProyecto' => 1,
                            'fechaCreacion' => '',
                            'fechaEdicion' => '',
                            'usuarioCreacion' => $_SESSION['usuario']['id'],
                            'usuarioEdicion' => $_SESSION['usuario']['id']
                        );
                        $proyecto->set($dataProyecto);
                        $idProyecto = $proyecto->insert();
                        $soloLectura = ($idProyecto) ? disabled : "";
                        $mensaje .= "</p><p class='mensaje2'>Se ha generado un proyecto de esta propuesta, puedes acceder a &eacute;l haciendo clic <a href='proyectos.php?id={$idProyecto}'>aqu&iacute;</a>.";
                    }

                    if ($data['idUsuarioComercial'] <> "NULL") {
                        $usuario->get($data['idUsuarioComercial']);
                        $datosComercial = $usuario->setArray;
                        $asunto = "Se te ha asignado una nueva propuesta.";
                        $mensajeMail = "Eres el responsable comercial de la propuesta ";
                        $mensajeMail .= '<a target="_blank" href="http://' . baseURL . 'propuestas.php?id=' . $id . '">' . $data['codPropuesta'] . '</a>.';
                        $general->enviarMail($datosComercial['emailUsuario'], $asunto, $mensajeMail);
                        $dataAler = array(
                            "idAlerta" => "",
                            "idUsuario" => $data['idUsuarioComercial'],
                            "idRol" => "NULL",
                            "conteAlerta" => $mensajeMail,
                            "linkAlerta" => "",
                            "nomlinkAlerta" => "",
                            "fechAlerta" => date("Y-m-d"),
                            "fechCrea" => "",
                            "usuCrea" => 0
                        );
                        $alerta->set($dataAler);
                        $alerta->insert();
                    }
                    if ($data['idUsuarioTecnico'] <> "NULL") {
                        $usuario->get($data['idUsuarioTecnico']);
                        $datosTecnico = $usuario->setArray;
                        $asunto = "Se te ha asignado una nueva propuesta.";
                        $mensajeMail = "Eres el responsable t&eacute;nico de la propuesta ";
                        $mensajeMail .= '<a target="_blank" href="http://' . baseURL . 'propuestas.php?id=' . $id . '">' . $data['codPropuesta'] . '</a>.';
                        $general->enviarMail($datosTecnico['emailUsuario'], $asunto, $mensajeMail);
                        $dataAler = array(
                            "idAlerta" => "",
                            "idUsuario" => $data['idUsuarioTecnico'],
                            "idRol" => "NULL",
                            "conteAlerta" => $mensajeMail,
                            "linkAlerta" => "",
                            "nomlinkAlerta" => "",
                            "fechAlerta" => date("Y-m-d"),
                            "fechCrea" => "",
                            "usuCrea" => 0
                        );
                        $alerta->set($dataAler);
                        $alerta->insert();
                    }
                } else {
                    $mensaje = "No se pudo realizar el registro.";
                }
            } else {
                $mensaje = "Debe seleccionar un cliente, una situaci&oacute;n, un tipo de servicio y escribir la descripci&oacute;n para poder generar una propuesta.";
            }
        }
        break;

    case 'li':
        $titulo = "EDITAR ";
        if (isset($_REQUEST['id'])) {
            $id = $_REQUEST['id'];
            $propuesta->get($id);
            if (is_array($propuesta->setArray)) {
                $data = $propuesta->setArray;
                $opMant = "ed";


                //Utilizamos este trozo de código para convertir el registro en solo lectura
                //cuando ya se ha convertido en proyecto.
                if ($situacion->getNameByID($data['idSituacion']) == 'SI') {
                    $soloLectura = disabled;
                    $idProyecto = $proyecto->getIdByProposalID($data['idPropuesta']);
                    if ($idProyecto) {
                        $mensaje = "Se ha generado un proyecto de esta propuesta, puedes acceder a &eacute;l haciendo clic <a href='proyectos.php?id={$idProyecto}'>aqu&iacute;</a>.";
                    }
                }
            } else {
                $titulo = "NUEVO ";
                $mensaje = "No se ha podido cargar el registro.";
                $opMant = "nu";
            }
        } else {
            $titulo = "NUEVO ";
            $mensaje = "No se ha podido cargar el registro.";
            $opMant = "nu";
        }
        break;
    case 'ed':
        $titulo = "EDITAR ";
        if ($_POST['idPropuesta'] <> '') {
            $propuesta->get($data['idPropuesta']);
            $dataAux = $propuesta->setArray;
            
            $propuesta->set($data);
            if ($propuesta->update()) {
                if ($dataAux['idUsuarioComercial'] <> $data['idUsuarioComercial'] and $data['idUsuarioComercial'] <> "NULL") {
                    $usuario->get($data['idUsuarioComercial']);
                    $datosComercial = $usuario->setArray;
                    $asunto = "Se te ha asignado una propuesta.";
                    $mensajeMail = "Eres el responsable comercial de la propuesta ";
                    $mensajeMail .= '<a target="_blank" href="http://' . baseURL . 'propuestas.php?id=' . $id . '">' . $data['codPropuesta'] . '</a>.';
                    $general->enviarMail($datosComercial['emailUsuario'], $asunto, $mensajeMail);
                    $dataAler = array(
                        "idAlerta" => "",
                        "idUsuario" => $data['idUsuarioComercial'],
                        "idRol" => "NULL",
                        "conteAlerta" => $mensajeMail,
                        "linkAlerta" => "",
                        "nomlinkAlerta" => "",
                        "fechAlerta" => date("Y-m-d"),
                        "fechCrea" => "",
                        "usuCrea" => 0
                    );
                    $alerta->set($dataAler);
                    $alerta->insert();
                }
                if ($dataAux['idUsuarioTecnico'] <> $data['idUsuarioTecnico'] and $data['idUsuarioTecnico'] <> "NULL") {
                    $usuario->get($data['idUsuarioTecnico']);
                    $datosTecnico = $usuario->setArray;
                    $asunto = "Se te ha asignado una propuesta.";
                    $mensajeMail = "Eres el responsable t&eacute;nico de la propuesta ";
                    $mensajeMail .= '<a target="_blank" href="http://' . baseURL . 'propuestas.php?id=' . $id . '">' . $data['codPropuesta'] . '</a>.';
                    $general->enviarMail($datosTecnico['emailUsuario'], $asunto, $mensajeMail);
                    $dataAler = array(
                        "idAlerta" => "",
                        "idUsuario" => $data['idUsuarioTecnico'],
                        "idRol" => "NULL",
                        "conteAlerta" => $mensajeMail,
                        "linkAlerta" => "",
                        "nomlinkAlerta" => "",
                        "fechAlerta" => date("Y-m-d"),
                        "fechCrea" => "",
                        "usuCrea" => 0
                    );
                    $alerta->set($dataAler);
                    $alerta->insert();
                }
                $mensaje = "Registro editado correctamente.";

                //Utilizamos este trozo de código para convertir el registro en solo lectura
                //cuando ya se ha convertido en proyecto.
                if ($situacion->getNameByID($data['idSituacion']) == 'SI') {

                    $dataProyecto = array(
                        'idProyecto' => NULL,
                        'idPropuesta' => $data['idPropuesta'],
                        'costoHoraProyecto' => 0,
                        'esFacturableProyecto' => false,
                        'estadoProyecto' => 1,
                        'fechaCreacion' => '',
                        'fechaEdicion' => '',
                        'usuarioCreacion' => $_SESSION['usuario']['id'],
                        'usuarioEdicion' => $_SESSION['usuario']['id']
                    );
                    $proyecto->set($dataProyecto);
                    $idProyecto = $proyecto->insert();
                    $soloLectura = ($idProyecto) ? disabled : "";
                    $mensaje .= "</p><p class='mensaje2'>Se ha generado un proyecto de esta propuesta, puedes acceder a &eacute;l haciendo clic <a href='proyectos.php?id={$idProyecto}'>aqu&iacute;</a>.";
                }
            } else {
                $mensaje = "No se ha podido editar el registro.";
            }
        }
        break;
    case 'el':
        if (isset($_REQUEST['id'])) {
            if ($propuesta->updateStatus($_REQUEST['id'])) {
                $mensaje = "Registro eliminado correctamente.";
            } else {
                $mensaje = "No se ha podido eliminar el registro.";
            }
        }
        break;
}

$idCliente = $general->combo($cliente->getCombo(), 'idCliente', '', $data['idCliente'], $soloLectura);
$idTipoPropuesta = $general->combo($tipoPropuesta->getCombo(), 'idTipoPropuesta', '', $data['idTipoPropuesta'], $soloLectura);
$idTipoArea = $general->combo($tipoArea->getCombo($data['idTipoPropuesta']), 'idTipoArea', '', $data['idTipoArea'], $soloLectura);
$idTipoServicio = $general->combo($tipoServicio->getCombo($data['idTipoArea']), 'idTipoServicio', '', $data['idTipoServicio'], $soloLectura);
$idMoneda = $general->combo($moneda->getCombo(), 'idMoneda', '', $data['idMoneda'], $soloLectura);
$idUsuarioComercial = $general->combo($usuario->getCombo(), 'idUsuarioComercial', '', $data['idUsuarioComercial'], $soloLectura);
$idUsuarioTecnico = $general->combo($usuario->getCombo(), 'idUsuarioTecnico', '', $data['idUsuarioTecnico'], $soloLectura);
$idSituacion = $general->combo($situacion->getCombo(), 'idSituacion', '', $data['idSituacion'], $soloLectura);

$comiPropuesta = "";
if ($data['comiPropuesta']) {
    $comiPropuesta = "CHECKED";
}
$liciPropuesta = "";
if ($data['liciPropuesta']) {
    $liciPropuesta = "CHECKED";
}

if ($opMant == "li" or $opMant == "ed") {
    $cliente->get($data['idCliente']);
    $datosCliente = $cliente->setArray;
    $idCliente = "<input type='hidden' id='idCliente' name='idCliente' value='{$data['idCliente']}' $soloLectura />";
    $idCliente .= "<input type='text' value='{$datosCliente['nomcomCliente']}' size='50' readonly $soloLectura />";
}
?>
<form id="formPropuestasMant" name="formPropuestasMant" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <input type="hidden" id="opMant" name="opMant" value="<?php echo $opMant; ?>" />
    <input type="hidden" id="idPropuesta" name="idPropuesta" value="<?php echo $data['idPropuesta']; ?>" />
    <h1>
        <?php echo $titulo; ?>PROPUESTA
        <img src="<?php echo images; ?>icon_proposal.png" <?php echo sizeImg3; ?> />
    </h1>
    <br /><br />
    <p class="mensaje"><?php echo $mensaje; ?></p>
    <br /><br />
    <table>
        <tr>
            <td>	
                <label for="idCliente">Cliente:</label>
            </td>
            <td>	
                <?php echo $idCliente; ?>
            </td>
            <td>	
                <label for="codPropuesta">C&oacute;digo:</label>
            </td>
            <td>	
                <input type="hidden" id="correPropuesta" name="correPropuesta" value="<?php echo $data['correPropuesta']; ?>" />
                <input type="text" id="codPropuesta" name="codPropuesta" size="10" value="<?php echo $data['codPropuesta']; ?>" readonly <?php echo $soloLectura; ?> />
            </td>
        </tr>
        <tr>
            <td>	
                <label for="idTipoPropuesta">Tipo:</label>
            </td>
            <td>	
                <?php echo $idTipoPropuesta; ?>
            </td>
            <td>	
                <label for="idTipoArea">&Aacute;rea:</label>
            </td>
            <td>	
                <?php echo $idTipoArea; ?>
            </td>
        </tr>
        <tr>
            <td>	
                <label for="idTipoServicio">Servicio:</label>
            </td>
            <td>	
                <?php echo $idTipoServicio; ?>
            </td>
            <td>	
                <label for="fechPropuesta">Fecha de Propuesta:</label>
            </td>
            <td>
                <input type="text" id="fechPropuesta" name="fechPropuesta" value="<?php echo $data['fechPropuesta']; ?>" <?php echo $soloLectura; ?> />
            </td>
        </tr>
        <tr>
            <td>	
                <label for="comiPropuesta">Comisi&oacute;n:</label>
            </td>
            <td>
                <input type="checkbox" id="comiPropuesta" name="comiPropuesta" value="1" <?php echo $comiPropuesta; ?> <?php echo $soloLectura; ?> />
            </td>
            <td>	
                <label for="liciPropuesta">Licitaci&oacute;n:</label>
            </td>
            <td>
                <input type="checkbox" id="liciPropuesta" name="liciPropuesta" value="1" <?php echo $liciPropuesta; ?> <?php echo $soloLectura; ?> />
            </td>
        </tr>
        <tr>
            <td>	
                <label for="descrPropuesta">Descripci&oacute;n:</label>
            </td>
            <td colspan="3">	
                <textarea id="descrPropuesta" name="descrPropuesta" cols="60" rows="5" <?php echo $soloLectura; ?>><?php echo $data['descrPropuesta']; ?></textarea>
            </td>
        </tr>
        <tr>
            <td>	
                <label for="idMoneda">Moneda:</label>
            </td>
            <td>	
                <?php echo $idMoneda; ?>
            </td>
            <td>	
                <label for="montoPropuesta">Monto:</label>
            </td>
            <td>	
                <input type="text" id="montoPropuesta" name="montoPropuesta" size="8" value="<?php echo $data['montoPropuesta']; ?>" <?php echo $soloLectura; ?> />
            </td>
        </tr>
        <tr>
            <td>	
                <label for="idUsuarioComercial">Responsable Comercial:</label>
            </td>
            <td>	
                <?php echo $idUsuarioComercial; ?>
            </td>
            <td>	
                <label for="idUsuarioTecnico">Responsable T&eacute;cnico:</label>
            </td>
            <td>	
                <?php echo $idUsuarioTecnico; ?>
            </td>
        </tr>
        <tr>
            <td>	
                <label for="fechestiPropuesta">Fecha estimada:</label>
            </td>
            <td>	
                <input type="text" id="fechestiPropuesta" name="fechestiPropuesta" value="<?php echo $data['fechestiPropuesta']; ?>" <?php echo $soloLectura; ?> />
            </td>
            <td>	
                <label for="porcPropuesta">Progreso:</label>
            </td>
            <td>
                <input type="text" id="porcPropuesta" name="porcPropuesta" size="5" value="<?php echo number_format($data['porcPropuesta'], 0); ?>" <?php echo $soloLectura; ?> /> %
            </td>
        </tr>
        <tr>
            <td>	
                <label for="idSituacion">Situaci&oacute;n:</label>
            </td>
            <td>	
                <?php echo $idSituacion; ?>
            </td>
            <td>	
                <label for="varPropuesta">Varios:</label>
            </td>
            <td>	
                <input type="text" id="varPropuesta" name="varPropuesta" value="<?php echo $data['varPropuesta']; ?>" <?php echo $soloLectura; ?> />
            </td>
        </tr>
        <tr>
            <td colspan="2" class="cent">
                <button type="button" id="cancelar" name="cancelar">Cancelar</button>
            </td>
            <td colspan="2" class="cent">
                <?php if ($soloLectura == '') { ?>
                    <button type="button" id="guardar" name="guardar">Guardar</button>
                <?php } ?>
            </td>
        </tr>
    </table>
    <?php if ($opMant == "ed" or $opMant == "li") { ?>
        <br /><br />
        <?php if ($soloLectura == '') { ?>
            <a href="seguimientos_mant.php" id="anexo">
                <img src="<?php echo images; ?>icon_trace.png" <?php echo sizeImg; ?> />
                Agregar Seguimiento
            </a> 
        <?php } ?>
        <br /><br />
        <div id="agregarAnexo">
        </div>
        <br /><br />
        <div id="seguimiento">
            <?php
            $linkDif = ($soloLectura == '') ? 'seguimientos_mant.php' : '';
            echo $general->grilla($seguimiento->show($data['idPropuesta']), 'Seguimiento de Propuesta', 'icon_trace.png', $linkDif, true, true);
            ?>
        </div>
    <?php } ?>
</form>