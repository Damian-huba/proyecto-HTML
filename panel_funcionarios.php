<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.html");
    exit();
}
require 'conexion.php';

$query_casos = "SELECT * FROM distribuccion_de_caso_del_consejo_de_proteccion";
$casos = $conexion->query($query_casos);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Funcionarios - COMDEPRO</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .header-flex { display: flex; justify-content: space-between; align-items: center; }
        .btn-auth { background: #004D4D; color: #fff; border: none; padding: 10px 18px; border-radius: 20px; font-weight: bold; cursor: pointer; }
        .btn-auth:hover { background: #008282; }

        /* Ventana Emergente (Modal) */
        .modal { display: none; position: fixed; z-index: 2000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.6); }
        .modal-content { background-color: #fff; margin: 6% auto; padding: 25px; border-radius: 10px; width: 380px; position: relative; box-shadow: 0 5px 15px rgba(0,0,0,0.3); }
        .close-btn { position: absolute; right: 15px; top: 10px; font-size: 24px; cursor: pointer; color: #666; }
        .modal-field { margin-bottom: 12px; }
        .modal-field label { display: block; font-weight: 600; margin-bottom: 4px; font-size: 0.9rem; }
        .modal-field input { width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        .auth-badge { background-color: #FEF3C7; border: 1px solid #F59E0B; color: #92400E; padding: 8px; border-radius: 5px; font-size: 0.8rem; margin-bottom: 15px; }
    </style>
</head>
<body style="padding:20px;">
    
    <div class="header-flex" style="margin-bottom: 20px;">
        <div>
            <h2>Panel de Gestión de Casos</h2> <p>
    Bienvenido: <strong><?php echo htmlspecialchars($_SESSION['usuario']); ?></strong> | 
    <a href="index.php" style="color: #004D4D; font-weight: bold; text-decoration: underline; margin-right: 10px;">🌐 IR A PUBLICAR EN EL MURO </a> | 
    <a href="logout.php" style="color: #d9534f;">Cerrar Sesión</a>
</p>
        </div>
        <button class="btn-auth" onclick="abrirModal()">➕ Registrar Nuevo Funcionario</button>
    </div>

    <!-- Formulario para ingresar nuevos casos -->
    <div style="background:#fff; padding:20px; border-radius:8px; margin-bottom:30px; box-shadow:0 2px 8px rgba(0,0,0,0.1);">
        <h3>Registrar Nuevo Caso</h3>
        <form action="guardar_caso.php" method="POST" style="display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap:15px;">
            <div>
                <label>Fecha:</label>
                <input type="date" name="fecha" required style="width:100%; padding:8px; box-sizing:border-box;">
            </div>
            <div>
                <label>Nombre del NNYA:</label>
                <input type="text" name="nombre_completo_del_nin_o" required style="width:100%; padding:8px; box-sizing:border-box;">
            </div>
            <div>
                <label>Edad:</label>
                <input type="number" name="edad" required style="width:100%; padding:8px; box-sizing:border-box;">
            </div>
            <div>
                <label>Derecho Violentado:</label>
                <input type="text" name="derecho_violentado" required style="width:100%; padding:8px; box-sizing:border-box;">
            </div>
            <div>
                <label>Estatus:</label>
                <select name="estatud" required style="width:100%; padding:8px; box-sizing:border-box;">
                    <option value="En Proceso">En Proceso</option>
                    <option value="Resuelto">Resuelto</option>
                    <option value="Remitido">Remitido</option>
                </select>
            </div>
            <div style="grid-column: 1 / -1;">
                <button type="submit" style="background:#008282; color:#fff; border:none; padding:10px 20px; border-radius:5px; cursor:pointer; font-weight:bold;">Guardar Caso</button>
            </div>
        </form>
    </div>

    <!-- Tabla de consulta -->
    <h3>Casos Registrados</h3>
    <table border="1" style="width:100%; border-collapse: collapse; text-align:left; background:#fff;">
        <tr style="background:#008282; color:#fff;">
            <th style="padding:10px;">ID</th>
            <th style="padding:10px;">Fecha</th>
            <th style="padding:10px;">Nombre del Niño/A</th>
            <th style="padding:10px;">Edad</th>
            <th style="padding:10px;">Derecho Violentado</th>
            <th style="padding:10px;">Estatus</th>
        </tr>
        <?php if($casos && $casos->num_rows > 0): ?>
            <?php while($row = $casos->fetch_assoc()): ?>
            <tr>
                <td style="padding:8px;"><?php echo $row['iddistribuccion_de_caso_del_consejo_de_proteccion']; ?></td>
                <td style="padding:8px;"><?php echo $row['fecha']; ?></td>
                <td style="padding:8px;"><?php echo htmlspecialchars($row['nombre_completo_del_nin_o']); ?></td>
                <td style="padding:8px;"><?php echo $row['edad']; ?></td>
                <td style="padding:8px;"><?php echo htmlspecialchars($row['derecho_violentado']); ?></td>
                <td style="padding:8px;"><?php echo htmlspecialchars($row['estatud']); ?></td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="6" style="padding:10px; text-align:center;">No hay casos registrados aún.</td></tr>
        <?php endif; ?>
    </table>

    <!-- MODAL DE REGISTRO DE FUNCIONARIO CON AUTORIZACIÓN ESPECIAL -->
    <div id="modalFuncionario" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="cerrarModal()">&times;</span>
            <h3 style="margin-top:0; color:#004D4D;">Registro de Funcionario</h3>
            <div class="auth-badge">
                🔐 Requiere la Clave de Autorización Maestra para autorizar la creación del usuario.
            </div>

            <form action="guardar_usuario.php" method="POST">
                <div class="modal-field">
                    <label style="color:#B91C1C;">Clave Especial de Autorización:</label>
                    <input type="password" name="clave_especial" placeholder="Ingrese clave maestra" required>
                </div>

                <hr style="margin: 15px 0; border: 0; border-top: 1px dashed #ccc;">

                <div class="modal-field">
                    <label>Cédula de Identidad:</label>
                    <input type="text" name="cedula" placeholder="Ej: V-20123456" required>
                </div>

                <div class="modal-field">
                    <label>Usuario:</label>
                    <input type="text" name="usuario" placeholder="Ej: jperez" required>
                </div>

                <div class="modal-field">
                    <label>Contraseña:</label>
                    <input type="password" name="password" placeholder="Contraseña de acceso" required>
                </div>

                <br>
                <button type="submit" class="btn-auth" style="width:100%;">Autorizar y Registrar Funcionario</button>
            </form>
        </div>
    </div>

    <script>
    function abrirModal() {
        document.getElementById('modalFuncionario').style.display = 'block';
    }
    function cerrarModal() {
        document.getElementById('modalFuncionario').style.display = 'none';
    }
    window.onclick = function(event) {
        var modal = document.getElementById('modalFuncionario');
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    </script>
</body>
</html>
