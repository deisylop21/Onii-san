<?php
include('connection.php');

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
$foto_empleado = $_POST['foto_empleado'];

$query = "CALL add_empleado(
    '$nombre', '$apellido', '$telefono', '$correo', '$direccion', '$ciudad', '$codigo_postal', 
    '$fecha_contrato', '$numero_seguro', '$puesto', '$turno', '$numero_cuenta', 
    '$sueldo_base', '$descuentos', '$comision', '$prestaciones', '$capacitacion', 
    '$prestamos', '$foto_empleado'
)";

if (mysqli_query($conn, $query)) {
    echo "Empleado agregado exitosamente.";
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
