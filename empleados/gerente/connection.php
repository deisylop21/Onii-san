<?php
// Establecer la conexión con la base de datos
$admin_host = 'localhost';
$admin_user = 'root';
$admin_password = '';
$admin_db = 'oniisan_alvarezlopeznarvaez_a';

$conn = new mysqli($admin_host, $admin_user, $admin_password, $admin_db);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
