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
  <title>Cervecería Nacional - Nosotros</title>
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
                <a class="nav-link active" href="nosotros.php">Conócenos</a>
              </li>
              <li class="nav-item flex-grow-1 text-center">
                <a class="nav-link" href="contacto.php">Contáctanos</a>
              </li>
            </ul>
            <?php if (isset($_SESSION['id_usuario'])): ?>
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
  
  <!-- Ventana para iniciar sesión -->
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
            <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  
  <script src="js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

  <div class="container my-5">
    <!-- Sección Sobre Nosotros -->
    <div class="translucent-section p-4">
      <h2 class="text-center mb-4">Sobre Nosotros</h2>
      <p>
        Cervecería Nacional es una empresa familiar ubicada en la periferia de Santiago. Con pasión y dedicación, llevamos varios años produciendo cerveza artesanal de alta calidad, utilizando técnicas tradicionales y los mejores ingredientes naturales. Nuestra historia comienza en un pequeño garaje, donde los fundadores, una pareja apasionada por la cerveza, decidieron convertir su hobby en un negocio que celebra los sabores únicos y la comunidad local. Hoy en día, seguimos creciendo y compartiendo nuestra pasión con más personas.
      </p>
    </div>

    <!-- Sección Misión -->
    <div class="translucent-section p-4">
      <h2 class="text-center mb-4">Misión</h2>
      <p>
        Producir cerveza artesanal de la más alta calidad, respetando los procesos tradicionales y fomentando el uso de ingredientes locales, para ofrecer a nuestros clientes una experiencia única y auténtica que refleje nuestra pasión y compromiso con la excelencia.
      </p>
    </div>

    <!-- Sección Visión -->
    <div class="translucent-section p-4">
      <h2 class="text-center mb-4">Visión</h2>
      <p>
        Ser reconocidos como una de las cervecerías artesanales más destacadas de la región, expandiendo nuestro alcance sin perder nuestras raíces familiares y nuestra dedicación a la calidad y la tradición.
      </p>
    </div>
  </div>

</body>
</html>
