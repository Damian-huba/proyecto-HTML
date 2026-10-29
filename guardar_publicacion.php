<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.html");
    exit();
}
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario   = $_SESSION['usuario'];
    $contenido = trim($_POST['contenido'] ?? '');
    $ruta_foto = null;

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $nombre_tmp = $_FILES['imagen']['tmp_name'];
        $ext = strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));
        $ext_permitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (in_array($ext, $ext_permitidas)) {
            $nuevo_nombre = time() . '_' . uniqid() . '.' . $ext;
            $destino = 'uploads/' . $nuevo_nombre;
            if (move_uploaded_file($nombre_tmp, $destino)) {
                $ruta_foto = $destino;
            }
        }
    }

    if (!empty($contenido) || $ruta_foto !== null) {
        $sql = "INSERT INTO publicacion (usuario, contenido, imagen) VALUES (?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("sss", $usuario, $contenido, $ruta_foto);
        $stmt->execute();
    }

    header("Location: index.php#publicaciones");
    exit();
}
?>