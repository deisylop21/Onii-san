<?php
include('connection.php');
$link = $GLOBALS['link'];

// Obtener los datos del formulario
$id_empleado = intval($_POST['id_empleado']);
$nombre = mysqli_real_escape_string($link, $_POST['nombre']);
$apellido = mysqli_real_escape_string($link, $_POST['apellido']);
$telefono = mysqli_real_escape_string($link, $_POST['telefono']);
$correo = mysqli_real_escape_string($link, $_POST['correo']);
$direccion = mysqli_real_escape_string($link, $_POST['direccion']);
$ciudad = mysqli_real_escape_string($link, $_POST['ciudad']);
$codigo_postal = mysqli_real_escape_string($link, $_POST['codigo_postal']);
$fecha_contrato = mysqli_real_escape_string($link, $_POST['fecha_contrato']);
$numero_seguro = mysqli_real_escape_string($link, $_POST['numero_seguro']);
$puesto = mysqli_real_escape_string($link, $_POST['puesto']);
$turno = mysqli_real_escape_string($link, $_POST['turno']);
$numero_cuenta = mysqli_real_escape_string($link, $_POST['numero_cuenta']);
$sueldo_base = floatval($_POST['sueldo_base']);
$descuentos = floatval($_POST['descuentos']);
$comision = floatval($_POST['comision']);
$prestaciones = mysqli_real_escape_string($link, $_POST['prestaciones']);
$capacitacion = mysqli_real_escape_string($link, $_POST['capacitacion']);
$prestamos = floatval($_POST['prestamos']);

// Manejar la subida de la imagen
$target_dir = "uploads/";
$foto_empleado = $_FILES["foto_empleado"]["name"];
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($foto_empleado, PATHINFO_EXTENSION));
$target_file = $target_dir . basename($foto_empleado);

// Comprobar si el archivo es una imagen real
$check = getimagesize($_FILES["foto_empleado"]["tmp_name"]);
if ($check !== false) {
    $uploadOk = 1;
} else {
    $uploadOk = 0;
}

// Comprobar si el archivo ya existe
if (file_exists($target_file)) {
    $uploadOk = 0;
}

// Limitar el tamaño del archivo (por ejemplo, 5MB)
if ($_FILES["foto_empleado"]["size"] > 5000000) {
    $uploadOk = 0;
}

// Permitir solo ciertos formatos de archivo
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif") {
    $uploadOk = 0;
}

// Comprobar si $uploadOk es 0 debido a un error
if ($uploadOk == 0) {
    // No subimos nueva imagen
    $query = "CALL update_empleado(
        '$id_empleado', '$nombre', '$apellido', '$telefono', '$correo', '$direccion', '$ciudad', 
        '$codigo_postal', '$fecha_contrato', '$numero_seguro', '$puesto', '$turno', '$numero_cuenta', 
        '$sueldo_base', '$descuentos', '$comision', '$prestaciones', '$capacitacion', '$prestamos', NULL
    )";
} else {
    if (move_uploaded_file($_FILES["foto_empleado"]["tmp_name"], $target_file)) {
        // Consulta para llamar al procedimiento almacenado con imagen
        $query = "CALL update_empleado(
            '$id_empleado', '$nombre', '$apellido', '$telefono', '$correo', '$direccion', '$ciudad', 
            '$codigo_postal', '$fecha_contrato', '$numero_seguro', '$puesto', '$turno', '$numero_cuenta', 
            '$sueldo_base', '$descuentos', '$comision', '$prestaciones', '$capacitacion', '$prestamos', '$target_file'
        )";
    } else {
        $query = "CALL update_empleado(
            '$id_empleado', '$nombre', '$apellido', '$telefono', '$correo', '$direccion', '$ciudad', 
            '$codigo_postal', '$fecha_contrato', '$numero_seguro', '$puesto', '$turno', '$numero_cuenta', 
            '$sueldo_base', '$descuentos', '$comision', '$prestaciones', '$capacitacion', '$prestamos', NULL
        )";
    }
}

// Ejecutar la consulta
if (mysqli_query($link, $query)) {
    $success = true;
    $message = "Empleado actualizado exitosamente.";
} else {
    $success = false;
    $message = "Error: " . mysqli_error($link);
}

// Cerrar la conexión
mysqli_close($link);

header("Location: gerente_empleados.php?success=$success&message=$message");
?>
