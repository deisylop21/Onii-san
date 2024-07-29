<?php
include('connection.php');
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventas Pendientes</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        function updateDateTime() {
            const now = new Date();
            const dateTimeString = now.toLocaleString('es-ES', { dateStyle: 'full', timeStyle: 'medium' });
            document.getElementById('date-time').innerText = dateTimeString;
        }
        setInterval(updateDateTime, 1000);

        function confirmAction(id_venta, action) {
            let message = '';
            if (action === 'aprobar') {
                message = `¿Seguro de confirmar la venta con el ID ${id_venta}?`;
            } else if (action === 'cancelar') {
                message = `¿Seguro de cancelar la venta con el ID ${id_venta}?`;
            }
            return confirm(message);
        }
    </script>
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
            <h1>Ventas Pendientes, esperando confirmación</h1>
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
                    <th>Acciones</th>
                </tr>
                <?php
                $query = "SELECT * FROM vista_ventas WHERE ID_venta IN (SELECT ID_venta FROM ventas WHERE Estado_Venta = 'Pendiente') ORDER BY ID_venta ASC;";
                $result = $link->query($query);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $ID_venta = $row['ID_venta'];
                        $nombre_cliente = htmlspecialchars($row['nombre_cliente']);
                        $apellido_cliente = htmlspecialchars($row['apellido_cliente']);
                        $nombre_empleado = htmlspecialchars($row['nombre_empleado']);
                        $apellido_empleado = htmlspecialchars($row['apellido_empleado']);
                        $numero_serie = htmlspecialchars($row['Numero_serie']);
                        $marca = htmlspecialchars($row['marca']);
                        $modelo = htmlspecialchars($row['modelo']);
                        $año = htmlspecialchars($row['año']);
                        $color = htmlspecialchars($row['color']);
                        $tipo_seguro = htmlspecialchars($row['tipo_seguro']);
                        $fecha_venta = htmlspecialchars($row['fecha_venta']);
                    
                        echo "<tr>
                                <td>{$ID_venta}</td>
                                <td>{$nombre_cliente} {$apellido_cliente}</td>
                                <td>{$nombre_empleado} {$apellido_empleado}</td>
                                <td>{$numero_serie}</td>
                                <td>{$marca}</td>
                                <td>{$modelo}</td>
                                <td>{$año}</td>
                                <td>{$color}</td>
                                <td>{$tipo_seguro}</td>
                                <td>{$fecha_venta}</td>
                                <td>
                                    <form action='gerente_update_venta.php' method='POST' style='display:inline;'>
                                        <input type='hidden' name='ID_venta' value='{$ID_venta}'>
                                        <button type='submit' name='action' value='aprobar' onclick='return confirmAction({$ID_venta}, \"aprobar\")'>Aprobar</button>
                                    </form>
                                    <form action='gerente_update_venta.php' method='POST' style='display:inline;'>
                                        <input type='hidden' name='ID_venta' value='{$ID_venta}'>
                                        <button type='submit' name='action' value='cancelar' onclick='return confirmAction({$ID_venta}, \"cancelar\")'>Cancelar</button>
                                    </form>
                                </td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='11'>No hay ventas pendientes.</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>
</body>
</html>