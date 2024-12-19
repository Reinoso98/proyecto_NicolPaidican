<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos de Crochet</title>
    <link rel="stylesheet" href="./css/admin.css">
</head>
<body>
    <div class="container">
        <h1>Gestión de Productos de Crochet</h1>

        <a href="./formulario_agregar.php" class="btnAgregar">Agregar producto</a>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $conexion = mysqli_connect("127.0.0.1:3307", "root", "", "proyecto_web");

                    if (!$conexion) {
                        die("Error al conectar con la base de datos: " . mysqli_connect_error());
                    }

                    $query = "SELECT * FROM productos";
                    $resultado = mysqli_query($conexion, $query);

                    if (!$resultado) {
                        die("Error en la consulta: " . mysqli_error($conexion));
                    }

                    while ($unaFila = mysqli_fetch_assoc($resultado)) {
                        echo '<tr>
                                <td>' . htmlspecialchars($unaFila["id_producto"]) . '</td>
                                <td>' . htmlspecialchars($unaFila["nombre_producto"]) . '</td>
                                <td>' . htmlspecialchars($unaFila["descripcion_producto"]) . '</td>
                                <td>$' . htmlspecialchars($unaFila["precio_producto"]) . '</td>
                                <td>' . htmlspecialchars($unaFila["stock_producto"]) . '</td>
                                <td>
                                    <img class="imagen-preview" src="' . htmlspecialchars($unaFila["imagen producto"]) . '" alt="Imagen de ' . htmlspecialchars($unaFila["nombre_producto"]) . '">
                                </td>
                                <td>
                                    <a href="./formulario_editar.php?id=' . htmlspecialchars($unaFila["id_producto"]) . '" class="btnEditar">Editar</a>
                                    <a href="./php/eliminar_producto.php?id=' . htmlspecialchars($unaFila["id_producto"]) . '" class="btnEliminar">Eliminar</a>
                                </td>
                            </tr>';
                    }

                    mysqli_close($conexion);
                ?>    
            </tbody>
        </table>
    </div>

    <script src="../js/script.js"></script>
</body>
</html>
