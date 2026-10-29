<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require 'conexion.php';
$es_funcionario = isset($_SESSION['usuario']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COMDEPRO San Francisco - Sistema de Protección Integral</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header style="background: #fff; padding: 10px 30px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); display: flex; justify-content: space-between; align-items: center;">
    <!-- ÁREA DEL LOGO Y TÍTULO -->
    <div style="display: flex; align-items: center; gap: 12px;">
        <img src="logo.png" alt="Logo COMDEPRO" style="height: 50px; width: auto; object-fit: contain;">
        <span style="font-weight: bold; font-size: 1.1rem; color: #004D4D;">COMDEPRO San Francisco</span>
    </div>

    <!-- MENÚ DE NAVEGACIÓN Y BOTÓN DE ACCESO -->
    <nav style="display: flex; align-items: center; gap: 20px;">
        <a href="#inicio" style="text-decoration: none; color: #333; font-weight: 600; font-size: 0.9rem;">INICIO</a>
        <a href="#nosotros" style="text-decoration: none; color: #333; font-weight: 600; font-size: 0.9rem;">NOSOTROS</a>
        <a href="#servicios" style="text-decoration: none; color: #333; font-weight: 600; font-size: 0.9rem;">SERVICIOS</a>
        <a href="#horarios" style="text-decoration: none; color: #333; font-weight: 600; font-size: 0.9rem;">HORARIOS</a>
        <a href="#organigrama" style="text-decoration: none; color: #333; font-weight: 600; font-size: 0.9rem;">ORGANIGRAMA</a>
        <a href="#publicaciones" style="text-decoration: none; color: #333; font-weight: 600; font-size: 0.9rem;">PUBLICACIONES</a>
        
        <?php if ($es_funcionario): ?>
            <a href="logout.php" style="background: #004D4D; color: #fff; padding: 8px 18px; border-radius: 20px; text-decoration: none; font-weight: bold; font-size: 0.85rem; display: flex; align-items: center; gap: 5px;">
                CERRAR SESIÓN (<?php echo htmlspecialchars($_SESSION['usuario']); ?>) 🔒
            </a>
        <?php else: ?>
            <a href="login.html" style="background: #004D4D; color: #fff; padding: 8px 18px; border-radius: 20px; text-decoration: none; font-weight: bold; font-size: 0.85rem; display: flex; align-items: center; gap: 5px;">
                ACCESO FUNCIONARIOS 🔒
            </a>
        <?php endif; ?>
    </nav>
</header>

<main>
    <!-- Sección Hero / Inicio -->
    <section id="inicio" class="hero container">
        <h1>Consejo Municipal de Derechos para la Protección del Niño, Niña y Adolescente</h1>
        <p>Garantizando el bienestar, protección y restitución de derechos en el Municipio San Francisco.</p>
    </section>

    <!-- Sección Nosotros: Misión y Visión -->
    <section id="nosotros" class="about container">
        <div class="section-title">
            <h2>Nuestra Institución</h2>
            <p>Comprometidos con el Interés Superior del Niño, Niña y Adolescente</p>
        </div>
        <div class="about-grid">
            <div class="about-card">
                <div class="icon-box">🎯</div>
                <h3>MISIÓN</h3>
                <p>
                    La Protección Integral de los Niños, Niñas, y Adolescentes que habitan en el Municipio San Francisco, a través de la actuación oportuna del sistema de Protección Integral, Municipal, como unidad primaria, para restablecer los Derechos que pueden ser vulnerados; articulando, la acción del Órgano de Protección, con los programas, servicios y políticas públicas, que puedan asegurar la preminencia del Interés Superior del niño, como prioridad absoluta, sin discriminación alguna y con calidad en la atención social, para así poder alcanzar el pleno ejercicio de sus Derechos y Garantías; activando así el principio de corresponsabilidad entre el Estado, la Familia y la Sociedad[cite: 2].
                </p>
            </div>
            <div class="about-card">
                <div class="icon-box">👁️</div>
                <h3>VISIÓN</h3>
                <p>
                    Establecer un sistema de protección del Niño, Niña y Adolescentes en el Municipio San Francisco, que garantice, proteja y defienda sus Derechos, con eficiencia, eficacia, celeridad y equidad, bajo el Marco Legal vigente en la materia, incorporando al Estado, la familia y la sociedad; a los fines de dar respuesta oportuna a las carencias y necesidades de la infancia y la adolescencia San Franciscana, que nos permita formar un ciudadano con ética, valores y principios, que se incorpore de manera progresiva a la vida y al desarrollo social de la localidad[cite: 2].
                </p>
            </div>
        </div>
    </section>

    <!-- Servicios -->
    <section id="servicios" class="services container">
        <div class="section-title">
            <h2>Nuestros Servicios</h2>
        </div>
        <div class="services-grid">
            <div class="service-card">
                <h3>Servicio de Defensoría de NNYA</h3>
                <p>Atención, asesoría y restitución de derechos vulnerados a niños, niñas y adolescentes[cite: 1].</p>
            </div>
            <div class="service-card">
                <h3>Consejo de Protección</h3>
                <p>Gestión de medidas de protección y seguimiento continuado a través de los Consejeros de Protección[cite: 1].</p>
            </div>
            <div class="service-card">
                <h3>Atención Multidisciplinaria</h3>
                <p>Apoyo especializado con equipo técnico integrado por Trabajadores Sociales, Psicólogos y Asesores Legales[cite: 1].</p>
            </div>
        </div>
    </section>

    <!-- Horarios -->
    <section id="horarios" class="horarios container">
        <div class="section-title">
            <h2>Horarios de Atención</h2>
        </div>
        <div class="card schedule-card">
            <div class="schedule-item">
                <span class="day">Lunes a Viernes</span>
                <span class="time">8:00 AM - 4:00 PM</span>
            </div>
            <div class="schedule-item">
                <span class="day">Atención de Emergencias / Guardia</span>
                <span class="time">Disponible 24/7 (Consejo de Protección)</span>
            </div>
        </div>
    </section>

    <!-- Organigrama -->
    <section id="organigrama" class="organigrama container">
        <div class="section-title">
            <h2>Estructura Organizativa</h2>
            <p>Organigrama Institucional COMDEPRO San Francisco</p>
        </div>
        <div class="org-tree">
            <div class="org-node level-1">Alcaldía del Municipio San Francisco - Despacho del Alcalde[cite: 1]</div>
            <div class="org-connector"></div>
            <div class="org-node level-2">Consejo Municipal de Derechos (CMDNNYA)[cite: 1]</div>
            <div class="org-connector"></div>
            <div class="org-node level-3">Presidenta CMDNNYA / Coordinación General[cite: 1]</div>
            
            <div class="org-branches">
                <div class="branch">
                    <div class="org-node level-4">Coord. General de Gestión de Talento Humano[cite: 1]</div>
                </div>
                <div class="branch">
                    <div class="org-node level-4">Servicio de Defensoría de NNYA[cite: 1]</div>
                    <div class="org-subnodes">
                        <span>Defensores y Asistentes (08)[cite: 1]</span>
                    </div>
                </div>
                <div class="branch">
                    <div class="org-node level-4">Consejo de Protección de NNYA[cite: 1]</div>
                    <div class="org-subnodes">
                        <span>Sub-Sede A: San Francisco - El Bajo[cite: 1]</span>
                        <span>Sub-Sede B: Marcial Hernández - Francisco Ochoa[cite: 1]</span>
                        <span>Sub-Sede C: Domitila Flores - Los Cortijos[cite: 1]</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Muro Informativo (Publicaciones Dinámicas) -->
    <section id="publicaciones" class="muro container" style="max-width: 650px; margin: 40px auto; padding: 0 15px;">
        <div class="section-title">
            <h2>Muro Informativo</h2>
            <p>Actividades y novedades institucionales</p>
        </div>

        <!-- CAJA DE PUBLICAR (SOLO FUNCIONARIOS LOGUEADOS) -->
        <?php if ($es_funcionario): ?>
            <div style="background: #fff; padding: 18px; border-radius: 10px; border: 1px solid #008282; box-shadow: 0 2px 8px rgba(0,0,0,0.08); margin-bottom: 25px;">
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                    <img src="logo.png" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                    <div>
                        <strong style="color: #004D4D; font-size: 0.95rem; display: block;">
                            COMDEPRO (<?php echo htmlspecialchars($_SESSION['usuario']); ?>)
                        </strong>
                        <span style="font-size: 0.75rem; color: #2e7d32; font-weight: bold;">🟢 Sesión de Funcionario Activa</span>
                    </div>
                </div>

                <form action="guardar_publicacion.php" method="POST" enctype="multipart/form-data">
                    <textarea name="contenido" placeholder="Escribe un comunicado o noticia oficial..." rows="3" style="width: 100%; border: 1px solid #ccc; border-radius: 8px; padding: 10px; box-sizing: border-box; resize: none; font-family: inherit;" required></textarea>
                    
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 12px;">
                        <label style="cursor: pointer; background: #f0f2f5; padding: 8px 14px; border-radius: 20px; font-size: 0.85rem; font-weight: bold; color: #004D4D;">
                            📷 Adjuntar Foto
                            <input type="file" name="imagen" accept="image/*" style="display: none;">
                        </label>
                        <button type="submit" style="background: #1877F2; color: #fff; border: none; padding: 8px 22px; border-radius: 20px; font-weight: bold; cursor: pointer; font-size: 0.9rem;">Publicar</button>
                    </div>
                </form>
            </div>
        <?php else: ?>
            <div style="background: #E6F4F4; padding: 12px 18px; border-radius: 8px; border-left: 4px solid #004D4D; margin-bottom: 25px; font-size: 0.88rem; color: #004D4D;">
                ℹ️ <b>Muro Informativo Oficial:</b> Solo el personal autorizado de COMDEPRO puede realizar publicaciones.
            </div>
        <?php endif; ?>

        <!-- CONSULTA Y DESPLIEGUE DE PUBLICACIONES DESDE MYSQL -->
        <?php
        $sql_pub = "SELECT * FROM publicacion ORDER BY fecha_registro DESC";
        $res_pub = $conexion->query($sql_pub);

        if ($res_pub && $res_pub->num_rows > 0):
            while ($post = $res_pub->fetch_assoc()):
                $fecha_formateada = date("d/m/Y - h:i A", strtotime($post['fecha_registro']));
        ?>
            <div style="background: #fff; border-radius: 10px; border: 1px solid #e4e6eb; margin-bottom: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); overflow: hidden;">
                
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px 16px;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <img src="logo.png" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                        <div>
                            <strong style="color: #050505; font-size: 0.95rem; display: block;">COMDEPRO San Francisco</strong>
                            <span style="font-size: 0.75rem; color: #65676B;"><?php echo $fecha_formateada; ?> • 🌐</span>
                        </div>
                    </div>

                    <?php if ($es_funcionario): ?>
                        <div style="display: flex; gap: 8px;">
                            <button onclick="mostrarEdicion(<?php echo $post['id']; ?>)" style="background: #E4E6EB; border: none; padding: 6px 12px; border-radius: 15px; cursor: pointer; font-size: 0.8rem; font-weight: bold; color: #050505;">✏️ Editar</button>
                            <a href="acciones_publicacion.php?accion=eliminar&id=<?php echo $post['id']; ?>" onclick="return confirm('¿Seguro que deseas eliminar esta publicación?');" style="background: #FFEBE9; border: none; padding: 6px 12px; border-radius: 15px; text-decoration: none; font-size: 0.8rem; font-weight: bold; color: #D93025;">🗑️ Eliminar</a>
                        </div>
                    <?php endif; ?>
                </div>

                <div id="texto-<?php echo $post['id']; ?>" style="padding: 0 16px 12px 16px; color: #050505; font-size: 0.95rem; line-height: 1.4;">
                    <?php echo nl2br(htmlspecialchars($post['contenido'])); ?>
                </div>

                <?php if ($es_funcionario): ?>
                    <div id="form-edit-<?php echo $post['id']; ?>" style="display: none; padding: 0 16px 12px 16px;">
                        <form action="acciones_publicacion.php?accion=editar" method="POST">
                            <input type="hidden" name="id" value="<?php echo $post['id']; ?>">
                            <textarea name="contenido" style="width: 100%; padding: 8px; border: 1px solid #008282; border-radius: 6px; box-sizing: border-box; resize: vertical;"><?php echo htmlspecialchars($post['contenido']); ?></textarea>
                            <div style="margin-top: 8px; display: flex; gap: 8px;">
                                <button type="submit" style="background: #008282; color: #fff; border: none; padding: 6px 14px; border-radius: 15px; font-weight: bold; cursor: pointer; font-size: 0.8rem;">Guardar Cambios</button>
                                <button type="button" onclick="ocultarEdicion(<?php echo $post['id']; ?>)" style="background: #ccc; color: #333; border: none; padding: 6px 14px; border-radius: 15px; font-weight: bold; cursor: pointer; font-size: 0.8rem;">Cancelar</button>
                            </div>
                        </form>
                    </div>
                <?php endif; ?>

                <?php if (!empty($post['imagen'])): ?>
                    <div style="width: 100%; background: #000;">
                        <img src="<?php echo $post['imagen']; ?>" style="width: 100%; max-height: 500px; object-fit: contain; display: block;">
                    </div>
                <?php endif; ?>

            </div>
        <?php 
            endwhile;
        else:
        ?>
            <p style="text-align: center; color: #666;">No hay publicaciones registradas aún.</p>
        <?php endif; ?>
    </section>
</main>

<footer>
    <div class="container">
        <p>&copy; 2026 COMDEPRO - Alcaldía del Municipio San Francisco. República Bolivariana de Venezuela[cite: 1].</p>
    </div>
</footer>

<script style="display:none;">
function mostrarEdicion(id) {
    document.getElementById('texto-' + id).style.display = 'none';
    document.getElementById('form-edit-' + id).style.display = 'block';
}
function ocultarEdicion(id) {
    document.getElementById('texto-' + id).style.display = 'block';
    document.getElementById('form-edit-' + id).style.display = 'none';
}
</script>
<script src="script.js"></script>
</body>
</html>