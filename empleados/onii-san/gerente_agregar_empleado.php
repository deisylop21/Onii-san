<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Empleado</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        // Script para mostrar la fecha y hora actual
        function updateDateTime() {
            const now = new Date();
            const dateTimeString = now.toLocaleString('es-ES', { dateStyle: 'full', timeStyle: 'medium' });
            document.getElementById('date-time').innerText = dateTimeString;
        }
        setInterval(updateDateTime, 1000); // Actualizar cada segundo
    </script>
</head>
<body>
    <div class="container">
        <!-- Lateral Navigation -->
        <nav class="nav">
            <ul>
                <li><a href="gerente_main.php">Menú</a></li>
                <li><a href="gerente_empleados.php">Empleados</a></li>
                <li><a href="gerente_coches.php">Coches</a></li>
                <li><a href="gerente_ventas.php">Ventas</a></li>
            </ul>
        </nav>
        
        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <header>
                <div class="logo">
                    <img src="logo.png" alt="Logo Empresa">
                </div>
                <div id="date-time" class="date-time"></div>
                <div class="welcome-message">
                    <h1>Agregar Empleado</h1>
                </div>
            </header>

            <!-- Formulario de Agregar Empleado -->
            <form action="gerente_procesar_agregar_empleado.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" name="nombre" required>
                </div>
                
                <div class="form-group">
                    <label for="apellido">Apellido</label>
                    <input type="text" id="apellido" name="apellido" required>
                </div>
                
                <div class="form-group">
                    <label for="telefono">Teléfono</label>
                    <input type="text" id="telefono" name="telefono" required>
                </div>
                
                <div class="form-group">
                    <label for="correo">Correo</label>
                    <input type="email" id="correo" name="correo" required>
                </div>
                
                <div class="form-group">
                    <label for="direccion">Dirección</label>
                    <input type="text" id="direccion" name="direccion" required>
                </div>
                
                <div class="form-group">
                    <label for="ciudad">Ciudad</label>
                    <input type="text" id="ciudad" name="ciudad" required>
                </div>
                
                <div class="form-group">
                    <label for="codigo_postal">Código Postal</label>
                    <input type="text" id="codigo_postal" name="codigo_postal" required>
                </div>
                
                <div class="form-group">
                    <label for="fecha_contrato">Fecha de Contrato</label>
                    <input type="date" id="fecha_contrato" name="fecha_contrato" required>
                </div>
                
                <div class="form-group">
                    <label for="numero_seguro">Número de Seguro Social</label>
                    <input type="text" id="numero_seguro" name="numero_seguro" required>
                </div>
                
                <div class="form-group">
                    <label for="puesto">Puesto</label>
                    <select id="puesto" name="puesto" required>
                        <option value="Vendedor">Vendedor</option>
                        <option value="Asesor">Asesor</option>
                        <option value="Mecánico">Mecánico</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="turno">Turno</label>
                    <select id="turno" name="turno" required>
                        <option value="Matutino (8:00am - 4:00pm)">Matutino (8:00am - 4:00pm)</option>
                        <option value="Vespertino (2:00pm - 10:00pm)">Vespertino (2:00pm - 10:00pm)</option>
                        <option value="Medio tiempo (12:00pm - 5:00pm)">Medio tiempo (12:00pm - 5:00pm)</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="numero_cuenta">Número de Cuenta Bancaria</label>
                    <input type="text" id="numero_cuenta" name="numero_cuenta" required>
                </div>
                
                <div class="form-group">
                    <label for="sueldo_base">Sueldo Base</label>
                    <input type="number" id="sueldo_base" name="sueldo_base" step="0.01" required>
                </div>
                
                <div class="form-group">
                    <label for="descuentos">Descuentos</label>
                    <input type="number" id="descuentos" name="descuentos" step="0.01" required>
                </div>
                
                <div class="form-group">
                    <label for="comision">Comisión</label>
                    <input type="number" id="comision" name="comision" step="0.01" required>
                </div>
                
                <div class="form-group">
                    <label for="prestaciones">Prestaciones</label>
                    <select id="prestaciones" name="prestaciones" required>
                        <option value="Prestaciones completas (Turno completo)">Prestaciones completas (Turno completo)</option>
                        <option value="Prestaciones medio tiempo (Medio Turno)">Prestaciones medio tiempo (Medio Turno)</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="capacitacion">Capacitación</label>
                    <select id="capacitacion" name="capacitacion" required>
                        <option value="Capacitación de vendedor (En proceso)">Capacitación de vendedor (En proceso)</option>
                        <option value="Capacitación de mécanico (En proceso)">Capacitación de mécanico (En proceso)</option>
                        <option value="Capacitación de completa">Capacitación de completa</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="prestamos">Préstamos</label>
                    <input type="number" id="prestamos" name="prestamos" step="0.01" required>
                </div>
                
                <div class="form-group">
                    <label for="foto_empleado">Foto del Empleado</label>
                    <input type="file" id="foto_empleado" name="foto_empleado" required>
                </div>
                
                <button type="submit">Agregar Empleado</button>
            </form>
        </div>
    </div>
</body>
</html>