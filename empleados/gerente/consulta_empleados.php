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
            
            <!-- Cartas de empleados -->
            <div class="cards">
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="card">
                    <p>Nombre: <?php echo htmlspecialchars($row['nombre']); ?> <?php echo htmlspecialchars($row['apellido']); ?></p>
                    <p>Puesto: <?php echo htmlspecialchars($row['puesto']); ?></p>
                    <p>Turno: <?php echo htmlspecialchars($row['turno']); ?></p>
                    <img src="<?php echo htmlspecialchars($row['foto_empleado']); ?>" alt="Foto de <?php echo htmlspecialchars($row['nombre']); ?>" class="employee-photo">
                    <div class="card-buttons">
                        <form action="dar_de_baja.php" method="post" style="display:inline;" 
                            data-nombre="<?php echo htmlspecialchars($row['nombre']); ?>" 
                            data-apellido="<?php echo htmlspecialchars($row['apellido']); ?>"
                            onsubmit="return confirmDeletion(this);">
                            <input type="hidden" name="ID_empleado" class="btn-delete" value="<?php echo htmlspecialchars($row['ID_empleado']); ?>">
                            <button type="submit" class="btn-delete">Dar de Baja</button>
                        </form>
                        <form action="editar_empleado.php" method="get" style="display:inline;">
                            <input type="hidden" name="empleado_id" value="<?php echo htmlspecialchars($row['ID_empleado']); ?>">
                            <button type="submit" class="btn-edit">Editar</button>
                        </form>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</body>
<script>
    function confirmDeletion(form) {
        // Obtener el nombre y apellido del formulario
        var nombre = form.getAttribute('data-nombre');
        var apellido = form.getAttribute('data-apellido');

        // Mostrar el mensaje de confirmación
        var mensaje = "¿Seguro que quiere dar de baja a " + nombre + " " + apellido + "?";
        return confirm(mensaje);
    }
</script>
</html>
<?php
mysqli_free_result($result);
mysqli_close($conn);
?>