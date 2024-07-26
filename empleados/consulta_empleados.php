<?php
include('connection.php');

$puesto = $_GET['puesto'];

$query = "SELECT * FROM vista_empleados WHERE puesto = '$puesto'";
$result = mysqli_query($conn, $query);

if (!$result) {
    die('Consulta fallida: ' . mysqli_error($conn));
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
                    <h1>Empleados: <?php echo htmlspecialchars($puesto); ?></h1>
                </div>
            </header>
            
            <!-- Tabla de Empleados -->
            <table class="table">
                    <tr>
                        <th>foto del empleado</th>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Puesto</th>
                        <th>turno</th>
                    </tr>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['foto_empleado']); ?></td>
                        <td><?php echo htmlspecialchars($row['ID_empleado']); ?></td>
                        <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($row['apellido']); ?></td>
                        <td><?php echo htmlspecialchars($row['puesto']); ?></td>
                        <td><?php echo htmlspecialchars($row['turno']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </div>
</body>
</html>
<?php
mysqli_free_result($result);
mysqli_close($conn);
?>