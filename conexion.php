<?php
$host = "127.0.0.1";
$user = "root";
$password = "";
$database = "comdepro_db";
$port = 3306;

// Conexión pasando los parámetros por nombre para evitar errores de posición en PHP 8
$conexion = new mysqli(
    hostname: $host,
    username: $user,
    password: $password,
    database: $database,
    port: $port
);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$conexion->set_charset("utf8mb4");
?>