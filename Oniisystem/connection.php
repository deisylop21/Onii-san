<?php

$user = 'root';
$password = '1234';
$db = 'oniisan_alvarezlopeznarvaez_a';
$host = 'localhost';
$port = 3307;

// Conexión a la base de datos
$link = mysqli_init();
$success = mysqli_real_connect(
    $link,
    $host,
    $user,
    $password,
    $db,
    $port
);

if (!$success) {
    die("Connection failed: " . mysqli_connect_error());
}

// Hacer la variable $link global para que esté disponible en otros archivos
$GLOBALS['link'] = $link;
?>
