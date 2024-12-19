<?php

// http://localhost/Backend/Tarea_Clase_10/proyecto_backend

// Establecer la conexión con la base de datos
$conexion = mysqli_connect("localhost", "root", "", "proyecto_web", 3307);

// Verificar si la conexión fue exitosa
if($conexion === false){
    echo "No pude conectarme a la base de datos! Error: " . mysqli_connect_error();
    echo "<br>";
} else {
    echo "Conexión exitosa a la base de datos!";
    echo "<br>";
}

// Consulta para mostrar las tablas
$query = "SHOW TABLES";
$resultado = mysqli_query($conexion, $query);

if ($resultado) {
    // Mostrar tablas si existen
    echo "Tablas en la base de datos:<br>";
    while ($tabla = mysqli_fetch_row($resultado)) {
        echo $tabla[0] . "<br>";
    }
} else {
    // Error en la consulta
    echo "Error al obtener las tablas: " . mysqli_error($conexion);
}

//Cierro conexion a la base de datos
mysqli_close($conexion);

?>
