<?php
// Datos de conexión para InfinityFree
$host = "sql105.infinityfree.com";
$usuario = "if0_43322229";
$password = "ddrg310500";
$database = "if0_43322229_comdepro_db";

$conexion = new mysqli($host, $usuario, $password, $database);

// Asegurar codificación UTF-8 para que las tildes y eñes se guarden bien
$conexion->set_charset("utf8");

if ($conexion->connect_error) {
    die("Error de conexión a la base de datos: " . $conexion->connect_error);
}
?>
