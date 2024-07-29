<?php
session_start();

// Verificar si el usuario ha iniciado sesión y el puesto
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.html');
    exit;
}

// Conectar a la base de datos
include('connection.php');

// Obtener el puesto del usuario
$puesto = $_SESSION['puesto'];

if ($puesto == 'Gerente') {
    // Mostrar la vista de empleados para el gerente
    $query = "SELECT * FROM vista_empleados";
    $result = mysqli_query($GLOBALS['link'], $query);

    if (mysqli_num_rows($result) > 0) {
        echo "<h1>Lista de Empleados</h1>";
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Nombre</th><th>Foto empleado</th><th>Puesto</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['ID_empleado'] . "</td>";
            echo "<td>" . $row['nombre'] . "</td>";
            echo "<td><img src='uploads/" . $row['foto_empleado'] . "' alt='Foto Empleado' width='50' height='50'></td>";
            echo "<td>" . $row['puesto'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No hay empleados en la base de datos.";
    }
} else {
    // Mostrar un mensaje para otros puestos
    echo "<h1>Bienvenido, " . $_SESSION['username'] . "</h1>";
    echo "<p>Tu puesto es: " . $puesto . "</p>";
}

mysqli_close($GLOBALS['link']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
    <h1>Bienvenido usuario</h1>
    <a href="logout.php" style="color:black;"><i class="fas fa-sign-out-alt"></i>Cerrar Sesión</a>

</html>
