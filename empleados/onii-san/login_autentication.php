<?php
include('connection.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];

    // Consulta para obtener el rol y ID del empleado basándose solo en el username
    $query = "SELECT 
                e.ID_empleado,
                a.rol
              FROM 
                empleado e
              JOIN 
                accounts a ON e.correo = a.email
              WHERE 
                a.username = ?";

    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($db_id_empleado, $db_role);
            $stmt->fetch();

            // Almacenar el ID del empleado en la sesión si es vendedor o mecánico
            if ($db_role == 'Vendedor' || $db_role == 'Mecánico') {
                $_SESSION['ID_empleado'] = $db_id_empleado;
            }

            // Cerrar la conexión de administrador
            $stmt->close();
            $conn->close();

            // Redirigir a diferentes páginas basadas en el rol
            switch ($db_role) {
                case 'Gerente':
                    header('Location: http://localhost/onii-san/gerente_main.php');
                    break;
                case 'Vendedor':
                    header('Location: http://localhost/onii-san/vendedor_main.php');
                    break;
                case 'Maestro de carros':
                    header('Location: http://localhost/onii-san/asesor_main.php');
                    break;
                case 'Mecánico':
                    header('Location: http://localhost/onii-san/mecanico_main.php');
                    break;
                default:
                    header('Location: /pagina_default.php');
                    break;
            }
            exit();
        } else {
            echo "Usuario no encontrado.";
        }

        $stmt->close();
    }

    $conn->close();
}
?>
