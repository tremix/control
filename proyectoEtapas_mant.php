<?php
require_once('config.php');
require_once(resources . 'general.php');
require_once(entities . 'proyectoEtapa.php');
require_once(entities . 'etapa.php');
$general = new general();
$proyectoEtapa = new proyectoEtapa();
$etapa = new etapa();

$opMantDif = "nu";
if (isset($_REQUEST['opMantDif'])) {
    $opMantDif = $_REQUEST['opMantDif'];
}

$titulo = "";

$data = array(
    'idProyectoEtapa' => NULL,
    'idProyecto' => 'NULL',
    'idEtapa' => 'NULL'
);

foreach ($data as $key => $value) {
    if (isset($_REQUEST[$key])) {
        $data[$key] = $_REQUEST[$key];
    }
}

$mensaje = "";

$showLayer = "";

switch ($opMantDif) {
    case 'nu':
        $titulo = "CREAR ";
        if (isset($_POST['idEtapa'])) {
            if ($_POST['idProyecto'] != "" and $_POST['idEtapa'] != "NULL" ) {
                $proyectoEtapa->set($data);
                $id = $proyectoEtapa->insert();
                if ($id) {
                    $data['idProyectoEtapa'] = $id;
                    $opMantDif = "ed";
                    $titulo = "EDITAR ";
                    $mensaje = "Registro creado correctamente.";
                } else {
                    $mensaje = "No se pudo realizar el registro.";
                }
            } else {
                $mensaje = "Debe llena la direcci&oacute;n.";
            }
        }
        break;

    case 'li':
        $titulo = "EDITAR ";
        if (isset($_REQUEST['id'])) {
            $id = $_REQUEST['id'];
            $proyectoEtapa->get($id);
            if (is_array($proyectoEtapa->setArray)) {
                $data = $proyectoEtapa->setArray;
                $opMantDif = "ed";
            } else {
                $titulo = "NUEVO ";
                $mensaje = "No se ha podido cargar el registro.";
                $opMantDif = "nu";
            }
        } else {
            $titulo = "NUEVO ";
            $mensaje = "No se ha podido cargar el registro.";
            $opMantDif = "nu";
        }
        break;
    case 'ed':
        $titulo = "EDITAR ";
         if ($_POST['idProyecto'] != "NULL" and $_POST['idActividad'] != "NULL" and $_POST['fechaInicioProyectoActividad'] != "" and $_POST['fechaFinalProyectoActividad'] != "" and $_POST['horasAsignadasProyectoActividad'] != "") {
            $proyectoEtapa->set($data);
            if ($proyectoEtapa->update()) {
                $mensaje = "Registro editado correctamente.";
            } else {
                $mensaje = "No se ha podido editar el registro.";
            }
        }
        break;
    case 'el':
        if (isset($_REQUEST['id'])) {
            if ($proyectoEtapa->delete($_REQUEST['id'])) {
                $mensaje = "Registro eliminado correctamente.";
            } else {
                $mensaje = "No se ha podido eliminar el registro.";
            }
        }
        break;
}


$idEtapa = $general->combo($etapa->getCombo($_REQUEST['idTipoServicio']), 'idEtapa', '', $data['idEtapa']);
        
?>
<input type="hidden" id="opMantDif" name="opMantDif" value="<?php echo $opMantDif; ?>" />
<input type="hidden" id="idProyectoEtapa" name="idProyectoEtapa" value="<?php echo $data['idProyectoEtapa']; ?>" />
<input type="hidden" id="idProyecto" name="idProyecto" value="<?php echo $data['idProyecto']; ?>" />
<input type="hidden" id="idTipoServicio" name="idTipoServicio" value="<?php echo $_REQUEST['idTipoServicio']; ?>" />
<h1>
    <?php echo $titulo; ?>ETAPA DE PROYECTO
    <img src="<?php echo images; ?>icon_project.png" <?php echo sizeImg3; ?> />
</h1>
<br /><br />
<div id="show"><?php echo $showLayer; ?></div>
<p class="mensaje"><?php echo $mensaje; ?></p>
<br /><br />
<table>
    <tr>
        <td>	
            <label for="idEtapa">Etapa:</label>
        </td>
        <td>	
            <?php echo $idEtapa;?>
        </td>
    </tr>
    <tr>
        <td colspan="2" class="cent">	
            <button type="button" id="cancelarAnexo" name="cancelarAnexo">Cancelar</button>
        </td>
        <td colspan="2" class="cent">
            <button type="button" id="guardarAnexo" name="guardarAnexo" value="proyectoEtapas_mant.php">Guardar</button>
        </td>
    </tr>
</table>