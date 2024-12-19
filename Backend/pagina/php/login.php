<?php
include "./index.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    // Consultar el usuario
    $sql = "SELECT * FROM usuario WHERE usuario = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $usuario, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['rol'] == 'admin') {
            header("Location: ../admin.html");
        } else {
            header("Location: ../index.html");
        }
    } else {
        echo "Usuario o contraseña incorrectos.";
    }

    $stmt->close();
    $conn->close();
}

?>