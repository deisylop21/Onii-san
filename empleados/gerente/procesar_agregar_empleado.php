<?php
include('connection.php');

// Recibir datos del formulario
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$telefono = $_POST['telefono'];
$correo = $_POST['correo'];
$direccion = $_POST['direccion'];
$ciudad = $_POST['ciudad'];
$codigo_postal = $_POST['codigo_postal'];
$fecha_contrato = $_POST['fecha_contrato'];
$numero_seguro = $_POST['numero_seguro'];
$puesto = $_POST['puesto'];
$turno = $_POST['turno'];
$numero_cuenta = $_POST['numero_cuenta'];
$sueldo_base = $_POST['sueldo_base'];
$descuentos = $_POST['descuentos'];
$comision = $_POST['comision'];
$prestaciones = $_POST['prestaciones'];
$capacitacion = $_POST['capacitacion'];
$prestamos = $_POST['prestamos'];

// Manejar la subida de la imagen
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["foto_empleado"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Comprobar si el archivo es una imagen real
$check = getimagesize($_FILES["foto_empleado"]["tmp_name"]);
if ($check !== false) {
    $uploadOk = 1;
} else {
    $message = "El archivo no es una imagen.";
    $uploadOk = 0;
}

// Comprobar si el archivo ya existe
if (file_exists($target_file)) {
    $message = "El archivo ya existe.";
    $uploadOk = 0;
}

// Limitar el tamaño del archivo (por ejemplo, 5MB)
if ($_FILES["foto_empleado"]["size"] > 5000000) {
    $message = "El archivo es demasiado grande.";
    $uploadOk = 0;
}

// Permitir solo ciertos formatos de archivo
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif") {
    $message = "Solo se permiten archivos JPG, JPEG, PNG y GIF.";
    $uploadOk = 0;
}

// Comprobar si $uploadOk es 0 debido a un error
if ($uploadOk == 0) {
    $success = false;
} else {
    if (move_uploaded_file($_FILES["foto_empleado"]["tmp_name"], $target_file)) {
        $foto_empleado = $target_file; // Ruta de la imagen

        // Consulta para llamar al procedimiento almacenado
        $query = "CALL add_empleado(
            '$nombre', '$apellido', '$telefono', '$correo', '$direccion', '$ciudad', '$codigo_postal', 
            '$fecha_contrato', '$numero_seguro', '$puesto', '$turno', '$numero_cuenta', 
            '$sueldo_base', '$descuentos', '$comision', '$prestaciones', '$capacitacion', 
            '$prestamos', '$foto_empleado'
        )";

        if (mysqli_query($conn, $query)) {
            $success = true;
            $message = "Empleado agregado exitosamente.";
        } else {
            $success = false;
            $message = "Error: " . mysqli_error($conn);
        }
    } else {
        $success = false;
        $message = "Lo sentimos, hubo un error subiendo tu archivo.";
    }
}

// Cerrar la conexión
mysqli_close($conn);
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
                    <h1>Agregar Empleado</h1>
                </div>
            </header>

            <!-- Formulario de Agregar Empleado -->
            <main>
        <?php if ($success): ?>
            <div class="mensaje-exito">
                <h1><?php echo $message; ?></h1>
                <a href="empleados.php">Consultar empleados</a>
            </div>
        <?php else: ?>
            <div class="mensaje-error">
                <h1><?php echo $message; ?></h1>
                <a href="agregar_empleado.php">Intentar de nuevo</a>
            </div>
        <?php endif; ?>
    </main>
        </div>
    </div>
</body>
</html>