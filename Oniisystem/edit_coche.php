<?php
include('connection.php');

// Obtener el Número de Serie del coche desde la URL
$numero_serie = isset($_GET['Numero_serie']) ? $_GET['Numero_serie'] : null;

if (!$numero_serie) {
    die("ID del coche no proporcionado o no válido.");
}

// Consultar la información del coche
$query = "SELECT * FROM auto WHERE Numero_serie = ?";
$stmt = $link->prepare($query);
$stmt->bind_param("s", $numero_serie);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Coche no encontrado.");
}

$coche = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Auto</title>
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
                <li><a href="gerente_main.php">Menú</a></li>
                <li><a href="gerente_empleados.php">Empleados</a></li>
                <li><a href="gerente_coches.php">Coches</a></li>
                <li><a href="gerente_ventas.php">Ventas</a></li>
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
                    <h1>Editar Auto</h1>
                </div>
            </header>

            <!-- Formulario de Editar Auto -->
            <form action="update_coche.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="estado">Estado</label>
                    <select id="estado" name="estado" required>
                        <option value="Nuevo" <?php echo $coche['estado'] === 'Nuevo' ? 'selected' : ''; ?>>Nuevo</option>
                        <option value="SemiNuevo" <?php echo $coche['estado'] === 'SemiNuevo' ? 'selected' : ''; ?>>SemiNuevo</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="marca">Marca</label>
                    <input type="text" id="marca" name="marca" value="<?php echo htmlspecialchars($coche['marca']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="modelo">Modelo</label>
                    <input type="text" id="modelo" name="modelo" value="<?php echo htmlspecialchars($coche['modelo']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="año">Año</label>
                    <input type="text" id="año" name="año" value="<?php echo htmlspecialchars($coche['año']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="cilindros">Cilindros</label>
                    <input type="text" id="cilindros" name="cilindros" value="<?php echo htmlspecialchars($coche['cilindros']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="disponibilidad">Disponibilidad</label>
                    <select id="disponibilidad" name="disponibilidad" required>
                        <option value="Disponible" <?php echo $coche['disponibilidad'] === 'Disponible' ? 'selected' : ''; ?>>Disponible</option>
                        <option value="En servicio" <?php echo $coche['disponibilidad'] === 'En servicio' ? 'selected' : ''; ?>>En servicio</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="precio_base">Precio Base</label>
                    <input type="number" id="precio_base" name="precio_base" step="0.01" value="<?php echo htmlspecialchars($coche['precio_base']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="costo">Costo</label>
                    <input type="number" id="costo" name="costo" step="0.01" value="<?php echo htmlspecialchars($coche['costo']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="cantidad_puertas">Cantidad de Puertas</label>
                    <input type="number" id="cantidad_puertas" name="cantidad_puertas" value="<?php echo htmlspecialchars($coche['cantidad_puertas']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="color">Color</label>
                    <input type="text" id="color" name="color" value="<?php echo htmlspecialchars($coche['color']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="imagen_auto">Imagen del Auto</label>
                    <input type="file" id="imagen_auto" name="imagen_auto">
                </div>

                <input type="hidden" name="numero_serie" value="<?php echo htmlspecialchars($numero_serie); ?>">
                
                <button type="submit">Actualizar Auto</button>
            </form>
        </div>
    </div>
</body>
</html>

<?php
$stmt->close();
$link->close();
?>
