<?php
session_start();

if (!isset($_SESSION['username']) || !isset($_SESSION['puesto']) || !isset($_SESSION['ID_empleado']) || $_SESSION['puesto'] !== 'Vendedor') {
    header('Location: index.html');
    exit;
}

include('connection.php');

$link = $GLOBALS['link'];

$id_empleado = $_SESSION['ID_empleado'];
// Consultar los números de serie disponibles
$numero_serie_options = '';
$query = "SELECT Numero_serie FROM auto";
$result = $link->query($query);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $numero_serie_options .= '<option value="' . htmlspecialchars($row['Numero_serie']) . '">' . htmlspecialchars($row['Numero_serie']) . '</option>';
    }
} else {
    echo "Error al obtener los números de serie: " . $link->error;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Venta</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        // Script para mostrar la fecha y hora actual
        function updateDateTime() {
            const now = new Date();
            const dateTimeString = now.toLocaleString('es-ES', { dateStyle: 'full', timeStyle: 'medium' });
            document.getElementById('date-time').innerText = dateTimeString;
        }
        setInterval(updateDateTime, 1000); // Actualizar cada segundo
    </script>
</head>
<body>
    <div class="container">
        <!-- Lateral Navigation -->
        <nav class="nav">
            <ul>
                <li><a href="dashboard_vendedor.php">Menú</a></li>
                <li><a href="vendedor_ventas.php">Ventas</a></li>
                <li><a href="vendedor_servicios.php">Servicios</a></li>
                <li class="profile-button"><a href="perfil_gerente.php">Perfil</a></li>
            </ul>
        </nav>
        
        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <header>
                <div class="logo">
                    <img src="logo.png" alt="Logo Empresa">
                </div>
                <div id="date-time" class="date-time"></div>
                <div class="welcome-message">
                    <h1>Agregar Venta</h1>
                </div>
            </header>

            <!-- Formulario de Agregar Venta -->
            <h1>Registrar Venta</h1>
            <form action="procesar_venta.php" method="post">
                <input type="hidden" name="ID_cliente" value="<?php echo htmlspecialchars($ID_cliente); ?>">
                <input type="hidden" name="ID_empleado" value="<?php echo htmlspecialchars($ID_empleado); ?>">

                <div class="form-group">
                    <label for="numero_serie">Número de Serie</label>
                    <select id="numero_serie" name="numero_serie" required>
                        <option value="" disabled selected>Selecciona un número de serie</option>
                        <?php echo $numero_serie_options; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="seguro">Tipo de seguro</label>
                    <select id="seguro" name="seguro" required>
                        <option value="Amplio">Amplio</option>
                        <option value="Básico">Básico</option>
                        <option value="Plus">Plus</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="metodo_pago">Método de Pago</label>
                    <select id="metodo_pago" name="metodo_pago" required>
                        <option value="Tarjeta Credito">Tarjeta Credito</option>
                        <option value="Tarjeta Débito">Tarjeta Débito</option>
                        <option value="Efectivo">Efectivo</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="contado_plazo">Contado/Plazo</label>
                    <select id="contado_plazo" name="contado_plazo" required>
                        <option value="Contado">Contado</option>
                        <option value="Plazos">Plazos</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="plazo">Plazo</label>
                    <select id="plazo" name="plazo" required>
                        <option value="Se pagó de contado">Se pagó de contado</option>
                        <option value="18 meses">18 meses</option>
                        <option value="24 meses">24 meses</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="enganche">Enganche</label>
                    <input type="number" id="enganche" name="enganche" step="0.01" required>
                </div>

                <div class="form-group">
                    <label for="mensualidad">Mensualidad</label>
                    <input type="number" id="mensualidad" name="mensualidad" step="0.01" required>
                </div>

                <div class="form-group">
                    <label for="fecha_venta">Fecha de Venta</label>
                    <input type="date" id="fecha_venta" name="fecha_venta" required>
                </div>

                <div class="form-group">
                    <label for="precio_total">Precio Total</label>
                    <input type="number" id="precio_total" name="precio_total" step="0.01" required>
                </div>

                <button type="submit">Registrar Venta</button>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const select = document.getElementById('numero_serie');

            fetch('vendedor_obtener_numero.php')  // Ruta al archivo PHP que devuelve los números de serie
                .then(response => response.json())
                .then(data => {
                    data.forEach(numeroSerie => {
                        const option = document.createElement('option');
                        option.value = numeroSerie;
                        option.textContent = numeroSerie;
                        select.appendChild(option);
                    });
                })
                .catch(error => console.error('Error al obtener los números de serie:', error));
        });
    </script>
</body>
</html>
