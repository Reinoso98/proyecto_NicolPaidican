<?php
if (isset($_POST["id_producto"])) {
    $id = intval($_POST["id_producto"]);
    $nombre_producto = $_POST["nombre_producto"];
    $descripcion_producto = $_POST["descripcion_producto"];
    $precio_producto = $_POST["precio_producto"];
    $stock_producto = $_POST["stock_producto"];

    $conexion = mysqli_connect("127.0.0.1:3307", "root", "", "proyecto_web");

    if (!$conexion) {
        die("Error al conectar con la base de datos: " . mysqli_connect_error());
    }

    // Comprobación si se ha subido una nueva imagen
    if (!empty($_FILES["imagen producto"]["name"])) {
        $imagen_producto = $_FILES["imagen producto"];
        $type = pathinfo($imagen_producto["name"], PATHINFO_EXTENSION);
        $data = file_get_contents($imagen_producto["tmp_name"]);
        $imagen_base64 = "data:image/" . $type . ";base64," . base64_encode($data);
        
        // Actualizar con la nueva imagen
        $query = "UPDATE productos SET 
                    nombre_producto = ?, 
                    descripcion_producto = ?, 
                    precio_producto = ?, 
                    stock_producto = ?, 
                    `imagen producto` = ? 
                  WHERE id_producto = ?";
        $stmt = mysqli_prepare($conexion, $query);
        mysqli_stmt_bind_param($stmt, "ssdissi", $nombre_producto, $descripcion_producto, $precio_producto, $stock_producto, $imagen_base64, $id);
    } else {
        // Si no hay nueva imagen, no actualizar el campo de imagen
        $query = "UPDATE productos SET 
                    nombre_producto = ?, 
                    descripcion_producto = ?, 
                    precio_producto = ?, 
                    stock_producto = ? 
                  WHERE id_producto = ?";
        $stmt = mysqli_prepare($conexion, $query);
        mysqli_stmt_bind_param($stmt, "ssdii", $nombre_producto, $descripcion_producto, $precio_producto, $stock_producto, $id);
    }

    // Ejecutar la consulta
    $resultado = mysqli_stmt_execute($stmt);

    if ($resultado) {
        header('Location: ../admin.php');
    } else {
        echo "Error al actualizar el producto: " . mysqli_error($conexion);
    }

    // Cerrar conexión y liberar recursos
    mysqli_stmt_close($stmt);
    mysqli_close($conexion);
} else {
    echo "ID de producto no especificado.";
    exit;
}
?>
