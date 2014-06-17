<?php
ob_start();
require_once('config.php');
require_once(resources . 'pagina.php');
$pagina = new pagina();
$pagina->comprobar();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="shortcut icon" href="<?php echo images; ?>favicon.ico">
            <link href="<?php echo css; ?>main.css" type="text/css" rel="stylesheet" />
            <link href="<?php echo css; ?>jquery-ui.css" type="text/css" rel="stylesheet" />
            <script src="<?php echo scripts; ?>jquery.js" language="javascript" type="text/javascript"></script>
            <script src="<?php echo scripts; ?>jquery-ui.js" language="javascript" type="text/javascript"></script>
            <script src="<?php echo scripts; ?>jquery-ui-timepicker.js" language="javascript" type="text/javascript"></script>
            <script src="<?php echo scripts; ?>clock.js" language="javascript" type="text/javascript"></script>
            <script src="<?php echo scripts; ?>general.js" language="javascript" type="text/javascript"></script>
            <title>Intranet DHO Consultores</title>
            <base href="http://<?php echo baseURL; ?>" />
    </head>

    <body>
        <div id="cuerpo">
            <div id="contenido">
                <br /><br />
                <?php echo $pagina->menu();?>
                <br />	