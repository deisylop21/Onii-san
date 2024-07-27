<?php
include('connection.php');

// Consulta para el empleado "Vendedor" con más ventas
$query1 = "SELECT v.ID_empleado, e.foto_empleado, v.nombre_empleado, v.apellido_empleado, COUNT(*) AS total_ventas
            FROM vista_ventas v
            JOIN empleado e ON v.ID_empleado = e.ID_empleado
            GROUP BY v.ID_empleado, e.foto_empleado, v.nombre_empleado, v.apellido_empleado
            ORDER BY total_ventas DESC 
            LIMIT 1;";
$result1 = mysqli_query($conn, $query1);
$vendedor_top = mysqli_fetch_assoc($result1);

// Consulta para la última venta realizada y el nombre del cliente
$query2 = "SELECT v.ID_venta, c.nombre, c.apellido, v.fecha_venta
            FROM cliente c
            JOIN ventas v ON c.ID_cliente = v.ID_cliente
            WHERE v.fecha_venta = (SELECT MAX(fecha_venta) FROM ventas);";
$result2 = mysqli_query($conn, $query2);
$ultima_venta = mysqli_fetch_assoc($result2);

// Consulta para el contador de ventas "Pendiente"
$query3 = "SELECT COUNT(*) AS total_pendientes FROM ventas WHERE Estado_Venta = 'Pendiente'";
$result3 = mysqli_query($conn, $query3);
$pendientes = mysqli_fetch_assoc($result3);

// Consulta para el contador de servicios "En proceso"
$query4 = "SELECT COUNT(*) AS total_en_proceso FROM servicio WHERE estado_servicio = 'En proceso'";
$result4 = mysqli_query($conn, $query4);
$en_proceso = mysqli_fetch_assoc($result4);
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
                <li><a href="gerente_main.php">Menú</a></li>
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
                    <h1>Bienvenido, Gerente</h1>
                </div>
            </header>
            <div class="cards">
                <div class="card">
                    <h2>Vendedor con más ventas</h2>
                    <p>Nombre: <?php echo $vendedor_top['nombre_empleado']; ?> <?php echo $vendedor_top['apellido_empleado']; ?></p>
                    <p>Total Ventas: <?php echo $vendedor_top['total_ventas']; ?></p>
                    <img src="<?php echo $vendedor_top['foto_empleado']; ?>" class="employee-photo">
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
</body>
</html>