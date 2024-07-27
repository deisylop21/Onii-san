<?php
include('connection.php');
session_start();

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ID_cliente = $_SESSION['ID_cliente'];
    $ID_empleado = $_SESSION['ID_empleado']; // Asumimos que el ID del empleado está almacenado en la sesión
    $numero_serie = $_POST['numero_serie'];
    $seguro = $_POST['seguro'];
    $metodo_pago = $_POST['metodo_pago'];
    $contado_plazo = $_POST['contado_plazo'];
    $fecha_venta = $_POST['fecha_venta'];
    $precio_total = $_POST['precio_total'];
    $mensualidad = $_POST['mensualidad'];
    $enganche = $_POST['enganche'];
    $plazo = $_POST['plazo'];

    // Buscar el ID del seguro basado en el valor seleccionado
    $query_seguro = "SELECT ID_seguro FROM seguro WHERE tipo_seguro = ?";
    if ($stmt_seguro = $conn->prepare($query_seguro)) {
        $stmt_seguro->bind_param('s', $seguro);
        $stmt_seguro->execute();
        $stmt_seguro->bind_result($ID_seguro);
        $stmt_seguro->fetch();
        $stmt_seguro->close();
    } else {
        $message = "Error al buscar el ID del seguro: " . $conn->error;
    }

    if (empty($message)) {
        // Llamar al procedimiento almacenado para iniciar la venta
        $query_venta = "CALL iniciar_venta(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        if ($stmt = $conn->prepare($query_venta)) {
            $stmt->bind_param('ississsdddi', $ID_cliente, $numero_serie, $ID_empleado, $ID_seguro, $metodo_pago, $contado_plazo, $fecha_venta, $precio_total, $mensualidad, $enganche, $plazo);
            if ($stmt->execute()) {
                $message = "Venta registrada exitosamente.";
            } else {
                $message = "Error al registrar la venta: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $message = "Error en la preparación del procedimiento: " . $conn->error;
        }
    }

    $conn->close();
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
                <li><a href="vendedor_main.php">Menú</a></li>
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
            <?php if (!empty($message)) : ?>
                <p class="message"><?php echo $message; ?></p>
            <?php endif; ?>
            <form action="vendedor_procesar_venta.php" method="post">
                <input type="hidden" name="ID_cliente" value="<?php echo $_SESSION['ID_cliente']; ?>">

                <div class="form-group">
                    <label for="numero_serie">Número de Serie</label>
                    <select id="numero_serie" name="numero_serie" required>
                        <option value="" disabled selected>Selecciona un número de serie</option>
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