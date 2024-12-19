<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $nombre_producto = $_POST["nombre_producto"];
    $descripcion_producto = $_POST["descripcion_producto"];
    $precio_producto = $_POST["precio_producto"];
    $stock_producto = $_POST["stock_producto"];

    // Trabajar con la imagen
    $imagen_producto = $_FILES["imagen_producto"];

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
    $query = "INSERT INTO productos (nombre_producto, descripcion_producto, precio_producto, stock_producto, `imagen producto`) 
              VALUES (?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conexion, $query);
    mysqli_stmt_bind_param($stmt, "sssss", $nombre_producto, $descripcion_producto, $precio_producto, $stock_producto, $imagen_base64);

    $resultado = mysqli_stmt_execute($stmt);

    if ($resultado) {
        // Si el producto se agregó correctamente, redirigir al listado de productos
        header('Location: ../admin.php');
    } else {
        // Si hubo un error, mostrar mensaje de error
        echo "Error al agregar el producto: " . mysqli_error($conexion);
    }

    // Cerrar la conexión
    mysqli_stmt_close($stmt);
    mysqli_close($conexion);
}
?>
