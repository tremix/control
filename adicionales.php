<?php
require_once('config.php');
require_once(templates . 'header.php');
require_once(entities . 'adicional.php');
require_once(resources . 'general.php');
$adicional = new adicional();
$general = new general();

$id = "";
if (isset($_REQUEST['id'])) {
    $id = $_REQUEST['id'];
}

$mensaje = "";
?>
<form id="formGrilla" name="formGrilla" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <h1>
        ADICIONALES DE PROYECTOS
        <img src="<?php echo images; ?>icon_extra.png" <?php echo sizeImg3; ?> />
    </h1>
    <br /><br />
    <a href="adicionales_mant.php" id="nuevo" name="nuevo">
        <img src="<?php echo images; ?>icon_add.png" <?php echo sizeImg; ?> />
        Nuevo adicional
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

    $adicional->numRows($buscar);

    $paginacion = array("totalPag" => $adicional->numRows, "actualPag" => 0, "cantPag" => 50, "colPag" => "", "ascPag" => 1);
    foreach ($paginacion as $key => $value) {
        if (isset($_REQUEST[$key])) {
            $paginacion[$key] = $_REQUEST[$key];
        }
    }

    $paginacion["totalPag"] = $adicional->numRows;

    echo $general->grilla($adicional->show($buscar, $paginacion), 'Lista de adicionales de proyectos', 'icon_extra.png', 'adicionales_mant.php', true, false, true, $paginacion);
    ?>
</form>
<p class="loading"></p>
<?php
require_once(templates . 'footer.php');
?>