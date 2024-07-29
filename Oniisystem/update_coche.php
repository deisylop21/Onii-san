<?php
include('connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos del formulario
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
    
    // Manejo de imagen
    $imagen_auto = $_FILES['imagen_auto']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($imagen_auto);
    
    if (!empty($imagen_auto)) {
        // Verificar si el archivo ya existe
        if (file_exists($target_file)) {
            $success = false;
            $message = "Lo sentimos, hubo un error subiendo tu archivo.";
        }

        // Verificar el tamaño del archivo (limitar a 5 MB)
        if ($_FILES['imagen_auto']['size'] > 5000000) {
            echo "El archivo es demasiado grande.";
            exit;
        }

        // Verificar el tipo de archivo
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
        if (!in_array($imageFileType, $allowed_types)) {
            echo "Solo se permiten imágenes JPG, JPEG, PNG y GIF.";
            exit;
        }

        // Mover el archivo al directorio de destino
        if (!move_uploaded_file($_FILES['imagen_auto']['tmp_name'], $target_file)) {
            echo "Hubo un error al subir el archivo.";
            exit;
        }
    } else {
        // Si no se sube una nueva imagen, usar la imagen existente
        $query = "SELECT imagen_auto FROM auto WHERE Numero_serie = ?";
        $stmt = $link->prepare($query);
        $stmt->bind_param("s", $numero_serie);
        $stmt->execute();
        $result = $stmt->get_result();
        $coche = $result->fetch_assoc();
        $imagen_auto = $coche['imagen_auto'];
    }

    // Actualizar el coche en la base de datos
    $query = "UPDATE auto SET estado = ?, marca = ?, modelo = ?, año = ?, cilindros = ?, disponibilidad = ?, precio_base = ?, costo = ?, cantidad_puertas = ?, color = ?, imagen_auto = ? WHERE Numero_serie = ?";
    $stmt = $link->prepare($query);
    $stmt->bind_param('ssssssssssss', $estado, $marca, $modelo, $año, $cilindros, $disponibilidad, $precio_base, $costo, $cantidad_puertas, $color, $imagen_auto, $numero_serie);

    if ($stmt->execute()) {
        $success = true;
        $message = "Empleado agregado exitosamente.";
    } else {
        $success = false;
        $message = "Error: " . mysqli_error($link);
    }

    $stmt->close();
    $link->close();
}
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
                <a href="gerente_coches.php">Consultar autos</a>
            </div>
        <?php else: ?>
            <div class="mensaje-error">
                <h1><?php echo $message; ?></h1>
                <a href="add_coche.php">Intentar de nuevo</a>
            </div>
        <?php endif; ?>
    </main>
        </div>
    </div>
</body>
</html>
