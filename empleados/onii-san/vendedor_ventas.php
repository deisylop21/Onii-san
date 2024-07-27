<?php
include('connection.php');

session_start();

// Verificar si el usuario está logueado y tiene un rol válido
if (!isset($_SESSION['ID_empleado'])) {
    header('Location: /login.php');
    exit();
}

$id_empleado = $_SESSION['ID_empleado'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel administrativo</title>
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
                <li><a href="vendedor_main.php">Menú</a></li>
                <li><a href="vendedor_ventas.php">Ventas</a></li>
                <li><a href="vendedor_servicios.php">Servicios</a></li>
                <li class="profile-button"><a href="perfil_gerente.php">Perfil</a></li>
            </ul>
        </nav>
        <div class="main-content">
            <header>
                <div class="logo">
                    <img src="logo.png" alt="Logo Empresa">
                </div>
                <div id="date-time" class="date-time"></div>
                <div class="welcome-message">
                    <h1>Ventas</h1>
                </div>
            </header>
            <div class="buttons">
                <button onclick="window.location.href='vendedor_ventas_pendiente.php'">Consulta ventas pendientes</button>
                <button onclick="window.location.href='vendedor_ventas_concluidas.php'">Consulta ventas concluidas</button>
                <button onclick="window.location.href='vendedor_clientes.php'">Consulta clientes sin ventas</button>
                <button onclick="window.location.href='vendedor_agregar_cliente.php'">Nuueva venta</button>
            </div>
        </div>
    </div>
</body>
</html>