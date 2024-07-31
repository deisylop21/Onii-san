<?php
session_start();

if (!isset($_SESSION['username']) || !isset($_SESSION['puesto']) || !isset($_SESSION['ID_empleado']) || $_SESSION['puesto'] !== 'Vendedor') {
    header('Location: index.html');
    exit;
}

include('connection.php');

$link = $GLOBALS['link'];

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
                <li><a href="dashboard_vendedor.php">Menú</a></li>
                <li><a href="vendedor_ventas.php">Ventas</a></li>


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
                <button onclick="window.location.href='add_cliente.php'">Nueva venta</button>
            </div>
        </div>
    </div>
</body>
</html>