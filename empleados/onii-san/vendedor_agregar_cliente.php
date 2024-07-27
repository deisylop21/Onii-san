<?php
session_start(); // Iniciar la sesión al principio del archivo
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Cliente</title>
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
                <li><a href="vendedor_main.php">Menú</a></li>
                <li><a href="vendedor_ventas.php">Ventas</a></li>
                <li><a href="vendedor_servicios.php">Servicios</a></li>
                <li class="profile-button"><a href="perfil_gerente.php">Perfil</a></li>
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
                    <h1>Agregar Cliente</h1>
                </div>
            </header>

            <!-- Formulario de Agregar Cliente -->
            <h1>Registrar Cliente</h1>
            <form action="vendedor_procesar_cliente.php" method="post">
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
                
                <button type="submit">Registrar Cliente</button>
            </form>
        </div>
    </div>
</body>
</html>