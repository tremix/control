<?php
require_once('config.php');
require_once(resources . 'general.php');
require_once(entities . 'propuesta.php');
require_once(entities . 'proyecto.php');
require_once(entities . 'cliente.php');
require_once(entities . 'tipoPropuesta.php');
require_once(entities . 'tipoServicio.php');
require_once(entities . 'tipoArea.php');
require_once(entities . 'moneda.php');
require_once(entities . 'situacion.php');
require_once(entities . 'proyectoEtapa.php');
require_once(entities . 'proyectoActividad.php');
require_once(entities . 'responsable.php');
$general = new general();
$propuesta = new propuesta();
$proyecto = new proyecto();
$cliente = new cliente();
$tipoPropuesta = new tipoPropuesta();
$tipoServicio = new tipoServicio();
$tipoArea = new tipoArea();
$moneda = new moneda();
$situacion = new situacion();
$proyectoEtapa = new proyectoEtapa();
$proyectoActividad = new proyectoActividad();
$responsable = new responsable();

$opMant = "nu";
if (isset($_REQUEST['opMant'])) {
    $opMant = $_REQUEST['opMant'];
}

$titulo = "";

$data = array(
    'idProyecto' => NULL,
    'idPropuesta' => 'NULL',
    'costoHoraProyecto' => 0,
    'esFacturableProyecto' => false,
    'estadoProyecto' => 1,
    'fechaCreacion' => '',
    'fechaEdicion' => '',
    'usuarioCreacion' => $_SESSION['usuario']['id'],
    'usuarioEdicion' => $_SESSION['usuario']['id']
);

foreach ($data as $key => $value) {
    if (isset($_REQUEST[$key])) {
        $data[$key] = $_REQUEST[$key];
    }
}

$mensaje = "";

