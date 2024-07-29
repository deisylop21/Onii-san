<?php
include('connection.php');
$link = $GLOBALS['link'];

// Inicializa las variables para los mensajes y el estado de la operación
$success = false;
$message = '';

if (isset($_POST['ID_empleado'])) {
    $ID = $_POST['ID_empleado'];

    // Prepara la llamada al procedimiento almacenado
    $query = "CALL dar_de_baja_empleado('$ID')";

    // Ejecuta la consulta
    if (mysqli_query($link, $query)) {
        $success = true;
        $message = 'Empleado dado de baja exitosamente.';
    } else {
        $success = false;
        $message = 'Error al dar de baja al empleado: ' . mysqli_error($link);
    }

    // Cierra la conexión
    mysqli_close($link);
}
?>

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

            <!-- Mensaje de éxito o error -->
            <main>
                <?php if ($success): ?>
                    <div class="mensaje-exito">
                        <h1><?php echo htmlspecialchars($message); ?></h1>
                        <a href="gerente_empleados.php">Consultar empleados</a>
                    </div>
                <?php else: ?>
                    <div class="mensaje-error">
                        <h1><?php echo htmlspecialchars($message); ?></h1>
                        <a href="gerente_empleados.php">Intentar de nuevo</a>
                    </div>
                <?php endif; ?>
            </main>
        </div>
    </div>
</body>
</html>
