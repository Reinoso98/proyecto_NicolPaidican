<?php 

    if(isset($_GET["id"])){
        $id = $_GET["id"];
        //todo bien, puedo seguir con el proceso!
        if(!empty($id)){
            //todo bien, puedo seguir con el proceso!
            $conexion = mysqli_connect("127.0.0.1:3307", "root", "", "proyecto_web");

            $query = "DELETE FROM productos WHERE id_producto = ".$id;
            $resultado = mysqli_query($conexion, $query);

            mysqli_close($conexion);

            if($resultado){
                //entro cuando $resultado es igual a verdadero!
                echo "Salio todo bien!";
                echo "<br>";
                header('Location: ../admin.php');
            }
            else{          
                //todo mal, no borro nada!
                echo "Error al borrar el producto!";
                echo "<br>";
            }
        }
        else{            
            //todo mal, no borro nada!
            echo "Error al borrar el producto!";
            echo "<br>";
        }
    }
    else{
        //todo mal, no borro nada!
        echo "Error al borrar el producto!";
        echo "<br>";
    }

?>