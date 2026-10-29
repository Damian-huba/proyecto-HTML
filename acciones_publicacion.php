<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.html");
    exit();
}
require 'conexion.php';

$accion = $_REQUEST['accion'] ?? '';

// ELIMINAR PUBLICACIÓN
if ($accion === 'eliminar') {
    $id = intval($_GET['id'] ?? 0);
    
    // Obtener imagen para borrarla del disco
    $sql_img = "SELECT imagen FROM publicacion WHERE id = ?";
    $stmt_img = $conexion->prepare($sql_img);
    $stmt_img->bind_param("i", $id);
    $stmt_img->execute();
    $res_img = $stmt_img->get_result()->fetch_assoc();

    if (!empty($res_img['imagen']) && file_exists($res_img['imagen'])) {
        unlink($res_img['imagen']);
    }

    $sql_del = "DELETE FROM publicacion WHERE id = ?";
    $stmt_del = $conexion->prepare($sql_del);
    $stmt_del->bind_param("i", $id);
    $stmt_del->execute();

    header("Location: index.php#publicaciones");
    exit();
}

// EDITAR PUBLICACIÓN
if ($accion === 'editar' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id        = intval($_POST['id'] ?? 0);
    $contenido = trim($_POST['contenido'] ?? '');

    if (!empty($contenido)) {
        $sql_upd = "UPDATE publicacion SET contenido = ? WHERE id = ?";
        $stmt_upd = $conexion->prepare($sql_upd);
        $stmt_upd->bind_param("si", $contenido, $id);
        $stmt_upd->execute();
    }

    header("Location: index.php#publicaciones");
    exit();
}
?>