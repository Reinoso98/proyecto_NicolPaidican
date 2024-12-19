<?php
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $conexion = mysqli_connect("127.0.0.1:3307", "root", "", "proyecto_web");

    if (!$conexion) {
        die("Error al conectar con la base de datos: " . mysqli_connect_error());
    }

    $query = "SELECT * FROM productos WHERE id_producto = $id";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $producto = mysqli_fetch_assoc($resultado);
    } else {
        echo "Producto no encontrado.";
        exit;
    }

    mysqli_close($conexion);
} else {
    echo "ID de producto no especificado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <link rel="stylesheet" href="./css/edit.css">
</head>
<body>
    <div class="container">
        <h1>Editar Producto</h1>
        <form action="./php/editar_productos.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_producto" value="<?php echo htmlspecialchars($producto['id_producto']); ?>">

            <label for="nombre_producto">Nombre:</label>
            <input type="text" id="nombre_producto" name="nombre_producto" value="<?php echo htmlspecialchars($producto['nombre_producto']); ?>" required>

            <label for="descripcion_producto">Descripción:</label>
            <textarea id="descripcion_producto" name="descripcion_producto" required><?php echo htmlspecialchars($producto['descripcion_producto']); ?></textarea>

            <label for="precio_producto">Precio:</label>
            <input type="number" id="precio_producto" name="precio_producto" value="<?php echo htmlspecialchars($producto['precio_producto']); ?>" step="0.01" required>

            <label for="stock_producto">Stock:</label>
            <input type="number" id="stock_producto" name="stock_producto" value="<?php echo htmlspecialchars($producto['stock_producto']); ?>" required>

            <label for="imagen producto">Imagen (opcional):</label>
            <input type="file" id="imagen producto" name="imagen producto">

            <button type="submit">Guardar Cambios</button>
        </form>
    </div>
</body>
</html>
