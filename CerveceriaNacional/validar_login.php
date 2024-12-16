<?php
session_start();
require_once 'conexion.php'; // Asegúrate de tener este archivo configurado.

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = $_POST['correo'];
    $password = $_POST['password'];

    // Validar credenciales
    $query = $conexion->prepare("SELECT id_usuario, contraseña, tipo_usuario FROM Usuarios WHERE correo = ?");
    $query->bind_param("s", $correo);
    $query->execute();
    $resultado = $query->get_result();

    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();
        // Verificar contraseña
        if (hash('sha256', $password) === $usuario['contraseña']) {
            $_SESSION['id_usuario'] = $usuario['id_usuario'];
            $_SESSION['tipo_usuario'] = $usuario['tipo_usuario'];
            header("Location: productos.php");
        } else {
            $_SESSION['error'] = "Contraseña incorrecta."; // Mensaje de error
            header("Location: login.php");
        }
    } else {
        $_SESSION['error'] = "Correo no registrado."; // Mensaje de error
        header("Location: login.php");
    }
    exit();
}
?>
