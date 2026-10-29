<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.html");
    exit();
}
require 'conexion.php';

// Consultar casos registrados en el Consejo de Protección
$query_casos = "SELECT * FROM distribuccion_de_caso_del_consejo_de_proteccion";
$casos = $conexion->query($query_casos);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Funcionarios - COMDEPRO</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="container header-container">
            <h2>Panel de Administración de Casos</h2>
            <a href="logout.php" class="btn-private">Cerrar Sesión</a>
        </div>
    </header>

    <main class="container" style="margin-top: 30px;">
        <h3>Casos Registrados (Consejo de Protección)</h3>
        <table border="1" style="width:100%; border-collapse: collapse; background: #fff; text-align:left;">
            <thead>
                <tr style="background:var(--primary-teal); color:#fff;">
                    <th style="padding: 10px;">ID</th>
                    <th style="padding: 10px;">Fecha</th>
                    <th style="padding: 10px;">Nombre del Niño/Niña</th>
                    <th style="padding: 10px;">Edad</th>
                    <th style="padding: 10px;">Derecho Violentado</th>
                    <th style="padding: 10px;">Estatus</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $casos->fetch_assoc()): ?>
                <tr>
                    <td style="padding: 8px;"><?php echo $row['iddistribuccion_de_caso_del_consejo_de_proteccion']; ?></td>
                    <td style="padding: 8px;"><?php echo $row['fecha']; ?></td>
                    <td style="padding: 8px;"><?php echo $row['nombre_completo_del_nin_o']; ?></td>
                    <td style="padding: 8px;"><?php echo $row['edad']; ?></td>
                    <td style="padding: 8px;"><?php echo $row['derecho_violentado']; ?></td>
                    <td style="padding: 8px;"><?php echo $row['estatud']; ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </main>
</body>
</html>