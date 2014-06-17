<?php
require_once('config.php');
require_once(resources . 'general.php');
require_once(entities . 'etapa.php');
require_once(entities . 'tipoServicio.php');
require_once(entities . 'actividad.php');
$general = new general();
$etapa = new etapa();
$tipoServicio = new tipoServicio();
$actividad = new actividad();

$opMant = "nu";
if (isset($_REQUEST['opMant'])) {
    $opMant = $_REQUEST['opMant'];
}

$titulo = "";

$data = array(
    'idEtapa' => NULL,
    'idTipoServicio' => 'NULL',
    'nombreEtapa' => ''
);

foreach ($data as $key => $value) {
    if (isset($_POST[$key])) {
        $data[$key] = $_POST[$key];
    }
}

$mensaje = "";

switch ($opMant) {
    case 'nu':
        $titulo = "CREAR ";
        if (isset($_POST['idTipoServicio']) and isset($_POST['nombreEtapa'])) {
            if ($_POST['idTipoServicio'] != "NULL" and $_POST['nombreEtapa'] != "") {
                $etapa->set($data);
                $id = $etapa->insert();
                if ($id) {
                    $data['idEtapa'] = $id;
                    $opMant = "ed";
                    $titulo = "EDITAR ";
                    $mensaje = "Registro creado correctamente.";
                } else {
                    $mensaje = "No se pudo realizar el registro.";
                }
            } else {
                $mensaje = "Debe llenar por lo menos la Raz&oacute;n Social y el RUC para registrar un cliente.";
            }
        }
        break;

    case 'li':
        $titulo = "EDITAR ";
        if (isset($_REQUEST['id'])) {
            $id = $_REQUEST['id'];
            $etapa->get($id);
            if (is_array($etapa->setArray)) {
                $data = $etapa->setArray;
                $opMant = "ed";
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
        if (isset($_POST['idTipoServicio']) and isset($_POST['nombreEtapa'])) {
            if ($_POST['idTipoServicio'] != "NULL" and $_POST['nombreEtapa'] != "") {
                $etapa->set($data);
                if ($etapa->update()) {
                    $mensaje = "Registro editado correctamente.";
                } else {
                    $mensaje = "No se ha podido editar el registro.";
                }
            }
        }
        break;
    case 'el':
        if (isset($_REQUEST['id'])) {
            if ($etapa->updateStatus($_REQUEST['id'])) {
                $mensaje = "Registro eliminado correctamente.";
            } else {
                $mensaje = "No se ha podido eliminar el registro.";
            }
        }
        break;
}

$idTipoServicio = $general->combo($tipoServicio->getCombo(), 'idTipoServicio', '', $data['idTipoServicio']);
?>
<form id="formEtapasMant" name="formEtapasMant" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <input type="hidden" id="opMant" name="opMant" value="<?php echo $opMant; ?>" />
    <input type="hidden" id="idEtapa" name="idEtapa" value="<?php echo $data['idEtapa']; ?>" />
    <h1>
        <?php echo $titulo; ?>ETAPA
        <img src="<?php echo images; ?>icon_project.png" <?php echo sizeImg3; ?> />
    </h1>
    <br /><br />
    <p class="mensaje"><?php echo $mensaje; ?></p>
    <br /><br />
    <table>
        <tr>
            <td>	
                <label for="idTipoServicio">Tipo de servicio:</label>
            </td>
            <td>	
                <?php echo $idTipoServicio; ?>
            </td>
            <td>	
                <label for="nombreEtapa">Nombre:</label>
            </td>
            <td>	
                <input type="text" id="nombreEtapa" name="nombreEtapa" size="30" value="<?php echo $data['nombreEtapa']; ?>" />
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
        <a href="actividades_mant.php?idEtapa=<?php echo $data['idEtapa']; ?>" id="anexo">
            <img src="<?php echo images; ?>icon_annex.png" <?php echo sizeImg; ?> />
            Agregar Actividad
        </a> 
        <br /><br />
        <div id="agregarAnexo">
        </div>
        <br /><br />
        <div id="actividad">
            <?php
            echo $general->grilla($actividad->show($data['idEtapa']), 'Actividades de etapa', 'icon_annex.png', 'actividades_mant.php', true, true);
            ?>
        </div>
        <?php
    }
    ?>
</form>