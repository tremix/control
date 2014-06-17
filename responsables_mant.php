<?php
require_once('config.php');
require_once(resources . 'general.php');
require_once(entities . 'responsable.php');
require_once(entities . 'usuario.php');
require_once(entities . 'alerta.php');
require_once(entities . 'proyecto.php');
$general = new general();
$responsable = new responsable();
$usuario = new usuario();
$alerta = new alerta();
$proyecto = new proyecto();

$opMantDif = "nu";
if (isset($_REQUEST['opMantDif'])) {
    $opMantDif = $_REQUEST['opMantDif'];
}

$titulo = "";

$data = array(
    'idResponsable' => NULL,
    'idProyecto' => 'NULL',
    'idUsuario' => 'NULL'
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
        if (isset($_POST['idUsuario'])) {
            if ($_POST['idProyecto'] != "NULL" and $_POST['idUsuario'] != "NULL") {
                $responsable->set($data);
                $id = $responsable->insert();
                if ($id) {
                    $data['idResponsable'] = $id;
                    $opMantDif = "ed";
                    $titulo = "EDITAR ";
                    $mensaje = "Registro creado correctamente.";


                    $usuario->get($data['idUsuario']);
                    $dataUsuario = $usuario->setArray;
                    $asunto = "Se te ha asignado un nuevo proyecto.";
                    $mensajeMail = "Eres responsable del proyecto ";
                    $mensajeMail .= '<a target="_blank" href="http://' . baseURL . 'proyectos.php?id=' . $data['idProyecto'] . '">' . $proyecto->getCodProposalByID($data['idProyecto']) . '</a>.';
                    $general->enviarMail($dataUsuario['emailUsuario'], $asunto, $mensajeMail);
                    $dataAler = array(
                        "idAlerta" => "",
                        "idUsuario" => $data['idUsuario'],
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
            $responsable->get($id);
            if (is_array($responsable->setArray)) {
                $data = $responsable->setArray;
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
        if ($_POST['idProyecto'] != "NULL" and $_POST['idUsuario'] != "NULL") {
            $responsable->get($data['idResponsable']);
            $dataAux = $responsable->setArray;
            
            $responsable->set($data);
            if ($responsable->update()) {
                $mensaje = "Registro editado correctamente.";


                if ($dataAux['idUsuario'] <> $data['idUsuario']) {
                    $usuario->get($data['idUsuario']);
                    $dataUsuario = $usuario->setArray;
                    $asunto = "Se te ha asignado un nuevo proyecto.";
                    $mensajeMail = "Eres responsable del proyecto ";
                    $mensajeMail .= '<a target="_blank" href="http://' . baseURL . 'proyectos.php?id=' . $data['idProyecto'] . '">' . $proyecto->getCodProposalByID($data['idProyecto']) . '</a>.';
                    $general->enviarMail($dataUsuario['emailUsuario'], $asunto, $mensajeMail);
                    $dataAler = array(
                        "idAlerta" => "",
                        "idUsuario" => $data['idUsuario'],
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
                $mensaje = "No se ha podido editar el registro.";
            }
        }
        break;
    case 'el':
        if (isset($_REQUEST['id'])) {
            if ($responsable->delete($_REQUEST['id'])) {
                $mensaje = "Registro eliminado correctamente.";
            } else {
                $mensaje = "No se ha podido eliminar el registro.";
            }
        }
        break;
}

$idUsuario = $general->combo($usuario->getCombo(), 'idUsuario', '', $data['idUsuario']);
?>
<input type="hidden" id="opMantDif" name="opMantDif" value="<?php echo $opMantDif; ?>" />
<input type="hidden" id="idResponsable" name="idResponsable" value="<?php echo $data['idResponsable']; ?>" />
<input type="hidden" id="idProyecto" name="idProyecto" value="<?php echo $data['idProyecto']; ?>" />
<h1>
    <?php echo $titulo; ?>RESPONSABLE DE PROYECTO
    <img src="<?php echo images; ?>icon_customer.png" <?php echo sizeImg3; ?> />
</h1>
<br /><br />
<div id="show"><?php echo $showLayer; ?></div>
<p class="mensaje"><?php echo $mensaje; ?></p>
<br /><br />
<table>
    <tr>
        <td>	
            <label for="idUsuario">Responsable:</label>
        </td>
        <td>	
            <?php echo $idUsuario; ?>
        </td>
    </tr>
    <tr>
        <td colspan="2" class="cent">	
            <button type="button" id="cancelarAnexo" name="cancelarAnexo">Cancelar</button>
        </td>
        <td colspan="2" class="cent">
            <button type="button" id="guardarAnexo" name="guardarAnexo" value="responsables_mant.php">Guardar</button>
        </td>
    </tr>
</table>