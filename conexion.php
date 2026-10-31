<?php
// Datos de conexión para InfinityFree
$host = "sql105.infinityfree.com"; // Cambia "sqlXXX" por el Hostname exacto que te da InfinityFree en su panel
$usuario = "if0_43322229";        // Tu nombre de usuario de la cuenta
$password = "ddrg310500"; // La contraseña con la que inicias sesión en InfinityFree
$database = "if0_43322229_comdepro_db"; // El nombre completo de tu base de datos (ej: si le pusiste sistema, será if0_43322229_sistema)

$conexion = new mysqli($host, $usuario, $password, $database);

// Asegurar codificación UTF-8 para que las tildes y eñes se guarden bien
$conexion->set_charset("utf8");

if ($conexion->connect_error) {
    die("Error de conexión a la base de datos: " . $conexion->connect_error);
}
?>
