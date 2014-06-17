<?php
define('server', 'localhost');
define('db', 'dhocompe_intranet');
//define('user', 'dhocompe');
//define('pass', '_-C0nSu1t0r32-D40_2013_@Dm1NdH02o1l_2013');
define('user', 'root');
define('pass', '');
define('images', 'img/');
define('resources', 'resources/');
define('entities', 'entities/');
define('scripts', 'js/');
define('css', 'css/');
define('templates', 'templates/');
define('sizeImg', ' height="24" width="24" ');
define('sizeImg2', ' height="72" width="72" ');
define('sizeImg3', ' height="36" width="36" ');
define('sizeImg4', ' height="100" width="100" ');
define('disabled', 'disabled="true"');
define('preURL', '/control/');
define('baseURL', 'localhost'.preURL);

session_start();
require_once(resources.'conexion.php');
$conexion = new conexion();
$conexion->conectarDB();
?>