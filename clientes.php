<?php
require_once('config.php');
require_once(templates . 'header.php');
require_once(entities . 'cliente.php');
require_once(resources . 'general.php');
$cliente = new cliente();
$general = new general();

$mensaje = "";
?>
<form id="formGrilla" name="formGrilla" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <script src="<?php echo scripts; ?>clientes.js" language="javascript" type="text/javascript"></script>
    <h1>
        CLIENTES
        <img src="<?php echo images; ?>icon_customer.png" <?php echo sizeImg3; ?> />
    </h1>
    <br /><br />
    <a href="clientes_mant.php" id="nuevo" name="nuevo">
        <img src="<?php echo images; ?>icon_add.png" <?php echo sizeImg; ?> />
        Nuevo Cliente
    </a>
    - 
    <a href="#" id="reporte" name="reporte.php?op=cliGen&txtBuscar=">
        <img src="<?php echo images; ?>icon_excel.png" <?php echo sizeImg; ?> />
        Exportar en Excel
    </a>
    <br /><br />
    <label for="txtBuscar">Buscar:</label>
    <input type="text" id="txtBuscar" name="txtBuscar" size="100" />
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

    $cliente->numRows($buscar);

    $paginacion = array("totalPag" => $cliente->numRows, "actualPag" => 0, "cantPag" => 50, "colPag" => "", "ascPag" => 1);
    foreach ($paginacion as $key => $value) {
        if (isset($_REQUEST[$key])) {
            $paginacion[$key] = $_REQUEST[$key];
        }
    }

    $paginacion["totalPag"] = $cliente->numRows;

    echo $general->grilla($cliente->show($buscar, $paginacion), 'Lista de Clientes', 'icon_customer.png', 'clientes_mant.php', true, false, true, $paginacion);
    ?>
</form>
<p class="loading"></p>
<?php
require_once(templates . 'footer.php');
?>