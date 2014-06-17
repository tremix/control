<?php
require_once('config.php');
require_once(resources . 'general.php');
require_once(entities . 'valorHora.php');
require_once(entities . 'usuario.php');
$general = new general();
$valorHora = new valorHora();
$usuario = new usuario();

$opMant = "nu";
if (isset($_REQUEST['opMant'])) {
    $opMant = $_REQUEST['opMant'];
}

$titulo = "";

$data = array(
    'idValorHora' => NULL,
    'idUsuario' => 'NULL',
    'cantidadValorHora' => ''
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
        if (isset($_POST['idUsuario'])) {
            if ($_POST['idUsuario'] != "NULL" and $_POST['cantidadValorHora'] != "") {
                $id = $valorHora->getIdByUserId($data['idUsuario']);
                $data['idValorHora'] = $id;
                
                $valorHora->set($data);
                
                if ($id) {
                    $valorHora->update();
                } else {
                    $id = $valorHora->insert();
                }

                if ($id) {
                    $data['idValorHora'] = $id;
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
            $valorHora->get($id);
            if (is_array($valorHora->setArray)) {
                $data = $valorHora->setArray;
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
        if (isset($_POST['idUsuario'])) {
            if ($_POST['idUsuario'] != "NULL" and $_POST['cantidadValorHora'] != "") {
                $valorHora->set($data);
                if ($valorHora->update()) {
                    $mensaje = "Registro editado correctamente.";
                } else {
                    $mensaje = "No se ha podido editar el registro.";
                }
            }
        }
        break;
    case 'el':
        if (isset($_REQUEST['id'])) {
            if ($valorHora->delete($_REQUEST['id'])) {
                $mensaje = "Registro eliminado correctamente.";
            } else {
                $mensaje = "No se ha podido eliminar el registro.";
            }
        }
        break;
}

$idUsuario = $general->combo($usuario->getCombo(), 'idUsuario', '', $data['idUsuario']);
?>
<form id="formValorHoraMant" name="formValorHoraMant" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <input type="hidden" id="opMant" name="opMant" value="<?php echo $opMant; ?>" />
    <input type="hidden" id="idValorHora" name="idValorHora" value="<?php echo $data['idValorHora']; ?>" />
    <h1>
        <?php echo $titulo; ?>VALOR HORA-HOMBRE
        <img src="<?php echo images; ?>icon_money.png" <?php echo sizeImg3; ?> />
    </h1>
    <br /><br />
    <p class="mensaje"><?php echo $mensaje; ?></p>
    <br /><br />
    <table>
        <tr>
            <td>	
                <label for="idUsuario">Consultor:</label>
            </td>
            <td>	
                <?php echo $idUsuario; ?>
            </td>
            <td>	
                <label for="cantidadValorHora">Valor:</label>
            </td>
            <td>	
                <input type="text" id="cantidadValorHora" name="cantidadValorHora" size="4" value="<?php echo $data['cantidadValorHora']; ?>" /> Nuevo Sol / hora
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