<?php
session_start();

if (!isset($_SESSION['username']) || !isset($_SESSION['puesto']) || !isset($_SESSION['ID_empleado']) || $_SESSION['puesto'] !== 'Vendedor') {
    header('Location: index.html');
    exit;
}

include('connection.php');

$link = $GLOBALS['link'];

$id_empleado = $_SESSION['ID_empleado'];

$query1 = "SELECT c.nombre, c.apellido, MAX(v.precio_total) AS max_total FROM cliente c
            JOIN ventas v ON c.ID_cliente = v.ID_cliente
            WHERE v.ID_empleado = ? AND MONTH(v.fecha_venta) = MONTH(CURRENT_DATE()) AND YEAR(v.fecha_venta) = YEAR(CURRENT_DATE()) AND v.Estado_Venta = 'Aprobado'
            GROUP BY c.nombre, c.apellido
            ORDER BY max_total DESC
            LIMIT 1;";
$stmt1 = $link->prepare($query1);
$stmt1->bind_param("i", $id_empleado);
$stmt1->execute();
$result1 = $stmt1->get_result();
$cliente_top = $result1->fetch_assoc();

// Consulta para las ventas pendientes del vendedor actual
$query2 = "
    SELECT COUNT(*) AS total_pendientes 
    FROM ventas 
    WHERE Estado_Venta = 'Pendiente' AND ID_empleado = ?;
";
$stmt2 = $link->prepare($query2);
$stmt2->bind_param("i", $id_empleado);
$stmt2->execute();
$result2 = $stmt2->get_result();
$pendientes = $result2->fetch_assoc();

// Consulta para el número de ventas concluidas en el mes actual para el vendedor actual
$query3 = "
    SELECT COUNT(*) AS total_concluidas 
    FROM ventas 
    WHERE Estado_Venta = 'Aprobado' AND ID_empleado = ? AND MONTH(fecha_venta) = MONTH(CURRENT_DATE()) AND YEAR(fecha_venta) = YEAR(CURRENT_DATE());
";
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
                    <h1>Bienvenido, Vendedor</h1>
                </div>
            </header>
            <div class="cards">
                <div class="card">
                    <h2>Venta mas cara del mes</h2>
                    <p>Nombre: <?php echo $cliente_top['nombre']; ?> <?php echo $cliente_top['apellido']; ?></p>
                    <p>Precio: <?php echo $cliente_top ['max_total'];?></p>
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