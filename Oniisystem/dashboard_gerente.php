<?php
session_start();
// Verificar si el usuario ha iniciado sesión y el puesto
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.html');
    exit;
}
// Incluir la conexión a la base de datos
include('connection.php');

// Asegúrate de que la variable global de conexión esté disponible
$link = $GLOBALS['link'];

// Consulta para el empleado "Vendedor" con más ventas
$query1 = "SELECT ID_empleado, nombre_empleado, apellido_empleado, COUNT(*) AS total_ventas FROM vista_ventas GROUP BY ID_empleado ORDER BY total_ventas DESC LIMIT 1;";
$result1 = mysqli_query($link, $query1);
$vendedor_top = mysqli_fetch_assoc($result1);

// Consulta para la última venta realizada y el nombre del cliente
$query2 = "SELECT nombre, apellido FROM cliente WHERE ID_cliente = (SELECT ID_cliente FROM ventas ORDER BY fecha_venta DESC LIMIT 1);";
$result2 = mysqli_query($link, $query2);
$ultima_venta = mysqli_fetch_assoc($result2);

// Consulta para el contador de ventas "Pendiente"
$query3 = "SELECT COUNT(*) AS total_pendientes FROM ventas WHERE Estado_Venta = 'Pendiente'";
$result3 = mysqli_query($link, $query3);
$pendientes = mysqli_fetch_assoc($result3);

// Consulta para el contador de servicios "En proceso"
$query4 = "SELECT COUNT(*) AS total_en_proceso FROM servicio WHERE estado_servicio = 'En proceso'";
$result4 = mysqli_query($link, $query4);
$en_proceso = mysqli_fetch_assoc($result4);

mysqli_close($link);
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
                <li><a href="dashboard_gerente.php">Menú</a></li>
                <li><a href="gerente_empleados.php">Empleados</a></li>
                <li><a href="gerente_coches.php">Coches</a></li>
                <li><a href="gerente_ventas.php">Ventas</a></li>
                <li><a href="logout.php" onclick="return confirmLogout();">Log Out</a></li>
            </ul>
        </nav>
        <div class="main-content">
            <header>
                <div class="logo">
                    <img src="logo.png" alt="Logo Empresa">
                </div>
                <div id="date-time" class="date-time"></div>
                <div class="welcome-message">
                    <h1>Bienvenido, Gerente</h1>
                </div>
            </header>
            <div class="cards">
                <div class="card">
                    <h2>Vendedor con más ventas</h2>
                    <p>Nombre: <?php echo $vendedor_top['nombre_empleado']; ?> <?php echo $vendedor_top['apellido_empleado']; ?></p>
                    <p>Total Ventas: <?php echo $vendedor_top['total_ventas']; ?></p>
                </div>
                <div class="card">
                    <h2>Última venta realizada</h2>
                    <p>ID Venta: <?php echo $ultima_venta['ID_venta']; ?></p>
                    <p>Cliente: <?php echo $ultima_venta['nombre']; ?> <?php echo $ultima_venta['apellido']; ?></p>
                    <p>Fecha: <?php echo $ultima_venta['fecha_venta']; ?></p>
                </div>
                <div class="card">
                    <h2>Ventas Pendientes</h2>
                    <p>Total: <?php echo $pendientes['total_pendientes']; ?></p>
                </div>
                <div class="card">
                    <h2>Servicios en Proceso</h2>
                    <p>Total: <?php echo $en_proceso['total_en_proceso']; ?></p>
                </div>
            </div>
        </div>
    </div>
    <script>
    function confirmLogout() {
        // Mostrar el mensaje de confirmación
        return confirm('¿Estás seguro de que quieres cerrar sesión?');
    }
</script>

</body>
</html>