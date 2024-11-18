<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

// Incluir la conexión a la base de datos
include 'conexion.php';

// Obtener información del usuario
$id_usuario = $_SESSION['id_usuario'];
$query = "SELECT nombre, correo, tipo_usuario, fecha_creacion FROM Usuarios WHERE id_usuario = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$resultado = $stmt->get_result();
$usuario = $resultado->fetch_assoc();

// Si no se encuentra el usuario, cerrar sesión por seguridad
if (!$usuario) {
    session_destroy();
    header("Location: login.php");
    exit();
}

// Formatear la fecha
$fecha_creacion = date("d-m-Y", strtotime($usuario['fecha_creacion']));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <title>Perfil de Usuario</title>
    <style>
        body {
            background-image: url('img/fondo.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
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
        .translucent-section {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 8px;
            margin-top: 50px;
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
        .navbar .btn-custom {
            background-color: transparent;
            border: none;
            padding: 0;
            border-radius: 10px;
        }
        .navbar .btn-custom img {
            max-width: 50px;
            height: auto;
        }
        .navbar .btn-custom:hover {
            background-color: transparent;
        }
    </style>
</head>
<body>
    <div style="height: 100px;">
        <h1 class="banner">
            <nav class="navbar navbar-expand-lg navbar-custom w-100">
                <a href="index.php">
                    <img src="img/Logo.png" class="float-start" alt="Logo" style="max-width: 90px;">
                </a>
                <div class="container-fluid">
                    <a class="navbar-brand" href="index.php"></a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav w-100 d-flex justify-content-around">
                            <li class="nav-item flex-grow-1 text-center">
                                <a class="nav-link" href="index.php">Inicio</a>
                            </li>
                            <li class="nav-item flex-grow-1 text-center">
                                <a class="nav-link" href="productos.php">Productos</a>
                            </li>
                            <li class="nav-item flex-grow-1 text-center">
                                <a class="nav-link" href="nosotros.php">Conócenos</a>
                            </li>
                            <li class="nav-item flex-grow-1 text-center">
                                <a class="nav-link" href="contacto.php">Contáctanos</a>
                            </li>
                            <li class="nav-item flex-grow-1 text-center">
                                <a class="nav-link active" href="perfil.php">
                                    <?php echo htmlspecialchars($usuario['nombre']); ?>
                                </a>
                            </li>
                        </ul>
                        <button class="btn btn-custom" type="button" data-bs-toggle="modal" data-bs-target="#logoutModal">
                            <img src="img/button.png" alt="Icono">
                        </button>
                    </div>
                </div>
            </nav>
        </h1>
    </div>

    <div class="container">
        <div class="translucent-section">
            <h2 class="text-center">Perfil de Usuario</h2>
            <table class="table table-bordered">
                <tr>
                    <th>Nombre</th>
                    <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                </tr>
                <tr>
                    <th>Correo</th>
                    <td><?php echo htmlspecialchars($usuario['correo']); ?></td>
                </tr>
                <tr>
                    <th>Tipo de Usuario</th>
                    <td><?php echo htmlspecialchars($usuario['tipo_usuario']); ?></td>
                </tr>
                <tr>
                    <th>Miembro desde</th>
                    <td><?php echo $fecha_creacion; ?></td>
                </tr>
            </table>
            <div class="text-center">
                <a href="editar_perfil.php" class="btn btn-primary">Editar Perfil</a>
                <a href="logout.php" class="btn btn-danger">Cerrar Sesión</a>
            </div>
        </div>
    </div>

    <script src="js/bootstrap.min.js"></script>
</body>
</html>
