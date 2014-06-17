<?php
require_once('config.php');
require_once(resources . 'general.php');
require_once(entities . 'control.php');
require_once(entities . 'cliente.php');
require_once(entities . 'proyecto.php');
require_once(entities . 'proyectoEtapa.php');
require_once(entities . 'actividad.php');
require_once(entities . 'valorHora.php');
$general = new general();
$control = new control();
$cliente = new cliente();
$proyecto = new proyecto();
$proyectoEtapa = new proyectoEtapa();
$actividad = new actividad();
$valorHora = new valorHora();

$opMant = "nu";
if (isset($_REQUEST['opMant'])) {
    $opMant = $_REQUEST['opMant'];
}

$titulo = "";

$data = array(
    'idControl' => NULL,
    'idProyecto' => 'NULL',
    'idActividad' => 'NULL',
    'idUsuario' => $_SESSION['usuario']['id'],
    'horasImputadasControl' => 0,
    'situacionControl' => 'T',
    'observacionesControl' => '',
    'esReprocesoControl' => 0,
    'porClienteControl' => 0,
    'fechaControl' => date('Y-m-d'),
    'actualCostoHoraConsultorControl' => $valorHora->getPriceByUserId($_SESSION['usuario']['id']),
    'fechaCreacion' => NULL
);

foreach ($data as $key => $value) {
    if (isset($_REQUEST[$key])) {
        $data[$key] = $_REQUEST[$key];
    }
}

$mensaje = "";

switch ($opMant) {
    case 'nu':
        $titulo = "CREAR ";
        if (isset($_POST['idActividad'])) {
            if ($_POST['idProyecto'] != "NULL" and $_POST['idActividad'] != "NULL" and $_POST['horasImputadasControl'] != "" and $_POST['situacionControl'] != "NULL" and $_POST['fechaControl'] != "") {
                $control->set($data);
                $id = $control->insert();
                if ($id) {
                    $mensaje = "Registro creado correctamente.";

                    $data = array(
                        'idControl' => NULL,
                        'idProyecto' => 'NULL',
                        'idActividad' => 'NULL',
                        'idUsuario' => $_SESSION['usuario']['id'],
                        'horasImputadasControl' => 0,
                        'situacionControl' => 'T',
                        'observacionesControl' => '',
                        'esReprocesoControl' => 0,
                        'porClienteControl' => 0,
                        'fechaControl' => NULL,
                        'actualCostoHoraConsultorControl' => $valorHora->getPriceByUserId($_SESSION['usuario']['id']),
                        'fechaCreacion' => NULL
                    );
                } else {
                    $mensaje = "No se pudo realizar el registro.";
                }
            } else {
                $mensaje = "Debe llenar todos los datos correctamente.";
            }
        }
        break;

    case 'li':
        break;
    case 'ed':
        break;
    case 'el':
        break;
}

$situacion = array();
$situacion[] = array('id' => 'P', 'nombre' => 'Pendiente');
$situacion[] = array('id' => 'T', 'nombre' => 'Terminado');

$idCliente = (isset($_REQUEST['idCliente'])) ? $_REQUEST['idCliente'] : 0;
$idEtapa = (isset($_REQUEST['idEtapa'])) ? $_REQUEST['idEtapa'] : 0;

$comboCliente = $general->combo($cliente->getCombo(), 'idCliente', '');
$comboProyecto = $general->combo($proyecto->getComboComplete($idCliente), 'idProyecto', '', $data['idProyecto']);
$comboEtapa = $general->combo($proyectoEtapa->getCombo($data['idProyecto']), 'idEtapa', '');
$idActividad = $general->combo($actividad->getCombo($idEtapa), 'idActividad', '', $data['idActividad']);
$situacionControl = $general->combo($situacion, 'situacionControl', '', $data['situacionControl']);
?>
<form id="formControlMant" name="formControlMant" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <input type="hidden" id="opMant" name="opMant" value="<?php echo $opMant; ?>" />
    <input type="hidden" id="idControl" name="idControl" value="<?php echo $data['idControl']; ?>" />
    <h1>
        <?php echo $titulo; ?>CONTROL DE PROYECTO
        <img src="<?php echo images; ?>icon_trace.png" <?php echo sizeImg3; ?> />
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
                <?php echo $comboCliente; ?>
            </td>
            <td>	
                <label for="idProyecto">Proyecto:</label>
            </td>
            <td>	
                <?php echo $comboProyecto; ?>
            </td>
        </tr>	
        <tr>
            <td>	
                <label for="idEtapa">Etapa:</label>
            </td>
            <td>	
                <?php echo $comboEtapa; ?>
            </td>
            <td>	
                <label for="idActividad">Actividad:</label>
            </td>
            <td>	
                <?php echo $idActividad; ?>
            </td>
        </tr>
        <tr>
            <td>	
                <label for="horasImputadasControl">Horas imputadas:</label>
            </td>
            <td>	
                <input type="text" id="horasImputadasControl" name="horasImputadasControl" size="2" value="<?php echo $data['horasImputadasControl']; ?>" />
            </td>
            <td>	
                <label for="situacionControl">Situaci&oacute;n:</label>
            </td>
            <td>	
                <?php echo $situacionControl; ?>
            </td>
        </tr>
        <tr>
            <td>	
                <label for="observacionesControl">Observaciones:</label>
            </td>
            <td colspan="3">	
                <textarea id="observacionesControl" name="observacionesControl" cols="60" rows="5"><?php echo $data['observacionesControl']; ?></textarea>
            </td>
        </tr>
        <tr>
            <td>	
                <label for="esReprocesoControl">Es reproceso:</label>
            </td>
            <td>
                <input type="checkbox" id="esReprocesoControl" name="esReprocesoControl" value="1" />
            </td>
            <td>	
                <label for="porClienteControl">A pedido del cliente:</label>
            </td>
            <td>
                <input type="checkbox" id="porClienteControl" name="porClienteControl" value="1" />
            </td>
        </tr>
        <tr>
            <td>	
                <label for="fechaControl">Fecha:</label>
            </td>
            <td>	
                <input type="text" id="fechaControl" name="fechaControl" size="10" value="<?php echo $data['fechaControl']; ?>" />
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