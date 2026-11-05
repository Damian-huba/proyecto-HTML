<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.html");
    exit();
}
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id              = intval($_POST['id']);
    $clave_ingresada = trim($_POST['clave_especial']);

    // 🔑 Clave especial o maestra para eliminar
    $clave_maestra = "12345"; // Puedes cambiarla por la que desees

    if ($clave_ingresada === $clave_maestra) {
        $sql = "DELETE FROM distribuccion_de_caso_del_consejo_de_proteccion WHERE iddistribuccion_de_caso_del_consejo_de_proteccion = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            header("Location: panel_funcionarios.php?eliminado=1");
        } else {
            echo "Error al eliminar el caso: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "<script>alert('Clave especial incorrecta. No se pudo eliminar el caso.'); window.location.href='panel_funcionarios.php';</script>";
    }

    $conexion->close();
    exit();
}
?>

