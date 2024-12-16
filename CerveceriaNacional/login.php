<?php
session_start();
require_once 'conexion.php'; // Conexión usando sqlsrv_connect

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = $_POST['correo'] ?? '';
    $contraseña = $_POST['contraseña'] ?? '';

    if (empty($correo) || empty($contraseña)) {
        $error = "Por favor, complete todos los campos.";
    } else {
        // Preparar consulta para obtener usuario
        $sql = "SELECT UsuarioID, Nombre, Contraseña FROM Usuarios WHERE Correo = ?";
        $params = array($correo);

        $stmt = sqlsrv_query($conexion, $sql, $params);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true)); // Muestra errores en caso de problemas
        }

        // Verificar si existe un registro
        if (sqlsrv_fetch($stmt)) {
            $usuarioID = sqlsrv_get_field($stmt, 0); // UsuarioID
            $nombre = sqlsrv_get_field($stmt, 1); // Nombre
            $hashedPassword = sqlsrv_get_field($stmt, 2); // Contraseña cifrada

            // Comparar la contraseña ingresada con la almacenada
            if (password_verify($contraseña, $hashedPassword)) {
                // Iniciar sesión
                $_SESSION['UsuarioID'] = $usuarioID;
                $_SESSION['nombre'] = $nombre;
                header("Location: index.php"); // Redirigir al inicio
                exit();
            } else {
                $error = "Contraseña incorrecta.";
            }
        } else {
            $error = "Correo electrónico no registrado.";
        }

        // Liberar recursos del statement
        sqlsrv_free_stmt($stmt);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <title>Iniciar Sesión</title>
</head>
<body>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center mb-4">Iniciar Sesión</h2>
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger text-center"><?= htmlspecialchars($error); ?></div>
                <?php endif; ?>
                <form method="post" action="login.php">
                    <div class="mb-3">
                        <label for="correo" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="correo" name="correo" placeholder="nombre@ejemplo.com" required>
                    </div>
                    <div class="mb-3">
                        <label for="contraseña" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="contraseña" name="contraseña" placeholder="Ingrese su contraseña" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mb-2">Iniciar Sesión</button>
                    <a href="index.php" class="btn btn-danger w-100">Regresar al Inicio</a>
                </form>
            </div>
        </div>
    </div>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
