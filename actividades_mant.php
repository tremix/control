<?php
require_once('config.php');
require_once(resources . 'general.php');
require_once(entities . 'actividad.php');
$general = new general();
$actividad = new actividad();

$opMantDif = "nu";
if (isset($_REQUEST['opMantDif'])) {
    $opMantDif = $_REQUEST['opMantDif'];
}

$titulo = "";

$data = array(
    'idActividad' => NULL,
    'idEtapa' => 'NULL',
    'nombreActividad' => ''
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
        if (isset($_POST['nombreActividad'])) {
            if ($_POST['idEtapa'] != "NULL" and $_POST['nombreActividad'] != "") {
                $actividad->set($data);
                $id = $actividad->insert();
                if ($id) {
                    $data['idActividad'] = $id;
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
            $actividad->get($id);
            if (is_array($actividad->setArray)) {
                $data = $actividad->setArray;
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
        if ($_POST['idActividad'] <> '') {
            $actividad->set($data);
            if ($actividad->update()) {
                $mensaje = "Registro editado correctamente.";
            } else {
                $mensaje = "No se ha podido editar el registro.";
            }
        }
        break;
    case 'el':
        if (isset($_REQUEST['id'])) {
            if ($actividad->delete($_REQUEST['id'])) {
                $mensaje = "Registro eliminado correctamente.";
            } else {
                $mensaje = "No se ha podido eliminar el registro.";
            }
        }
        break;
}
?>
<input type="hidden" id="opMantDif" name="opMantDif" value="<?php echo $opMantDif; ?>" />
<input type="hidden" id="idActividad" name="idActividad" value="<?php echo $data['idActividad']; ?>" />
<input type="hidden" id="idEtapa" name="idEtapa" value="<?php echo $data['idEtapa']; ?>" />
<h1>
    <?php echo $titulo; ?>ACTIVIDAD
    <img src="<?php echo images; ?>icon_annex.png" <?php echo sizeImg3; ?> />
</h1>
<br /><br />
<div id="show"><?php echo $showLayer; ?></div>
<p class="mensaje"><?php echo $mensaje; ?></p>
<br /><br />
<table>
    <tr>
        <td>	
            <label for="nombreActividad">Nombre:</label>
        </td>
        <td>	
            <input type="text" id="nombreActividad" name="nombreActividad" size="60" value="<?php echo $data['nombreActividad']; ?>" />
        </td>
    </tr>
    <tr>
        <td colspan="2" class="cent">	
            <button type="button" id="cancelarAnexo" name="cancelarAnexo">Cancelar</button>
        </td>
        <td colspan="2" class="cent">
            <button type="button" id="guardarAnexo" name="guardarAnexo" value="actividades_mant.php">Guardar</button>
        </td>
    </tr>
</table>