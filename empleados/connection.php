<?php
//Conexión inicial a la DB
$admin_host = 'localhost';
$admin_user = 'root';
$admin_password = '';
$admin_db = 'oniisan_alvarezlopeznarvaez_a';

$conn = new mysqli($admin_host, $admin_user, $admin_password, $admin_db);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    //Llave para desencriptar los datos
    $key = 'llave_simetrica_OniiSan';

    //Consultamos el username y la contraseña del empleado
    $sql = "SELECT id, username, email, AES_DECRYPT(password, '$key') AS decrypted_password, Rol FROM accounts WHERE username = ?";
    
    //Enviamos los datos para que se registre a la DB
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($id, $db_username, $email, $decrypted_password, $db_role);
        $stmt->fetch();

        if ($stmt->num_rows > 0) {
            //Verificamos la cotraseña
            if ($password === $decrypted_password) {
                $stmt->close();
                $conn->close();

                //Enviamos al empleado a una página distinta según su rol en la base de datos
                switch ($db_role) {
                    case 'Gerente':
                        header('Location: /pagina_gerente.php');
                        break;
                    case 'Vendedor':
                        header('Location: /pagina_vendedor.php');
                        break;
                    case 'Asesor':
                        header('Location: /pagina_Asesor.php');
                        break;
                    case 'Mecánico':
                        header('Location: /pagina_mecanico.php');
                        break;
                    default:
                        header('Location: /pagina_default.php');
                        break;
                }
                exit();
            } else {
                echo "Contraseña incorrecta.";
            }
        } else {
            echo "Usuario no encontrado.";
        }

        $stmt->close();
    }

    $conn->close();
}
?>
