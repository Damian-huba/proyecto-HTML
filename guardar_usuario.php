<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.html");
    exit();
}
require 'conexion.php';

// Clave Maestra Especial de Autorización para el Ente/Supervisor
define('CLAVE_AUTORIZACION', 'COMDEPRO2026'); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $clave_especial = $_POST['clave_especial'] ?? '';
    $cedula         = trim($_POST['cedula'] ?? '');
    $nuevo_usuario  = trim($_POST['usuario'] ?? '');
    $nuevo_password = $_POST['password'] ?? '';

    // 1. Validar la Clave Especial de Autorización
    if ($clave_especial !== CLAVE_AUTORIZACION) {
        echo "<script>alert('Error: La Clave de Autorización Especial es incorrecta.'); window.location.href='panel_funcionarios.php';</script>";
        exit();
    }

    // 2. Validar que los campos no estén vacíos
    if (empty($cedula) || empty($nuevo_usuario) || empty($nuevo_password)) {
        echo "<script>alert('Error: Todos los campos son obligatorios.'); window.location.href='panel_funcionarios.php';</script>";
        exit();
    }

    // 3. Verificar si el usuario o la cédula ya existen en la BD
    $check_sql = "SELECT * FROM usuario WHERE usuario = ? OR cedula = ?";
    $stmt_check = $conexion->prepare($check_sql);
    $stmt_check->bind_param("ss", $nuevo_usuario, $cedula);
    $stmt_check->execute();
    $res_check = $stmt_check->get_result();

    if ($res_check->num_rows > 0) {
        echo "<script>alert('El usuario o la cédula ya se encuentran registrados en el sistema.'); window.location.href='panel_funcionarios.php';</script>";
        exit();
    }

    // 4. Registrar al nuevo funcionario
    $sql = "INSERT INTO usuario (usuario, password, cedula) VALUES (?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sss", $nuevo_usuario, $nuevo_password, $cedula);

    if ($stmt->execute()) {
        echo "<script>alert('¡Funcionario registrado exitosamente! Ya puede acceder al sistema.'); window.location.href='panel_funcionarios.php';</script>";
    } else {
        echo "<script>alert('Error al guardar en la BD: " . $conexion->error . "'); window.location.href='panel_funcionarios.php';</script>";
    }
}
?>