<?php
include('connection.php');
session_start(); // Iniciar la sesión al principio del archivoc

$sql = "SELECT Numero_serie FROM auto WHERE disponibilidad = 'Disponible'";
$result = $conn->query($sql);

// Array para almacenar los números de serie
$numero_series = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $numero_series[] = $row['Numero_serie'];
    }
}

// Devolver los números de serie en formato JSON
echo json_encode($numero_series);
?>