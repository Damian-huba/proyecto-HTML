<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.html");
    exit();
}
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id      = intval($_POST['id']);
    $fecha   = $_POST['fecha'];
    $nombre  = trim($_POST['nombre_completo_del_nin_o']);
    $edad    = intval($_POST['edad']);
    $derecho = trim($_POST['derecho_violentado']);
    $estatud = $_POST['estatud'];

    // Consulta SQL para actualizar los datos del caso
    $sql = "UPDATE distribuccion_de_caso_del_consejo_de_proteccion 
            SET fecha = ?, nombre_completo_del_nin_o = ?, edad = ?, derecho_violentado = ?, estatud = ? 
            WHERE iddistribuccion_de_caso_del_consejo_de_proteccion = ?";
            
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssissi", $fecha, $nombre, $edad, $derecho, $estatud, $id);
    
    if ($stmt->execute()) {
        header("Location: panel_funcionarios.php?exito=actualizado");
    } else {
        echo "Error al actualizar el caso: " . $stmt->error;
    }

    $stmt->close();
    $conexion->close();
    exit();
}
?>
