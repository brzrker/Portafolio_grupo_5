<?php
require_once 'conexion.php';

if (!$conexion) {
    die("Error al conectar con la base de datos: ".print_r(sqlsrv_errors(), true));
}

$mensaje = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $apellido = trim($_POST['apellido'] ?? '');
    $correo = trim($_POST['correo'] ?? '');
    $rut = trim($_POST['rut'] ?? '');
    $celular = trim($_POST['celular'] ?? '');
    $contraseña = $_POST['contraseña'] ?? '';
    $rol_id = 5; // Por defecto asignamos el rol de "Usuario"

    if (!empty($nombre) && !empty($apellido) && !empty($correo) && !empty($rut) && !empty($celular) && !empty($contraseña)) {
        $contraseña_cifrada = password_hash($contraseña, PASSWORD_BCRYPT);

        // Preparar consulta
        $sql = "INSERT INTO Usuarios (Nombre, Apellido, RUT, Correo, Celular, Contraseña, RolID)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        //var_dump([$nombre, $apellido, $rut, $correo, $celular, $contraseña_cifrada, $rol_id]);
        $stmt = sqlsrv_prepare($conexion, $sql, [$nombre, $apellido, $rut, $correo, $celular, $contraseña_cifrada, $rol_id]);
        
        if ($stmt === false) {
            die("Error al preparar la consulta: " . print_r(sqlsrv_errors(), true));
        }

        if (!sqlsrv_execute($stmt)) {
            die("Error al ejecutar la consulta: " . print_r(sqlsrv_errors(), true));
        } else {
            $mensaje = "Registro exitoso. ¡Ahora puedes iniciar sesión!";
        }
    } else {
        $mensaje = "Por favor, complete todos los campos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <title>Registro de Usuario</title>
  <style>
    body {
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      background-color: #f4e1a6;
      background-image: url('img/fondo.jpg');
    }
    body::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: -1;
    }
    .banner {
      background-color: rgb(255, 166, 0);
      font-family: fantasy;
      font-size: 25px;
      height: auto;
      padding: 5px;
    }
    .navbar-custom {
      background-color: rgb(255, 166, 0);
    }
    .form-container {
      background: rgba(255, 255, 255, 0.8); /* Fondo blanco semi-transparente */
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.5);
    }
  </style>
</head>
<body>
  <div class="banner text-center text-white">Registro de Usuario</div>
  <div class="container mt-5 d-flex justify-content-center">
    <div class="form-container col-md-6">
      <h2 class="mb-4 text-center">Crear una cuenta</h2>

      <?php if (!empty($mensaje)): ?>
        <div class="alert alert-info"><?php echo $mensaje; ?></div>
      <?php endif; ?>

      <form action="registro.php" method="POST">
        <div class="mb-3">
          <label for="nombre" class="form-label">Nombre</label>
          <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="mb-3">
          <label for="apellido" class="form-label">Apellido</label>
          <input type="text" class="form-control" id="apellido" name="apellido" required>
        </div>
        <div class="mb-3">
          <label for="correo" class="form-label">Correo electrónico</label>
          <input type="email" class="form-control" id="correo" name="correo" required>
        </div>
        <div class="mb-3">
          <label for="rut" class="form-label">RUT</label>
          <input type="text" class="form-control" id="rut" name="rut" placeholder="12345678-9" required>
        </div>
        <div class="mb-3">
          <label for="celular" class="form-label">Celular</label>
          <input type="text" class="form-control" id="celular" name="celular" required>
        </div>
        <div class="mb-3">
          <label for="contraseña" class="form-label">Contraseña</label>
          <input type="password" class="form-control" id="contraseña" name="contraseña" required>
        </div>
        <button type="submit" class="btn btn-success w-100">Registrar</button>
        <a href="index.php" class="btn btn-danger w-100">Regresar al Inicio</a>
      </form>
    </div>
  </div>

  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</body>
</html>
