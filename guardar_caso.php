<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.html");
    exit();
}
require 'conexion.php';

// Validar que los datos vengan por POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 1. Recoger los datos del formulario (incluyendo la cédula que faltaba)
    $cedula                    = $_POST['cedula'];
    $fecha                     = $_POST['fecha'];
    $nombre_completo_del_nin_o = $_POST['nombre_completo_del_nin_o'];
    $edad                      = $_POST['edad'];
    $derecho_violentado        = $_POST['derecho_violentado'];
    $estatud                   = $_POST['estatud'];

    // 2. Preparar la consulta SQL de inserción (Asegúrate de que los nombres de las columnas 
    // coincidan exactamente con los de tu base de datos MySQL)
    $sql = "INSERT INTO distribuccion_de_caso_del_consejo_de_proteccion 
            (cedula, fecha, nombre_completo_del_nin_o, edad, derecho_violentado, estatud) 
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conexion->prepare($sql);
    
    // Si usas tipos de datos: s = string, i = integer
    // Ejemplo: cedula (string), fecha (string), nombre (string), edad (int), derecho (string), estatud (string)
    $stmt->bind_param("sssiss", $cedula, $fecha, $nombre_completo_del_nin_o, $edad, $derecho_violentado, $estatud);

    if ($stmt->execute()) {
        // Redirigir de vuelta al panel con éxito
        header("Location: panel.php?exito=1");
        exit();
    } else {
        echo "Error al guardar el caso: " . $stmt->error;
    }

    $stmt->close();
    $conexion->close();
}
?>
