<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.html");
    exit();
}
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_caso     = intval($_POST['id_caso'] ?? 0);
    $observacion = trim($_POST['observacion'] ?? '');
    $funcionario = $_SESSION['usuario'];

    if ($id_caso > 0 && !empty($observacion)) {
        $sql = "INSERT INTO seguimiento_casos (id_caso, observacion, funcionario) VALUES (?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("iss", $id_caso, $observacion, $funcionario);
        $stmt->execute();
        $stmt->close();
    }

    header("Location: panel_funcionarios.php?buscar_id=" . $id_caso);
    exit();
}
?>