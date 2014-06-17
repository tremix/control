<?php
require_once('config.php');
require_once(resources . 'general.php');
require_once(entities . 'adicionalProyecto.php');
require_once(entities . 'cliente.php');
require_once(entities . 'proyecto.php');
require_once(entities . 'adicional.php');
$general = new general();
$adicionalProyecto = new adicionalProyecto();
$cliente = new cliente();
$proyecto = new proyecto();
$adicional = new adicional();

$opMant = "nu";
if (isset($_REQUEST['opMant'])) {
    $opMant = $_REQUEST['opMant'];
}

$titulo = "";

$data = array(
    'idAdicionalProyecto' => NULL,
    'idProyecto' => 'NULL',
    'idAdicional' => 'NULL',
    'idUsuario' => $_SESSION['usuario']['id'],
    'costoAdicionalProyecto' => 0,
    'comentarioAdicionalProyecto' => '',
    'fechaAdicionalProyecto' => date('Y-m-d'),
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
        if (isset($_POST['idAdicional'])) {
            if ($_POST['idProyecto'] != "NULL" and $_POST['idAdicional'] != "NULL" and $_POST['costoAdicionalProyecto'] != "" and $_POST['fechaAdicionalProyecto'] != "") {
                $adicionalProyecto->set($data);
                $id = $adicionalProyecto->insert();
                if ($id) {
                    $mensaje = "Registro creado correctamente.";

                    $data = array(
                        'idAdicionalProyecto' => NULL,
                        'idProyecto' => 'NULL',
                        'idAdicional' => 'NULL',
                        'idUsuario' => $_SESSION['usuario']['id'],
                        'costoAdicionalProyecto' => 0,
                        'comentarioAdicionalProyecto' => '',
                        'fechaAdicionalProyecto' => date('Y-m-d'),
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

$idCliente = (isset($_REQUEST['idCliente'])) ? $_REQUEST['idCliente'] : 0;

$comboCliente = $general->combo($cliente->getCombo(), 'idCliente', '');
$idProyecto = $general->combo($proyecto->getComboComplete($idCliente), 'idProyecto', '', $data['idProyecto']);
$idAdicional = $general->combo($adicional->getCombo(), 'idAdicional', '', $data['idAdicional']);
?>
<form id="formControlMant" name="formControlMant" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <input type="hidden" id="opMant" name="opMant" value="<?php echo $opMant; ?>" />
    <input type="hidden" id="idAdicionalProyecto" name="idAdicionalProyecto" value="<?php echo $data['idAdicionalProyecto']; ?>" />
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
                <?php echo $idProyecto; ?>
            </td>
        </tr>
        <tr>
            <td>	
                <label for="idAdicional">Adicional:</label>
            </td>
            <td>	
                <?php echo $idAdicional; ?>
            </td>
            <td>	
                <label for="costoAdicionalProyecto">Costo:</label>
            </td>
            <td>	
                S/.<input type="text" id="costoAdicionalProyecto" name="costoAdicionalProyecto" size="5" value="<?php echo $data['costoAdicionalProyecto']; ?>" />
            </td>
        </tr>
        <tr>
            <td>	
                <label for="comentarioAdicionalProyecto">Comentario:</label>
            </td>
            <td colspan="3">	
                <textarea id="comentarioAdicionalProyecto" name="comentarioAdicionalProyecto" cols="60" rows="5"><?php echo $data['comentarioAdicionalProyecto']; ?></textarea>
            </td>
        </tr>
        <tr>
            
            <td>	
                <label for="fechaAdicionalProyecto">Fecha:</label>
            </td>
            <td>	
                <input type="text" id="fechaAdicionalProyecto" name="fechaAdicionalProyecto" size="10" value="<?php echo $data['fechaAdicionalProyecto']; ?>" />
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
</form>