<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.html");
    exit();
}
require 'conexion.php';

// Lógica de Búsqueda de Caso por ID
$caso_encontrado = null;
$error_busqueda = "";

if (isset($_GET['buscar_id']) && !empty(trim($_GET['buscar_id']))) {
    $id_busqueda = intval($_GET['buscar_id']);
    $sql_buscar = "SELECT * FROM distribuccion_de_caso_del_consejo_de_proteccion WHERE iddistribuccion_de_caso_del_consejo_de_proteccion = ?";
    $stmt_b = $conexion->prepare($sql_buscar);
    $stmt_b->bind_param("i", $id_busqueda);
    $stmt_b->execute();
    $resultado_b = $stmt_b->get_result();
    
    if ($resultado_b->num_rows > 0) {
        $caso_encontrado = $resultado_b->fetch_assoc();
    } else {
        $error_busqueda = "No se encontró ningún caso con el ID: " . $id_busqueda;
    }
}

// Cargar todos los casos para la tabla
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

        /* Estilos de Botones de Acción en Tabla */
        .btn-accion { padding: 5px 10px; border-radius: 4px; text-decoration: none; font-size: 0.85rem; font-weight: bold; display: inline-block; }
        .btn-editar { background: #3B82F6; color: #fff; }
        .btn-editar:hover { background: #2563EB; }
        .btn-eliminar { background: #EF4444; color: #fff; border: none; cursor: pointer; }
        .btn-eliminar:hover { background: #DC2626; }

        /* Ventana Emergente (Modal) */
        .modal { display: none; position: fixed; z-index: 2000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.6); }
        .modal-content { background-color: #fff; margin: 6% auto; padding: 25px; border-radius: 10px; width: 380px; position: relative; box-shadow: 0 5px 15px rgba(0,0,0,0.3); }
        .close-btn { position: absolute; right: 15px; top: 10px; font-size: 24px; cursor: pointer; color: #666; }
        .modal-field { margin-bottom: 12px; }
        .modal-field label { display: block; font-weight: 600; margin-bottom: 4px; font-size: 0.9rem; }
        .modal-field input, .modal-field select { width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        .auth-badge { background-color: #FEF3C7; border: 1px solid #F59E0B; color: #92400E; padding: 8px; border-radius: 5px; font-size: 0.8rem; margin-bottom: 15px; }
    </style>
</head>
<body style="padding:20px;">
    
    <div class="header-flex" style="margin-bottom: 20px;">
        <div>
            <h2>Panel de Gestión de Casos</h2> 
            <p>
                Bienvenido: <strong><?php echo htmlspecialchars($_SESSION['usuario']); ?></strong> | 
                <a href="index.php" style="color: #004D4D; font-weight: bold; text-decoration: underline; margin-right: 10px;">🌐 IR A PUBLICAR EN EL MURO</a> | 
                <a href="logout.php" style="color: #d9534f;">Cerrar Sesión</a>
            </p>
        </div>
        <button class="btn-auth" onclick="abrirModalFuncionario()">➕ Registrar Nuevo Funcionario</button>
    </div>

    <!-- SECCIÓN: BUSCAR CASO POR ID -->
    <div style="background:#fff; padding:20px; border-radius:8px; margin-bottom:30px; box-shadow:0 2px 8px rgba(0,0,0,0.1);">
        <h3>Buscar Caso por ID</h3>
        <form method="GET" action="panel_funcionarios.php" style="display: flex; gap: 10px; max-width: 400px; margin-top: 10px;">
            <input type="number" name="buscar_id" placeholder="Ingrese el ID del caso..." required style="flex: 1; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
            <button type="submit" style="background:#004D4D; color:#fff; border:none; padding: 8px 15px; border-radius:4px; font-weight:bold; cursor:pointer;">Buscar</button>
        </form>

        <?php if (!empty($error_busqueda)): ?>
            <p style="color: #D9534F; margin-top: 10px; font-weight: bold;"><?php echo $error_busqueda; ?></p>
        <?php endif; ?>

        <!-- RESULTADO DE LA BÚSQUEDA -->
        <?php if ($caso_encontrado): ?>
            <div style="margin-top: 20px; padding: 15px; background: #F8F9FA; border-left: 4px solid #004D4D; border-radius: 4px;">
                <h4 style="margin-top:0; color:#004D4D;">Caso Encontrado (ID: <?php echo $caso_encontrado['iddistribuccion_de_caso_del_consejo_de_proteccion']; ?>)</h4>
                <p><strong>Fecha:</strong> <?php echo $caso_encontrado['fecha']; ?></p>
                <p><strong>Nombre del NNYA:</strong> <?php echo htmlspecialchars($caso_encontrado['nombre_completo_del_nin_o']); ?></p>
                <p><strong>Edad:</strong> <?php echo $caso_encontrado['edad']; ?></p>
                <p><strong>Derecho Violentado:</strong> <?php echo htmlspecialchars($caso_encontrado['derecho_violentado']); ?></p>
                <p><strong>Estatus:</strong> <?php echo htmlspecialchars($caso_encontrado['estatud']); ?></p>
                
                <div style="margin-top: 12px; display: flex; gap: 10px;">
                    <a href="#" onclick="abrirModalEditar(
                        '<?php echo $caso_encontrado['iddistribuccion_de_caso_del_consejo_de_proteccion']; ?>',
                        '<?php echo $caso_encontrado['fecha']; ?>',
                        '<?php echo htmlspecialchars($caso_encontrado['nombre_completo_del_nin_o'], ENT_QUOTES); ?>',
                        '<?php echo $caso_encontrado['edad']; ?>',
                        '<?php echo htmlspecialchars($caso_encontrado['derecho_violentado'], ENT_QUOTES); ?>',
                        '<?php echo $caso_encontrado['estatud']; ?>'
                    )" class="btn-accion btn-editar">✏️ Editar este Caso</a>

                    <button onclick="abrirModalEliminar('<?php echo $caso_encontrado['iddistribuccion_de_caso_del_consejo_de_proteccion']; ?>')" class="btn-accion btn-eliminar">🗑️ Eliminar este Caso</button>
                </div>
            </div>
        <?php endif; ?>
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

    <!-- Tabla de consulta general -->
    <h3>Casos Registrados</h3>
    <table border="1" style="width:100%; border-collapse: collapse; text-align:left; background:#fff;">
        <tr style="background:#008282; color:#fff;">
            <th style="padding:10px;">ID</th>
            <th style="padding:10px;">Fecha</th>
            <th style="padding:10px;">Nombre del Niño/A</th>
            <th style="padding:10px;">Edad</th>
            <th style="padding:10px;">Derecho Violentado</th>
            <th style="padding:10px;">Estatus</th>
            <th style="padding:10px; text-align:center;">Acciones</th>
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
                <td style="padding:8px; text-align:center;">
                    <a href="#" onclick="abrirModalEditar(
                        '<?php echo $row['iddistribuccion_de_caso_del_consejo_de_proteccion']; ?>',
                        '<?php echo $row['fecha']; ?>',
                        '<?php echo htmlspecialchars($row['nombre_completo_del_nin_o'], ENT_QUOTES); ?>',
                        '<?php echo $row['edad']; ?>',
                        '<?php echo htmlspecialchars($row['derecho_violentado'], ENT_QUOTES); ?>',
                        '<?php echo $row['estatud']; ?>'
                    )" class="btn-accion btn-editar">Editar</a>
                    
                    <button onclick="abrirModalEliminar('<?php echo $row['iddistribuccion_de_caso_del_consejo_de_proteccion']; ?>')" class="btn-accion btn-eliminar">Eliminar</button>
                </td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="7" style="padding:10px; text-align:center;">No hay casos registrados aún.</td></tr>
        <?php endif; ?>
    </table>

    <!-- MODAL DE REGISTRO DE FUNCIONARIO -->
    <div id="modalFuncionario" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="cerrarModalFuncionario()">&times;</span>
            <h3 style="margin-top:0; color:#004D4D;">Registro de Funcionario</h3>
            <div class="auth-badge">🔐 Requiere la Clave de Autorización Maestra.</div>
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
                <button type="submit" class="btn-auth" style="width:100%;">Autorizar y Registrar</button>
            </form>
        </div>
    </div>

    <!-- MODAL PARA EDITAR CASO -->
    <div id="modalEditar" class="modal">
        <div class="modal-content" style="width: 420px;">
            <span class="close-btn" onclick="cerrarModalEditar()">&times;</span>
            <h3 style="margin-top:0; color:#004D4D;">Editar Caso</h3>
            <form action="actualizar_caso.php" method="POST">
                <input type="hidden" name="id" id="edit_id">
                <div class="modal-field">
                    <label>Fecha:</label>
                    <input type="date" name="fecha" id="edit_fecha" required>
                </div>
                <div class="modal-field">
                    <label>Nombre del NNYA:</label>
                    <input type="text" name="nombre_completo_del_nin_o" id="edit_nombre" required>
                </div>
                <div class="modal-field">
                    <label>Edad:</label>
                    <input type="number" name="edad" id="edit_edad" required>
                </div>
                <div class="modal-field">
                    <label>Derecho Violentado:</label>
                    <input type="text" name="derecho_violentado" id="edit_derecho" required>
                </div>
                <div class="modal-field">
                    <label>Estatus:</label>
                    <select name="estatud" id="edit_estatud" required>
                        <option value="En Proceso">En Proceso</option>
                        <option value="Resuelto">Resuelto</option>
                        <option value="Remitido">Remitido</option>
                    </select>
                </div>
                <br>
                <button type="submit" class="btn-auth" style="width:100%; background:#3B82F6;">Guardar Cambios</button>
            </form>
        </div>
    </div>

    <!-- MODAL PARA ELIMINAR CASO (REQUIERE CLAVE ESPECIAL) -->
    <div id="modalEliminar" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="cerrarModalEliminar()">&times;</span>
            <h3 style="margin-top:0; color:#DC2626;">Eliminar Caso</h3>
            <div class="auth-badge" style="background-color: #FEE2E2; border-color: #EF4444; color: #991B1B;">
                ⚠️ Ingrese la clave especial para autorizar la eliminación de este caso.
            </div>
            <form action="eliminar_caso.php" method="POST">
                <input type="hidden" name="id" id="delete_id">
                <div class="modal-field">
                    <label style="color:#B91C1C;">Clave Especial de Autorización:</label>
                    <input type="password" name="clave_especial" placeholder="Ingrese clave maestra" required>
                </div>
                <br>
                <button type="submit" class="btn-auth" style="width:100%; background:#EF4444;">Autorizar y Eliminar</button>
            </form>
        </div>
    </div>

    <script>
    // Funciones Modal Funcionario
    function abrirModalFuncionario() { document.getElementById('modalFuncionario').style.display = 'block'; }
    function cerrarModalFuncionario() { document.getElementById('modalFuncionario').style.display = 'none'; }

    // Funciones Modal Editar
    function abrirModalEditar(id, fecha, nombre, edad, derecho, estatud) {
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_fecha').value = fecha;
        document.getElementById('edit_nombre').value = nombre;
        document.getElementById('edit_edad').value = edad;
        document.getElementById('edit_derecho').value = derecho;
        document.getElementById('edit_estatud').value = estatud;
        document.getElementById('modalEditar').style.display = 'block';
    }
    function cerrarModalEditar() { document.getElementById('modalEditar').style.display = 'none'; }

    // Funciones Modal Eliminar
    function abrirModalEliminar(id) {
        document.getElementById('delete_id').value = id;
        document.getElementById('modalEliminar').style.display = 'block';
    }
    function cerrarModalEliminar() { document.getElementById('modalEliminar').style.display = 'none'; }

    // Cerrar modales haciendo clic fuera del contenido
    window.onclick = function(event) {
        if (event.target == document.getElementById('modalFuncionario')) cerrarModalFuncionario();
        if (event.target == document.getElementById('modalEditar')) cerrarModalEditar();
        if (event.target == document.getElementById('modalEliminar')) cerrarModalEliminar();
    }
    </script>
</body>
</html>
