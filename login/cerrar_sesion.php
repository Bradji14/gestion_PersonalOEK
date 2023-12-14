<?php
session_start();
// include_once "../bd/conexion.php";

session_destroy();
// session_set_cookie_params(60*60*24);
clearstatcache();
header("Location: http://192.168.100.200:50/asistencias_empleados/");
// exit();
