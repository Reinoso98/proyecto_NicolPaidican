<?php
// Conexión a la base de datos
$conexion = mysqli_connect("127.0.0.1:3307", "root", "", "proyecto_web");

// Verificar la conexión
if (!$conexion) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}

// Consulta para obtener los productos
$query = "SELECT nombre_producto, descripcion_producto, precio_producto, stock_producto, `imagen producto` FROM productos";
$resultado = mysqli_query($conexion, $query);

if (!$resultado) {
    die("Error al realizar la consulta: " . mysqli_error($conexion));
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda de Crochet</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/client.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Mi Tienda de Crochet</a>
        </div>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <!-- Redirección corregida -->
                    <a class="nav-link" href="./login.php">Iniciar Sesión</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="text-center mb-4">Nuestros Productos</h1>
        <div class="row">
            <?php
            // Mostrar los productos en tarjetas
            while ($producto = mysqli_fetch_assoc($resultado)) {
                echo '<div class="col-md-4 mb-4">';
                echo '    <div class="card product-card">';
                echo '        <img src="' . htmlspecialchars($producto['imagen producto']) . '" class="card-img-top" alt="' . htmlspecialchars($producto['nombre_producto']) . '">';
                echo '        <div class="card-body">';
                echo '            <h5 class="card-title">' . htmlspecialchars($producto['nombre_producto']) . '</h5>';
                echo '            <p class="card-text">' . htmlspecialchars($producto['descripcion_producto']) . '</p>';
                echo '            <p class="price">$' . htmlspecialchars($producto['precio_producto']) . '</p>';
                echo '            <p class="stock">Stock: ' . htmlspecialchars($producto['stock_producto']) . '</p>';
                echo '        </div>';
                echo '    </div>';
                echo '</div>';
            }
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>
