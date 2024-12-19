<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $nombre_producto = $_POST["nombre"];
    $descripcion_producto = $_POST["nescripcion"];
    $precio_producto = $_POST["precio"];
    $stock_producto = $_POST["stock"];

    // Trabajar con la imagen
    $imagen_producto = $_FILES["imagen"];

    // Verificar si se ha subido una imagen
    if (!empty($_FILES["imagen_producto"]["name"])) {
        // Obtener la extensión del archivo
        $type = pathinfo($_FILES["imagen_producto"]["name"], PATHINFO_EXTENSION);
        
        // Obtener el contenido de la imagen en formato string
        $data = file_get_contents($_FILES["imagen_producto"]["tmp_name"]);
        
        // Convertir la imagen a Base64
        $imagen_base64 = "data:image/" . $type . ";base64," . base64_encode($data);
    } else {
        $imagen_base64 = null; // Si no se sube una imagen
    }
    

    // Conectar a la base de datos
    $conexion = mysqli_connect("127.0.0.1:3307", "root", "", "proyecto_web");

    if (!$conexion) {
        die("Error al conectar con la base de datos: " . mysqli_connect_error());
    }

    // Insertar el producto en la base de datos
    $query = "INSERT INTO productos (nombre_producto, descripcion_producto, precio_producto, stock_producto, imagen producto) 
              VALUES (?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conexion, $query);
    mysqli_stmt_bind_param($stmt, "ssdis", $nombre_producto, $descripcion_producto, $precio_producto, $stock_producto, $imagen_base64);

    $resultado = mysqli_stmt_execute($stmt);

    if ($resultado) {
        // Si el producto se agregó correctamente, redirigir al listado de productos
        header('Location: productos.php');
    } else {
        // Si hubo un error, mostrar mensaje de error
        echo "Error al agregar el producto: " . mysqli_error($conexion);
    }

    // Cerrar la conexión
    mysqli_stmt_close($stmt);
    mysqli_close($conexion);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Producto</title>
    <link rel="stylesheet" href="./css/edit.css">
</head>
<body>
    <div class="container">
        <h1>Agregar Nuevo Producto</h1>

        <form class="add-form" action="./php/agregar_productos.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre_producto" placeholder="Nombre del producto" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion_producto" rows="4" placeholder="Descripción del producto" required></textarea>
            </div>
            <div class="form-group">
                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="precio_producto" placeholder="Precio del producto" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="stock">Stock:</label>
                <input type="number" id="stock" name="stock_producto" placeholder="Cantidad disponible" required>
            </div>
            <div class="form-group">
                <label for="imagen">Imagen:</label>
                <input type="file" id="imagen" name="imagen_producto" accept="image/*" required>
            </div>
            <button type="submit" class="btn-submit">Agregar Producto</button>
        </form>
    </div>
</body>
</html>
