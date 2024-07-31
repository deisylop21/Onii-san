<?php
session_start();
include("connection.php");

// Obtener los datos del formulario
$username = $_POST['username'];
$password = $_POST['password'];

// Clave de desencriptación
$key = 'llave_simetrica_OniiSan';

// Conectar a la base de datos
$link = mysqli_init();
if (!$link) {
    die("Falló la inicialización de MySQLi.");
}

if (!mysqli_real_connect($link, 'localhost', 'root', '1234', 'oniisan_alvarezlopeznarvaez_a', 3307)) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// Preparar y ejecutar la consulta para obtener el username y password encriptados
$query = "SELECT username, password, puesto, ID_empleado FROM accounts WHERE AES_DECRYPT(username, ?) = ?";
$stmt = mysqli_prepare($link, $query);
mysqli_stmt_bind_param($stmt, "ss", $key, $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    $encrypted_password = $row['password'];
    $puesto = $row['puesto'];
    $id_empleado = $row['ID_empleado'];
    
    // Desencriptar la contraseña
    $query_decrypt_pass = "SELECT desencriptar_password(?) AS decrypted_password";
    $stmt_decrypt_pass = mysqli_prepare($link, $query_decrypt_pass);
    mysqli_stmt_bind_param($stmt_decrypt_pass, "s", $encrypted_password);
    mysqli_stmt_execute($stmt_decrypt_pass);
    $result_decrypt_pass = mysqli_stmt_get_result($stmt_decrypt_pass);

    if ($row_decrypt_pass = mysqli_fetch_assoc($result_decrypt_pass)) {
        $decrypted_password = $row_decrypt_pass['decrypted_password'];

        // Comparar la contraseña desencriptada con la ingresada
        if ($password === $decrypted_password) {
            // Inicio de sesión exitoso
            $_SESSION['username'] = $username;
            $_SESSION['puesto'] = $puesto;
            $_SESSION['ID_empleado'] = $id_empleado; // Almacenar ID_empleado en la sesión
            
            // Redirigir según el puesto
            switch ($puesto) {
                case 'Gerente':
                    header("Location: dashboard_gerente.php");
                    break;
                case 'Vendedor':
                    header("Location: dashboard_vendedor.php");
                    break;
                case 'Asesor':
                    header("Location: dashboard_asesor.php");
                    break;
                case 'Mecanico':
                    header("Location: dashboard_mecanico.php");
                    break;
                default:
                    header("Location: index.html?error=puesto_desconocido");
                    break;
            }
            exit();
        } else {
            // Contraseña incorrecta
            header("Location: index.html?error=contraseña_incorrecta");
            exit();
        }
    } else {
        // Error al desencriptar la contraseña
        header("Location: index.html?error=error_desencriptar_contrasena");
        exit();
    }
} else {
    // Nombre de usuario incorrecto o no encontrado
    header("Location: index.html?error=usuario_incorrecto");
    exit();
}

// Cerrar la conexión
mysqli_close($link);
?>
