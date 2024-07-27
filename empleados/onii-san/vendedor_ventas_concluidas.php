<?php
include('connection.php');
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventas Concluidas</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        function updateDateTime() {
            const now = new Date();
            const dateTimeString = now.toLocaleString('es-ES', { dateStyle: 'full', timeStyle: 'medium' });
            document.getElementById('date-time').innerText = dateTimeString;
        }
        setInterval(updateDateTime, 1000);
    </script>
</head>
<body>
    <div class="container">
        <nav class="nav">
            <ul>
                <li><a href="vendedor_main.php">Menú</a></li>
                <li><a href="vendedor_ventas.php">Ventas</a></li>
                <li><a href="vendedor_servicios.php">Servicios</a></li>
                <li class="profile-button"><a href="perfil_gerente.php">Perfil</a></li>
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
            <h1>Ventas Concluidas</h1>
            <table>
                <tr>
                    <th>ID Venta</th>
                    <th>Cliente</th>
                    <th>Empleado</th>
                    <th>Número de Serie</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Año</th>
                    <th>Color</th>
                    <th>Tipo de Seguro</th>
                    <th>Fecha de Venta</th>
                </tr>
                <?php
                $query = "SELECT * FROM vista_ventas where ID_venta in (SELECT ID_venta FROM ventas WHERE Estado_Venta = 'Concluidas') ORDER BY ID_venta ASC;";
                $result = $conn->query($query);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['ID_venta']}</td>
                                <td>{$row['nombre_cliente']} {$row['apellido_cliente']}</td>
                                <td>{$row['nombre_empleado']} {$row['apellido_empleado']}</td>
                                <td>{$row['Numero_serie']}</td>
                                <td>{$row['marca']}</td>
                                <td>{$row['modelo']}</td>
                                <td>{$row['año']}</td>
                                <td>{$row['color']}</td>
                                <td>{$row['tipo_seguro']}</td>
                                <td>{$row['fecha_venta']}</td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='10'>No hay ventas concluidas.</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>
</body>
</html>