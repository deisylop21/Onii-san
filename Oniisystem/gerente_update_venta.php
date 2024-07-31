<?php
session_start();

if (!isset($_SESSION['username']) || !isset($_SESSION['puesto']) || !isset($_SESSION['ID_empleado']) || $_SESSION['puesto'] !== 'Gerente') {
    header('Location: index.html');
    exit;
}

include('connection.php');

$link = $GLOBALS['link'];

$id_empleado = $_SESSION['ID_empleado'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    var_dump($_POST); // Agrega esta línea para depurar

    $ID_venta = $_POST['ID_venta'] ?? '';
    $action = $_POST['action'] ?? '';

    if ($action == 'aprobar') {
        $stmt = $link->prepare("CALL aprobar_venta(?)");
        $successMessage = "Venta aprobada con éxito.";
        $errorMessage = "Error al aprobar la venta.";
    } elseif ($action == 'cancelar') {
        $stmt = $conn->prepare("CALL cancelar_venta(?)");
        $successMessage = "Venta cancelada con éxito.";
        $errorMessage = "Error al cancelar la venta.";
    } else {
        $message = "Acción no válida.";
    }

    if (!isset($message)) {
        $stmt->bind_param("i", $ID_venta);

        if ($stmt->execute()) {
            $message = $successMessage;
        } else {
            $message = $errorMessage . " " . $stmt->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Venta</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <nav class="nav">
            <ul>
                <li><a href="dashboard_gerente.php">Menú</a></li>
                <li><a href="gerente_empleados.php">Empleados</a></li>
                <li><a href="gerente_coches.php">Coches</a></li>
                <li><a href="gerente_ventas.php">Ventas</a></li>
            </ul>
        </nav>
        <div class="main-content">
            <header>
                <div class="logo">
                    <img src="logo.png" alt="Logo Empresa">
                </div>
                <div id="date-time" class="date-time"></div>
                <div class="welcome-message">
                    <h1>Ventas</h1>
                </div>
            </header>
            <h1>Resultado de la Acción</h1>
            <div class="message">
                <?php
                if ($message) {
                    echo "<p>$message</p>";
                } else {
                    echo "<p>No se ha realizado ninguna acción.</p>";
                }
                ?>
                <a href="gerente_ventas.php">Volver a Ventas Pendientes</a>
            </div>
        </div>
    </div>
</body>
</html>