switch ($opMant) {
    case 'li':
        $titulo = "EDITAR ";
        if (isset($_REQUEST['id'])) {
            $id = $_REQUEST['id'];
            $proyecto->get($id);
            if (is_array($proyecto->setArray)) {
                $data = $proyecto->setArray;
                $opMant = "ed";
            }
        }
        break;
    case 'ed':
        $titulo = "EDITAR ";
        if ($_POST['idProyecto'] <> '') {
            $proyecto->set($data);
            if ($proyecto->update()) {
                $mensaje = "Registro editado correctamente.";
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

$esFacturableProyecto = "";
if ($data['esFacturableProyecto']) {
    $esFacturableProyecto = "CHECKED";
}

$propuesta->get($data['idPropuesta']);
$dataPropuesta = $propuesta->setArray;
?>
<form id="formProyectosMant" name="formProyectosMant" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <input type="hidden" id="opMant" name="opMant" value="<?php echo $opMant; ?>" />
    <input type="hidden" id="idProyecto" name="idProyecto" value="<?php echo $data['idProyecto']; ?>" />
    <input type="hidden" id="idPropuesta" name="idPropuesta" value="<?php echo $data['idPropuesta']; ?>" />
    <h1>
        <?php echo $titulo; ?>PROYECTO
        <img src="<?php echo images; ?>icon_project.png" <?php echo sizeImg3; ?> />
    </h1>
    <br /><br />
    <p class="mensaje"><?php echo $mensaje; ?></p>
    <br /><br />
    <table id="marginado">
        <tr>
            <td colspan="4" class="negr">INFORMACI&Oacute;N GENERAL</td>
        </tr>
        <tr>
            <td class="negr">Cliente:</td>
            <td><?php echo $cliente->getNameByID($dataPropuesta['idCliente']); ?></td>
            <td class="negr">C&oacute;digo:</td>
            <td><?php echo $dataPropuesta['codPropuesta']; ?></td>
        </tr>
        <tr>
            <td class="negr">Tipo:</td>
            <td><?php echo $tipoPropuesta->getNameByID($dataPropuesta['idTipoPropuesta']); ?></td>
            <td class="negr">&Aacute;rea:</td>
            <td><?php echo $tipoArea->getNameByID($dataPropuesta['idTipoArea']); ?></td>
        </tr>
        <tr>
            <td class="negr">Servicio:</td>
            <td><?php echo $tipoServicio->getNameByID($dataPropuesta['idTipoServicio']); ?></td>
            <td class="negr">Fecha de propuesta:</td>
            <td><?php echo $dataPropuesta['fechPropuesta']; ?></td>
        </tr>
        <tr>
            <td class="negr">Comisi&oacute;n:</td>
            <td><?php echo ($dataPropuesta['comiPropuesta']) ? "S&iacute;" : "No"; ?></td>
            <td class="negr">Licitaci&oacute;n:</td>
            <td><?php echo ($dataPropuesta['liciPropuesta']) ? "S&iacute;" : "No"; ?></td>
        </tr>
        <tr>
            <td class="negr">Descripci&oacute;n:</td>
            <td colspan="3"><?php echo $dataPropuesta['descrPropuesta']; ?></td>
        </tr>
        <tr>
            <td class="negr">Moneda:</td>
            <td><?php echo $moneda->getNameByID($dataPropuesta['idMoneda']); ?></td>
            <td class="negr">Monto:</td>
            <td><?php echo $dataPropuesta['montoPropuesta']; ?></td>
        </tr>
        <tr>
            <td class="negr">Situaci&oacute;n:</td>
            <td><?php echo $situacion->getNameByID($dataPropuesta['idSituacion']); ?></td>
            <td class="negr">Varios:</td>
            <td><?php echo $dataPropuesta['varPropuesta']; ?></td>
        </tr>
    </table>
    <br />
    <table>
        <tr>
            <td>	
                <label for="costoHoraProyecto">Costo por hora:</label>
            </td>
            <td>	
                <input type="text" id="costoHoraProyecto" name="costoHoraProyecto" size="8" value="<?php echo $data['costoHoraProyecto']; ?>" />
            </td>
            <td>	
                <label for="esFacturableProyecto">Es facturable:</label>
            </td>
            <td>
                <input type="checkbox" id="esFacturableProyecto" name="esFacturableProyecto" value="1" <?php echo $esFacturableProyecto; ?> />
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
    if ($opMant == "ed" or $opMant == "li") {
        ?>
        <br /><br />
        <a href="proyectoEtapas_mant.php?idProyecto=<?php echo $data['idProyecto']; ?>&idTipoServicio=<?php echo $dataPropuesta['idTipoServicio']; ?>" id="anexo">
            <img src="<?php echo images; ?>icon_project.png" <?php echo sizeImg; ?> />
            Agregar Etapa
        </a> 
        <a href="proyectoActividades_mant.php?idProyecto=<?php echo $data['idProyecto']; ?>" id="anexo">
            <img src="<?php echo images; ?>icon_annex.png" <?php echo sizeImg; ?> />
            Agregar Actividad
        </a>
        <a href="responsables_mant.php?idProyecto=<?php echo $data['idProyecto']; ?>" id="anexo">
            <img src="<?php echo images; ?>icon_customer.png" <?php echo sizeImg; ?> />
            Agregar Responsable
        </a>
        <br /><br />
        <div id="agregarAnexo">
        </div>
        <br /><br />
        <div id="proyectoEtapa">
            <?php
            echo $general->grilla($proyectoEtapa->show($data['idProyecto']), 'Etapas de proyecto', 'icon_project.png', 'proyectoEtapas_mant.php', true, true);
            ?>
        </div>
        <br /><br />
        <div id="proyectoActividad">
            <?php
            echo $general->grilla($proyectoActividad->show($data['idProyecto']), 'Actividades de proyecto', 'icon_annex.png', 'proyectoActividades_mant.php', true, true);
            ?>
        </div>
        <br /><br />
        <div id="responsable">
            <?php
            echo $general->grilla($responsable->show($data['idProyecto']), 'Responsables de proyecto', 'icon_customer.png', 'responsables_mant.php', true, true);
            ?>
        </div>
        <?php
    }
    ?>
</form>