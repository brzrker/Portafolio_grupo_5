<?php
session_start();
require_once 'conexion.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <title>Cervecería Nacional - Inicio</title>
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
    .translucent-section {
      background-color: rgba(255, 255, 255, 0.8);
      padding: 20px;
      border-radius: 8px;
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
                <a class="nav-link active" aria-current="page" href="index.php">Inicio</a>
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
            </ul>
            <?php if (isset($_SESSION['id_usuario'])): ?>
              <span class="navbar-text">
                Bienvenido, <?= htmlspecialchars($_SESSION['nombre'] ?? 'Usuario'); ?> |
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
              <input type="email" class="form-control" name="correo" id="email" placeholder="nombre@ejemplo.com" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Contraseña</label>
              <input type="password" class="form-control" name="contraseña" id="password" placeholder="Contraseña" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="container my-5">
    <!-- Galería de Eventos -->
    <section class="my-5 translucent-section">
      <h2 class="text-center">Galería de Eventos</h2>
      <p class="text-center">Descubre algunos de los eventos y experiencias especiales que hemos compartido con nuestros clientes.</p>
      <div class="row">
        <div class="col-md-4">
          <img src="img/evento_degustacion.png" class="img-fluid rounded mb-3" alt="Evento 1">
          <h5 class="text-center">Evento de Degustación</h5>
          <p class="text-center">Una noche inolvidable con nuestros clientes.</p>
        </div>
        <div class="col-md-4">
          <img src="img/visita_fabrica.png" class="img-fluid rounded mb-3" alt="Evento 2">
          <h5 class="text-center">Visita a la Fábrica</h5>
          <p class="text-center">Nuestros visitantes aprendiendo sobre el proceso de elaboración.</p>
        </div>
        <div class="col-md-4">
          <img src="img/lanzamiento_cerveza.png" class="img-fluid rounded mb-3" alt="Evento 3">
          <h5 class="text-center">Lanzamiento de Nueva Cerveza</h5>
          <p class="text-center">Presentación de nuestro nuevo sabor.</p>
        </div>
      </div>
    </section>

    <!-- Sección de Testimonios -->
    <section class="my-5 translucent-section">
      <h2 class="text-center">Lo que dicen nuestros clientes</h2>
      <div id="testimonios" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <blockquote class="blockquote text-center">
              <p class="mb-3">"La mejor cerveza artesanal que he probado, ¡increíble sabor y calidad!"</p>
              <footer class="blockquote-footer">Cliente satisfecho</footer>
            </blockquote>
          </div>
          <div class="carousel-item">
            <blockquote class="blockquote text-center">
              <p class="mb-3">"La visita a la fábrica fue una experiencia increíble, ¡muy recomendada!"</p>
              <footer class="blockquote-footer">María G.</footer>
            </blockquote>
          </div>
          <div class="carousel-item">
            <blockquote class="blockquote text-center">
              <p class="mb-3">"Siempre disfruto de los eventos, excelente ambiente y buena cerveza."</p>
              <footer class="blockquote-footer">Luis R.</footer>
            </blockquote>
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#testimonios" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#testimonios" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Siguiente</span>
        </button>
      </div>
    </section>

    <!-- Llamado a la Acción para el Boletín -->
    <section class="my-5 text-center translucent-section">
      <h2>Suscríbete a Nuestro Boletín</h2>
      <p>Recibe noticias, promociones exclusivas y mantente informado sobre nuestros próximos eventos.</p>
      <form class="w-50 mx-auto">
        <div class="input-group">
          <input type="email" class="form-control" placeholder="Ingresa tu correo" aria-label="Ingresa tu correo">
          <button class="btn btn-primary" type="submit">Suscribirse</button>
        </div>
      </form>
    </section>
  </div>

  <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
