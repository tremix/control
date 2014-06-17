<?php
require_once('config.php');
require_once(templates . 'header.php');
require_once(entities . 'proyecto.php');
require_once(resources . 'general.php');
$proyecto = new proyecto();
$general = new general();

$id = "";
if (isset($_REQUEST['id'])) {
    $id = $_REQUEST['id'];
}

$mensaje = "";
?>
<form id="formGrilla" name="formGrilla" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <script src="<?php echo scripts; ?>proyectos.js" language="javascript" type="text/javascript"></script>
    <input type="hidden" id="linkHidden" name="linkHidden" value="<?php echo $id; ?>" />
    <h1>
        PROYECTOS
        <img src="<?php echo images; ?>icon_project.png" <?php echo sizeImg3; ?> />
    </h1>
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

    $proyecto->numRows($buscar);

    $paginacion = array("totalPag" => $proyecto->numRows, "actualPag" => 0, "cantPag" => 50, "colPag" => "", "ascPag" => 1);
    foreach ($paginacion as $key => $value) {
        if (isset($_REQUEST[$key])) {
            $paginacion[$key] = $_REQUEST[$key];
        }
    }

    $paginacion["totalPag"] = $proyecto->numRows;

    echo $general->grilla($proyecto->show($buscar, $paginacion), 'Lista de Proyectos', 'icon_project.png', 'proyectos_mant.php', true, false, true, $paginacion);
    ?>
</form>
<p class="loading"></p>
<?php
require_once(templates . 'footer.php');
?>