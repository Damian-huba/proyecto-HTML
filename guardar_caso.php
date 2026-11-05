<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.html");
    exit();
}
require 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fecha = $_POST['cedula'];
    $fecha = $_POST['fecha'];
    $nombre = $_POST['nombre_completo_del_nin_o'];
    $edad = $_POST['edad'];
    $derecho = $_POST['derecho_violentado'];
    $estatus = $_POST['estatud'];

    $sql = "INSERT INTO distribuccion_de_caso_del_consejo_de_proteccion (cedula,fecha, nombre_completo_del_nin_o, edad, derecho_violentado, estatud) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssiss", $fecha, $nombre, $edad, $derecho, $estatus);

    if ($stmt->execute()) {
        header("Location: panel_funcionarios.php");
    } else {
        echo "Error al registrar el caso: " . $conexion->error;
    }
}
?>
