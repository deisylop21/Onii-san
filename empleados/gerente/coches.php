<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel administrativo</title>
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
                <li><a href="pagina_gerente.php">Menú</a></li>
                <li><a href="empleados.php">Empleados</a></li>
                <li><a href="coches.php">Coches</a></li>
                <li><a href="ventas.php">Ventas</a></li>
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
                    <h1>Gestión de Automoviles</h1>
                </div>
            </header>
            
            <!-- Botones para consultar empleados por puesto -->
            <div class="buttons">
                <button onclick="window.location.href='consulta_coches.php?disponibilidad=Disponible'">Consultar coches disponibles</button>
                <button onclick="window.location.href='consulta_coches.php?disponibilidad=Vendido'">Consultar coches vendidos</button>
                <button onclick="window.location.href='consulta_coches.php?disponibilidad=En servicio'">Consultar coches en servicio</button>
                <button onclick="window.location.href='agregar_coches.php'">Agregar un nuevo coche</button>
            </div>
        </div>
    </div>
</body>
</html>