<?php
session_start();
require_once 'connection.php';

// Recibir los datos del formulario
$username = $_POST['username'];
$password = $_POST['password'];

// Preparar la consulta para desencriptar y verificar la contraseña
$sql = "SELECT id, username, email, puesto, AES_DECRYPT(password, 'llave_simetrica_OniiSan') AS decrypted_password FROM accounts WHERE username = ?";

if ($stmt = $link->prepare($sql)) {
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $db_username, $email, $puesto, $decrypted_password);
    $stmt->fetch();

    if ($stmt->num_rows > 0) {
        // Verificar la contraseña
        if ($password === $decrypted_password) {
            // La contraseña es correcta, iniciar sesión
            $_SESSION['loggedin'] = true;
            $_SESSION['id'] = $id;
            $_SESSION['username'] = $db_username;
            $_SESSION['email'] = $email;
            $_SESSION['puesto'] = $puesto;

            // Redirigir a la página correspondiente según el puesto
            switch ($puesto) {
                case 'Gerente':
                    header("location: dashboard_gerente.php");
                    break;
                case 'Vendedor':
                    header("location: dashboard_vendedor.php");
                    break;
                case 'Asesor':
                    header("location: dashboard_asesor.php");
                    break;
                case 'Mecanico':
                    header("location: dashboard_mecanico.php");
                    break;
                default:
                    // Si el puesto no coincide con ninguno de los casos, redirigir a una página por defecto
                    header("location: dashboard.php");
                    break;
            }
            exit(); // Asegurarse de que no se ejecute más código después de la redirección
        } else {
            // La contraseña es incorrecta
            echo "La contraseña es incorrecta.";
        }
    } else {
        // El usuario no existe
        echo "No se encontró una cuenta con ese nombre de usuario.";
    }

    $stmt->close();
} else {
    echo "Error en la consulta: " . $link->error;
}

$link->close();
?>
