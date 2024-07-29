<?php
include('connection.php');
$link = $GLOBALS['link'];

// Obtener los datos del formulario
$id_empleado = isset($_POST['ID_empleado']) ? intval($_POST['ID_empleado']) : 0;
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$ciudad = $_POST['ciudad'];
$fecha_contrato = $_POST['fecha_contrato'];
$puesto = $_POST['puesto'];
$turno = $_POST['turno'];
$sueldo_base = $_POST['sueldo_base'];
$descuentos = $_POST['descuentos'];
$comision = $_POST['comision'];
$prestaciones = $_POST['prestaciones'];
$capacitacion = $_POST['capacitacion'];
$prestamos = $_POST['prestamos'];
$foto_empleado = $_FILES['foto_empleado']['name'];

// Subir la foto si se ha seleccionado una
if ($_FILES['foto_empleado']['error'] == UPLOAD_ERR_OK) {
    $upload_dir = 'uploads/';
    $upload_file = $upload_dir . basename($_FILES['foto_empleado']['name']);
    move_uploaded_file($_FILES['foto_empleado']['tmp_name'], $upload_file);
} else {
    // Si no se subió una foto nueva, mantener la anterior
    $upload_file = $_POST['foto_empleado_hidden'];
}

// Consultar y actualizar el empleado
$query = "UPDATE empleado SET nombre = ?, apellido = ?, ciudad = ?, codigo_postal = ?, fecha_contrato = ?, puesto = ?, turno = ?, sueldo_base = ?, descuentos = ?, comision = ?, prestaciones = ?, capacitacion = ?, prestamos = ?, foto_empleado = ? WHERE ID_empleado = ?";
$stmt = $link->prepare($query);
$stmt->bind_param("ssssssssdddsdsi", $nombre, $apellido, $ciudad, $codigo_postal, $fecha_contrato, $puesto, $turno, $sueldo_base, $descuentos, $comision, $prestaciones, $capacitacion, $prestamos, $upload_file, $id_empleado);

if ($stmt->execute()) {
    $success = true;
    $message = "Empleado agregado exitosamente.";
} else {
    $success = false;
    $message = "Error: " . mysqli_error($link);
}

$stmt->close();
$link->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Auto</title>
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
                    <h1>Agregar Auto</h1>
                </div>
            </header>

            <!-- Formulario de Agregar Auto -->
            <main>
        <?php if ($success): ?>
            <div class="mensaje-exito">
                <h1><?php echo $message; ?></h1>
                <a href="gerente_empleados.php">Consultar empleados</a>
            </div>
        <?php else: ?>
            <div class="mensaje-error">
                <h1><?php echo $message; ?></h1>
                <a href="add_empleado.php">Intentar de nuevo</a>
            </div>
        <?php endif; ?>
    </main>
        </div>
    </div>
</body>
</html>
