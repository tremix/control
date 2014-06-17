<?php
require_once('config.php');
require_once(resources . 'general.php');
require_once(entities . 'adicional.php');
$general = new general();
$adicional = new adicional();

$opMant = "nu";
if (isset($_REQUEST['opMant'])) {
    $opMant = $_REQUEST['opMant'];
}

$titulo = "";

$data = array(
    'idAdicional' => NULL,
    'nombreAdicional' => ''
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
        if (isset($_POST['nombreAdicional'])) {
            if ($_POST['nombreAdicional'] != "") {
                $adicional->set($data);
                $id = $adicional->insert();
                if ($id) {
                    $data['idAdicional'] = $id;
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
            $adicional->get($id);
            if (is_array($adicional->setArray)) {
                $data = $adicional->setArray;
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
        if (isset($_POST['nombreAdicional'])) {
            if ($_POST['nombreAdicional'] != "") {
                $adicional->set($data);
                if ($adicional->update()) {
                    $mensaje = "Registro editado correctamente.";
                } else {
                    $mensaje = "No se ha podido editar el registro.";
                }
            }
        }
        break;
    case 'el':
        if (isset($_REQUEST['id'])) {
            if ($adicional->delete($_REQUEST['id'])) {
                $mensaje = "Registro eliminado correctamente.";
            } else {
                $mensaje = "No se ha podido eliminar el registro.";
            }
        }
        break;
}

?>
<form id="formAdicionalesMant" name="formAdicionalesMant" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <input type="hidden" id="opMant" name="opMant" value="<?php echo $opMant; ?>" />
    <input type="hidden" id="idAdicional" name="idAdicional" value="<?php echo $data['idAdicional']; ?>" />
    <h1>
<?php echo $titulo; ?>ADICIONAL DE PROYECTO
        <img src="<?php echo images; ?>icon_extra.png" <?php echo sizeImg3; ?> />
    </h1>
    <br /><br />
    <p class="mensaje"><?php echo $mensaje; ?></p>
    <br /><br />
    <table>
        <tr>
            <td>	
                <label for="nombreAdicional">Nombre:</label>
            </td>
            <td colspan="3">	
                <input type="text" id="nombreAdicional" name="nombreAdicional" size="60" value="<?php echo $data['nombreAdicional']; ?>" />
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