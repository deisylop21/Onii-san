<?php
session_start();

if (!isset($_SESSION['username']) || !isset($_SESSION['puesto']) || !isset($_SESSION['ID_empleado']) || $_SESSION['puesto'] !== 'Gerente') {
    header('Location: index.html');
    exit;
}

include('connection.php');

$link = $GLOBALS['link'];

$id_empleado = $_SESSION['ID_empleado'];

$disponibilidad = $_GET['disponibilidad'];

$query = "SELECT Numero_serie, estado, modelo, año, precio_base, costo, imagen_auto FROM auto WHERE disponibilidad = '$disponibilidad'";
$result = mysqli_query($link, $query);

if (!$result) {
    die('Consulta fallida: ' . mysqli_error($link));
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel administrativo</title>
    <link rel="stylesheet" href="styles.css">
</head>
<script>
        // Script para mostrar la fecha y hora actual
        function updateDateTime() {
            const now = new Date();
            const dateTimeString = now.toLocaleString('es-ES', { dateStyle: 'full', timeStyle: 'medium' });
            document.getElementById('date-time').innerText = dateTimeString;
        }
        setInterval(updateDateTime, 1000); // Actualizar cada segundo
    </script>
<body>
    <div class="container">
        <!-- Lateral Navigation -->
        <nav class="nav">
            <ul>
                <li><a href="dashboard_gerente.php">Menú</a></li>
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
                    <h1>Coches: <?php echo htmlspecialchars($disponibilidad); ?></h1>
                </div>
            </header>
            
            <!-- Cartas de empleados -->
            <div class="cards">
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="card">
                    <p>Modelo: <?php echo htmlspecialchars($row['modelo']); ?></p>
                    <p>Año: <?php echo htmlspecialchars($row['año']); ?></p>
                    <p>Costo: <?php echo htmlspecialchars($row['costo']); ?></p>
                    <p>Precio base: <?php echo htmlspecialchars($row['precio_base']); ?></p>
                    <img src="<?php echo htmlspecialchars($row['imagen_auto']); ?>" alt="Foto de <?php echo htmlspecialchars($row['modelo']); ?>">
                    <div class="card-buttons">
                        <form action="edit_coche.php" method="get" style="display:inline;">
                            <input type="hidden" name="Numero_serie" value="<?php echo htmlspecialchars($row['Numero_serie']); ?>">
                            <button type="submit" class="btn-edit">Editar</button>
                        </form>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</body>
</html>
<?php
mysqli_free_result($result);
mysqli_close($link);
?>