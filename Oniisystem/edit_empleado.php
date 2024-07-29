<?php
include('connection.php');
$link = $GLOBALS['link'];

// Obtener el ID del empleado desde la URL
$id_empleado = isset($_GET['empleado_id']) ? intval($_GET['empleado_id']) : 0;

if ($id_empleado <= 0) {
    die("ID de empleado no válido.");
}

// Consultar el empleado
$query = "SELECT * FROM empleado WHERE ID_empleado = ?";
$stmt = $link->prepare($query);
$stmt->bind_param("i", $id_empleado);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Empleado no encontrado.");
}

$empleado = $result->fetch_assoc();

$stmt->close();
$link->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Empleado</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        function updateDateTime() {
            const now = new Date();
            const dateTimeString = now.toLocaleString('es-ES', { dateStyle: 'full', timeStyle: 'medium' });
            document.getElementById('date-time').innerText = dateTimeString;
        }
        setInterval(updateDateTime, 1000);
    </script>
</head>
<body>
    <div class="container">
        <nav class="nav">
            <ul>
                <li><a href="dashboard_gerente.php">Menú</a></li>
                <li><a href="gerente_empleados.php">Empleados</a></li>
                <li><a href="gerente_coches.php">Coches</a></li>
                <li><a href="gerente_ventas.php">Ventas</a></li>
            </ul>
        </nav>
        
        <div class="main-content">
            <header>
                <div class="logo">
                    <img src="logo.png" alt="Logo Empresa">
                </div>
                <div id="date-time" class="date-time"></div>
                <div class="welcome-message">
                    <h1>Editar Empleado</h1>
                </div>
            </header>

            <form action="update_empleado.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id_empleado" value="<?php echo htmlspecialchars($empleado['ID_empleado']); ?>">
                
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($empleado['nombre']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="apellido">Apellido</label>
                    <input type="text" id="apellido" name="apellido" value="<?php echo htmlspecialchars($empleado['apellido']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="ciudad">Ciudad</label>
                    <input type="text" id="ciudad" name="ciudad" value="<?php echo htmlspecialchars($empleado['ciudad']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="fecha_contrato">Fecha de Contrato</label>
                    <input type="date" id="fecha_contrato" name="fecha_contrato" value="<?php echo htmlspecialchars($empleado['fecha_contrato']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="puesto">Puesto</label>
                    <select id="puesto" name="puesto" required>
                        <option value="Vendedor" <?php echo $empleado['puesto'] === 'Vendedor' ? 'selected' : ''; ?>>Vendedor</option>
                        <option value="Asesor" <?php echo $empleado['puesto'] === 'Asesor' ? 'selected' : ''; ?>>Asesor</option>
                        <option value="Mecánico" <?php echo $empleado['puesto'] === 'Mecánico' ? 'selected' : ''; ?>>Mecánico</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="turno">Turno</label>
                    <select id="turno" name="turno" required>
                        <option value="Matutino (8:00am - 4:00pm)" <?php echo $empleado['turno'] === 'Matutino (8:00am - 4:00pm)' ? 'selected' : ''; ?>>Matutino (8:00am - 4:00pm)</option>
                        <option value="Vespertino (2:00pm - 10:00pm)" <?php echo $empleado['turno'] === 'Vespertino (2:00pm - 10:00pm)' ? 'selected' : ''; ?>>Vespertino (2:00pm - 10:00pm)</option>
                        <option value="Medio tiempo (12:00pm - 5:00pm)" <?php echo $empleado['turno'] === 'Medio tiempo (12:00pm - 5:00pm)' ? 'selected' : ''; ?>>Medio tiempo (12:00pm - 5:00pm)</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="sueldo_base">Sueldo Base</label>
                    <input type="number" id="sueldo_base" name="sueldo_base" step="0.01" value="<?php echo htmlspecialchars($empleado['sueldo_base']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="descuentos">Descuentos</label>
                    <input type="number" id="descuentos" name="descuentos" step="0.01" value="<?php echo htmlspecialchars($empleado['descuentos']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="comision">Comisión</label>
                    <input type="number" id="comision" name="comision" step="0.01" value="<?php echo htmlspecialchars($empleado['comision']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="prestaciones">Prestaciones</label>
                    <select id="prestaciones" name="prestaciones" required>
                        <option value="Prestaciones completas (Turno completo)" <?php echo $empleado['prestaciones'] === 'Prestaciones completas (Turno completo)' ? 'selected' : ''; ?>>Prestaciones completas (Turno completo)</option>
                        <option value="Prestaciones medio tiempo (Medio Turno)" <?php echo $empleado['prestaciones'] === 'Prestaciones medio tiempo (Medio Turno)' ? 'selected' : ''; ?>>Prestaciones medio tiempo (Medio Turno)</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="capacitacion">Capacitación</label>
                    <input type="text" id="capacitacion" name="capacitacion" value="<?php echo htmlspecialchars($empleado['capacitacion']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="prestamos">Préstamos</label>
                    <input type="number" id="prestamos" name="prestamos" step="0.01" value="<?php echo htmlspecialchars($empleado['prestamos']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="foto_empleado">Foto del Empleado</label>
                    <input type="file" id="foto_empleado" name="foto_empleado">
                    <img src="<?php echo htmlspecialchars($empleado['foto_empleado']); ?>" alt="Foto del Empleado" width="100">
                </div>
                
                <div class="form-group">
                    <button type="submit">Actualizar Empleado</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
