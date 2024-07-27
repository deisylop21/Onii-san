<?php
include('connection.php');

// Recibir datos del formulario
$numero_serie = $_POST['numero_serie'];
$estado = $_POST['estado'];
$marca = $_POST['marca'];
$modelo = $_POST['modelo'];
$año = $_POST['año'];
$cilindros = $_POST['cilindros'];
$disponibilidad = $_POST['disponibilidad'];
$precio_base = $_POST['precio_base'];
$costo = $_POST['costo'];
$cantidad_puertas = $_POST['cantidad_puertas'];
$color = $_POST['color'];

// Manejar la subida de la imagen
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["imagen_auto"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Comprobar si el archivo es una imagen real
$check = getimagesize($_FILES["imagen_auto"]["tmp_name"]);
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
if ($_FILES["imagen_auto"]["size"] > 5000000) {
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
    if (move_uploaded_file($_FILES["imagen_auto"]["tmp_name"], $target_file)) {
        $imagen_auto = $target_file; // Ruta de la imagen

        // Consulta para insertar datos en la tabla auto
        $query = "INSERT INTO auto (
            Numero_serie, estado, marca, modelo, año, cilindros, disponibilidad, 
            precio_base, costo, cantidad_puertas, color, imagen_auto
        ) VALUES (
            '$numero_serie', '$estado', '$marca', '$modelo', '$año', '$cilindros', '$disponibilidad', 
            '$precio_base', '$costo', '$cantidad_puertas', '$color', '$imagen_auto'
        )";

        if (mysqli_query($conn, $query)) {
            $success = true;
            $message = "Auto agregado exitosamente.";
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
                    <h1>Agregar Auto</h1>
                </div>
            </header>

            <!-- Formulario de Agregar Auto -->
            <main>
        <?php if ($success): ?>
            <div class="mensaje-exito">
                <h1><?php echo $message; ?></h1>
                <a href="coches.php">Consultar autos</a>
            </div>
        <?php else: ?>
            <div class="mensaje-error">
                <h1><?php echo $message; ?></h1>
                <a href="agregar_auto.php">Intentar de nuevo</a>
            </div>
        <?php endif; ?>
    </main>
        </div>
    </div>
</body>
</html>