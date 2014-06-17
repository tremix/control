<?php
require_once('config.php');
require_once(resources . 'general.php');
require_once(entities . 'proyectoActividad.php');
require_once(entities . 'proyectoEtapa.php');
require_once(entities . 'actividad.php');
$general = new general();
$proyectoActividad = new proyectoActividad();
$proyectoEtapa = new proyectoEtapa();
$actividad = new actividad();

$opMantDif = "nu";
if (isset($_REQUEST['opMantDif'])) {
    $opMantDif = $_REQUEST['opMantDif'];
}

$titulo = "";

$data = array(
    'idProyectoActividad' => NULL,
    'idProyecto' => 'NULL',
    'idActividad' => 'NULL',
    'fechaInicioProyectoActividad' => '',
    'fechaFinalProyectoActividad' => '',
    'horasAsignadasProyectoActividad' => ''
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
        if (isset($_POST['idActividad'])) {
            if ($_POST['idProyecto'] != "NULL" and $_POST['idActividad'] != "NULL" and $_POST['fechaInicioProyectoActividad'] != "" and $_POST['fechaFinalProyectoActividad'] != "" and $_POST['horasAsignadasProyectoActividad'] != "") {
                $proyectoActividad->set($data);
                $id = $proyectoActividad->insert();
                if ($id) {
                    $data['idProyectoActividad'] = $id;
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
            $proyectoActividad->get($id);
            if (is_array($proyectoActividad->setArray)) {
                $data = $proyectoActividad->setArray;
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
            $proyectoActividad->set($data);
            if ($proyectoActividad->update()) {
                $mensaje = "Registro editado correctamente.";
            } else {
                $mensaje = "No se ha podido editar el registro.";
            }
        }
        break;
    case 'el':
        if (isset($_REQUEST['id'])) {
            if ($proyectoActividad->delete($_REQUEST['id'])) {
                $mensaje = "Registro eliminado correctamente.";
            } else {
                $mensaje = "No se ha podido eliminar el registro.";
            }
        }
        break;
}

$idEtapa = "NULL";
if(isset($_REQUEST['idActividad'])){
    $dataActividad = $actividad->get($data['idActividad']);
    $idEtapa = (is_array($dataActividad))? $dataActividad['idEtapa'] : "";
}else if(isset($_REQUEST['idEtapaAux'])){
    $idEtapa = $_REQUEST['idEtapaAux'];
}
        
$comboEtapa = $general->combo($proyectoEtapa->getCombo($data['idProyecto']), 'idEtapaAux', '', $idEtapa);
$idActividad = $general->combo($actividad->getCombo($idEtapa), 'idActividad', '', $data['idActividad']);
        
?>
<input type="hidden" id="opMantDif" name="opMantDif" value="<?php echo $opMantDif; ?>" />
<input type="hidden" id="idProyectoActividad" name="idProyectoActividad" value="<?php echo $data['idProyectoActividad']; ?>" />
<input type="hidden" id="idProyecto" name="idProyecto" value="<?php echo $data['idProyecto']; ?>" />
<h1>
    <?php echo $titulo; ?>ACTIVIDAD DE PROYECTO
    <img src="<?php echo images; ?>icon_annex.png" <?php echo sizeImg3; ?> />
</h1>
<br /><br />
<div id="show"><?php echo $showLayer; ?></div>
<p class="mensaje"><?php echo $mensaje; ?></p>
<br /><br />
<table>
    <tr>
        <td>	
            <label for="idEtapaAux">Etapa:</label>
        </td>
        <td>	
            <?php echo $comboEtapa;?>
        </td>
    </tr>
    <tr>
        <td>	
            <label for="idActividad">Actividad:</label>
        </td>
        <td>	
            <?php echo $idActividad;?>
        </td>
    </tr>
    <tr>
        <td>	
            <label for="fechaInicioProyectoActividad">Fecha inicial:</label>
        </td>
        <td>	
            <input type="text" id="fechaInicioProyectoActividad" name="fechaInicioProyectoActividad" size="10" value="<?php echo $data['fechaInicioProyectoActividad']; ?>" />
        </td>
    </tr>
    <tr>
        <td>	
            <label for="fechaFinalProyectoActividad">Fecha final:</label>
        </td>
        <td>	
            <input type="text" id="fechaFinalProyectoActividad" name="fechaFinalProyectoActividad" size="10" value="<?php echo $data['fechaFinalProyectoActividad']; ?>" />
        </td>
    </tr>
    <tr>
        <td>	
            <label for="horasAsignadasProyectoActividad">Horas asignadas:</label>
        </td>
        <td>	
            <input type="text" id="horasAsignadasProyectoActividad" name="horasAsignadasProyectoActividad" size="6" value="<?php echo $data['horasAsignadasProyectoActividad']; ?>" />
        </td>
    </tr>
    <tr>
        <td colspan="2" class="cent">	
            <button type="button" id="cancelarAnexo" name="cancelarAnexo">Cancelar</button>
        </td>
        <td colspan="2" class="cent">
            <button type="button" id="guardarAnexo" name="guardarAnexo" value="proyectoActividades_mant.php">Guardar</button>
        </td>
    </tr>
</table>