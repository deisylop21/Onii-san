<?php
session_start();

if (!isset($_SESSION['username']) || !isset($_SESSION['puesto']) || !isset($_SESSION['ID_empleado']) || $_SESSION['puesto'] !== 'Vendedor') {
    header('Location: index.html');
    exit;
}

include('connection.php');

$link = $GLOBALS['link'];

$id_empleado = $_SESSION['ID_empleado'];

// Llave de encriptación (debe ser la misma utilizada para desencriptar)
$key = 'llave_simetrica_OniiSan';

function encrypt($data, $key) {
    $encryption_key = base64_decode($key);
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encrypted = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
    return base64_encode($encrypted . '::' . base64_encode($iv));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $telefono = encrypt($_POST['telefono'], $key);
    $correo = encrypt($_POST['correo'], $key);
    $direccion = encrypt($_POST['direccion'], $key);

    // Insertar datos del cliente
    $query = "INSERT INTO cliente (nombre, apellido, telefono, correo, direccion) VALUES (?, ?, ?, ?, ?)";
    
    if ($stmt = $link->prepare($query)) {
        $stmt->bind_param('sssss', $nombre, $apellido, $telefono, $correo, $direccion);
        if ($stmt->execute()) {
            $client_id = $stmt->insert_id;
            $_SESSION['ID_cliente'] = $client_id; // Guardar el ID del cliente en la sesión

            // Redirigir al formulario para agregar auto
            header("Location: agregar_venta.php");
            exit();
        } else {
            echo "Error al registrar el cliente: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error en la preparación del procedimiento: " . $link->error;
    }

    $link->close();
}
?>
