<?php
require_once('config.php');
require_once(templates . 'header.php');
require_once(entities . 'control.php');
require_once(resources . 'general.php');
$control = new control();
$general = new general();

$id = "";
if (isset($_REQUEST['id'])) {
    $id = $_REQUEST['id'];
}

$mensaje = "";
?>
<form id="formGrilla" name="formGrilla" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <script src="<?php echo scripts; ?>control.js" language="javascript" type="text/javascript"></script>
    <h1>
        CONTROL DE PROYECTOS
        <img src="<?php echo images; ?>icon_trace.png" <?php echo sizeImg3; ?> />
    </h1>
    <br /><br />
    <a href="control_mant.php" id="nuevo" name="nuevo">
        <img src="<?php echo images; ?>icon_add.png" <?php echo sizeImg; ?> />
        Nueva actividad realizada
    </a>
    <br /><br />
    <label for="txtBuscar">Buscar:</label>
    <input type="text" id="txtBuscar" name="txtBuscar" size="100"  />
    <button type="button" id="buscarGrilla" name="buscarGrilla">
        <img src="<?php echo images; ?>icon_find.png" />
        BUSCAR
    </button>
    <br />
    <center><p class="mensaje"><?php echo $mensaje; ?></p></center>
    <br />
    <?php
    $buscar = "";
    if (isset($_REQUEST['txtBuscar'])) {
        $buscar = $_REQUEST['txtBuscar'];
    }

    $control->numRows($buscar, $_SESSION['usuario']['id']);

    $paginacion = array("totalPag" => $control->numRows, "actualPag" => 0, "cantPag" => 50, "colPag" => "", "ascPag" => 1);
    foreach ($paginacion as $key => $value) {
        if (isset($_REQUEST[$key])) {
            $paginacion[$key] = $_REQUEST[$key];
        }
    }

    $paginacion["totalPag"] = $control->numRows;

    echo $general->grilla($control->show($buscar, $paginacion), 'Lista de actividades realizadas', 'icon_trace.png', '', true, false, true, $paginacion);
    ?>
</form>
<p class="loading"></p>
<?php
require_once(templates . 'footer.php');
?>