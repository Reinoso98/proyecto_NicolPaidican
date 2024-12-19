<?php
// Conexión a la base de datos
$conexion = mysqli_connect("127.0.0.1:3307", "root", "", "proyecto_web");

// Verificar conexión
if (!$conexion) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}

// Procesar formulario al enviarlo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conexion, $_POST['email']);
    $password = $_POST['password']; // No escapamos aquí porque la comparación es con password_verify.

    // Consultar al usuario en la base de datos
    $query = "SELECT password, rol FROM usuarios WHERE email = '$email'";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $usuario = mysqli_fetch_assoc($resultado);

        // Verificar la contraseña (encriptada en la base de datos)
        if ($password === $usuario['password']) {
            // Verificar el rol del usuario
            if (trim($usuario['rol']) === 'admin') {
                // Redirigir a la página de gestión de productos
                header("Location: admin.php");
                exit();
            } else {
                // En caso improbable de un cliente registrado, enviar a la página de visualización
                header("Location: client.php");
                exit();
            }
        } else {
            // Contraseña incorrecta; redirigir a la visualización
            header("Location: client.php");
            exit();
        }
    } else {
        // Si el usuario no está registrado, redirigir directamente a la visualización de productos
        header("Location: client.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/login.css">
    <title>Inicio de Sesión</title>
</head>
<body>
    <form method="POST" action="" id="login-form" class="login-form" autocomplete="off" role="main">
        <h1 class="a11y-hidden">Formulario de Inicio de Sesión</h1>
        <div>
            <label class="label-email">
                <input type="email" class="text" name="email" placeholder="Correo electrónico" tabindex="1" required />
                <span class="required">Correo electrónico</span>
            </label>
        </div>
        <div>
            <label class="label-password">
                <input type="password" class="text" name="password" placeholder="Contraseña" tabindex="2" required />
                <span class="required">Contraseña</span>
            </label>
        </div>
        <input type="submit" value="Iniciar Sesión" />
        <div class="email">
            <a href="#">¿Olvidaste tu contraseña?</a>
        </div>
        <figure aria-hidden="true">
            <div class="person-body"></div>
            <div class="neck skin"></div>
            <div class="head skin">
                <div class="eyes"></div>
                <div class="mouth"></div>
            </div>
            <div class="hair"></div>
            <div class="ears"></div>
            <div class="shirt-1"></div>
            <div class="shirt-2"></div>
        </figure>
    </form>
</body>
</html>

<?php
// Cerrar conexión a la base de datos
mysqli_close($conexion);
?>
