<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Auto</title>
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
                    <h1>Agregar Auto</h1>
                </div>
            </header>

            <!-- Formulario de Agregar Auto -->
            <form action="procesar_coche.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="numero_serie">Número de Serie</label>
                    <input type="text" id="numero_serie" name="numero_serie" required>
                </div>
                
                <div class="form-group">
                    <label for="estado">Estado</label>
                    <select id="estado" name="estado" required>
                        <option value="Nuevo">Nuevo</option>
                        <option value="SemiNuevo">SemiNuevo</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="marca">Marca</label>
                    <input type="text" id="marca" name="marca" required>
                </div>
                
                <div class="form-group">
                    <label for="modelo">Modelo</label>
                    <input type="text" id="modelo" name="modelo" required>
                </div>
                
                <div class="form-group">
                    <label for="año">Año</label>
                    <input type="text" id="año" name="año" required>
                </div>
                
                <div class="form-group">
                    <label for="cilindros">Cilindros</label>
                    <input type="text" id="cilindros" name="cilindros" required>
                </div>
                
                <div class="form-group">
                    <label for="disponibilidad">Disponibilidad</label>
                    <select id="disponibilidad" name="disponibilidad" required>
                        <option value="Disponible">Disponible</option>
                        <option value="En servicio">En servicio</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="precio_base">Precio Base</label>
                    <input type="number" id="precio_base" name="precio_base" step="0.01" required>
                </div>
                
                <div class="form-group">
                    <label for="costo">Costo</label>
                    <input type="number" id="costo" name="costo" step="0.01" required>
                </div>
                
                <div class="form-group">
                    <label for="cantidad_puertas">Cantidad de Puertas</label>
                    <input type="number" id="cantidad_puertas" name="cantidad_puertas" required>
                </div>
                
                <div class="form-group">
                    <label for="color">Color</label>
                    <input type="text" id="color" name="color" required>
                </div>
                
                <div class="form-group">
                    <label for="imagen_auto">Imagen del Auto</label>
                    <input type="file" id="imagen_auto" name="imagen_auto" required>
                </div>
                
                <button type="submit">Agregar Auto</button>
            </form>
        </div>
    </div>
</body>
</html>