<?php
session_start();
include("conexion.php"); // Conexión a la base de datos

// Obtener el nombre del usuario de la sesión
$nombreUsuario = $_SESSION['nombre'] ?? 'Usuario'; // Usa 'Usuario' como valor predeterminado
?>
<!DOCTYPE html>
<html lang="en">
<head>

<style>
  /* Fondo translúcido para asegurar la legibilidad en secciones específicas */
  .translucent-section {
    background-color: rgba(255, 255, 255, 0.8); /* Blanco translúcido */
    padding: 20px;
    border-radius: 8px;
  }
</style>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="css/bootstrap.min.css" rel="stylesheet"> 
  <title>Cervecería Nacional - Contacto</title>
  <style>
    body {
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      background-color: #f4e1a6;
      background-image: url('img/fondo.jpg') ; 
    }
    body::before{
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5); /* Cambia la opacidad aquí: 0.5 es 50% */
      z-index: -1; /* Se asegura de que la capa esté detrás del contenido */
    }

    .banner{
      background-color: rgb(255, 166, 0); /* Color de fondo naranja */
      font-family: fantasy;
      font-size: 25px;
      height: auto;
      padding: 5px; /* Añadir padding para asegurar que se vea bien */
    }
    .navbar-custom {
      background-color: rgb(255, 166, 0); /* Mismo color de fondo */
    }
    .navbar .btn-custom {
      background-color: transparent; /* Fondo transparente para mostrar solo la imagen */
      border: none;
      padding: 0;
      border-radius: 10px;
    }

    .navbar .btn-custom img {
      max-width: 50px; /* Tamaño ajustable de la imagen */
      height: auto;
    }

    .navbar .btn-custom:hover {
      background-color: transparent; /* Mantener transparente al hacer hover */
    }
  </style>

</head>
<body>
  <div style="height: 100px;">
    <h1 class="banner">
      <nav class="navbar navbar-expand-lg navbar-custom w-100 ">
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
                <a class="nav-link active" href="contacto.php">Contáctanos</a>
              </li>
            </ul>
            <?php if (isset($_SESSION['UsuarioID'])): ?>
              <span class="navbar-text">
                <?= htmlspecialchars($nombreUsuario); ?> |
                <a href="perfil.php">Perfil</a> |
                <a href="logout.php">Cerrar sesión</a>
              </span>
            <?php else: ?>
              <button class="btn btn-custom" type="button" data-bs-toggle="modal" data-bs-target="#loginModal">
                <img src="img/button.png" alt="Icono">
              </button>
            <?php endif; ?>
          </div>
        </div>
      </nav>
    </h1>
  </div>
  <!-- Ventana para iniciar sesion-->
  <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="loginModalLabel">Iniciar Sesión</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form method="post" action="login.php">
            <div class="mb-3">
              <label for="email" class="form-label">Correo electrónico</label>
              <input type="email" class="form-control" name="email" id="email" placeholder="nombre@ejemplo.com" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Contraseña</label>
              <input type="password" class="form-control" name="password" id="password" placeholder="Contraseña" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
            <a href="registro.php" class="btn btn-success w-100">Regístrate 🍺</a>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script src="js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

<div class="container my-5">
    <?php if (isset($_GET['status'])): ?>
      <?php if ($_GET['status'] === 'success'): ?>
        <div class="alert alert-success text-center">
          Tu mensaje ha sido enviado con éxito. Gracias por contactarnos.
        </div>
      <?php elseif ($_GET['status'] === 'error'): ?>
        <div class="alert alert-danger text-center">
          Hubo un error al enviar tu mensaje. Por favor, inténtalo de nuevo más tarde.
        </div>
      <?php endif; ?>
    <?php endif; ?>

  <div class="row">
    <!-- Formulario de Contacto -->
    <div class="col-md-6 translucent-section p-4">
      <h2 class="text-center mb-4">Contáctanos</h2>
      <form action="enviar_mensaje.php" method="POST">
        <div class="mb-3">
          <label for="nombre" class="form-label">Nombre</label>
          <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Tu nombre" required>
        </div>
        <div class="mb-3">
          <label for="correo" class="form-label">Correo</label>
          <input type="email" class="form-control" name="correo" id="correo" placeholder="tuemail@ejemplo.com" required>
        </div>
        <div class="mb-3">
          <label for="mensaje" class="form-label">Mensaje</label>
          <textarea class="form-control" name="mensaje" id="mensaje" rows="5" placeholder="Escribe tu mensaje aquí..." required></textarea>
        </div>
        <button type="submit" class="btn btn-primary w-100">Enviar Mensaje</button>
      </form>
    </div>

    <!-- Espacio para el Mapa de Google Maps -->
    <div class="col-md-6 translucent-section p-4">
      <h2 class="text-center mb-4">Nuestra Ubicación</h2>
      <div style="width: 100%; height: 400px; background-color: #e0e0e0; display: flex; align-items: center; justify-content: center;">
        <!-- Mapa -->
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1480.3500679591207!2d-70.64732395625174!3d-33.59820884184643!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9662d9c08890f53b%3A0x8dda505a75fb1c74!2sPaicav%C3%AD%203190%2C%20La%20Pintana%2C%20Regi%C3%B3n%20Metropolitana!5e0!3m2!1ses!2scl!4v1728866725628!5m2!1ses!2scl" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div>
    </div>
  </div>
</div>
</body>
</html>
