<?php
session_start();
include("conexion.php"); // Conexión a la base de datos

// Verifica si la sesión está activa
if (!isset($_SESSION['id_usuario'])) {
    echo "<script>alert('Debes iniciar sesión para acceder a los productos.'); window.location.href='login.php';</script>";
    exit();
}

// Obtener el nombre del usuario de la sesión
$nombreUsuario = $_SESSION['nombre'] ?? 'Usuario'; // Usa 'Usuario' como valor predeterminado
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <title>Cervecería Nacional - Productos</title>
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
            background-color: rgba(0, 0, 0, 0.5); /* Cambia la opacidad aquí */
            z-index: -1; /* Se asegura de que la capa esté detrás del contenido */
        }
        .banner {
            background-color: rgb(255, 166, 0); /* Color de fondo naranja */
            font-family: fantasy;
            font-size: 25px;
            height: auto;
            padding: 5px;
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
        .translucent-section {
            background-color: rgba(255, 255, 255, 0.8); /* Fondo blanco translúcido */
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
                            <a class="nav-link" href="index.php">Inicio</a>
                        </li>
                        <li class="nav-item flex-grow-1 text-center">
                            <a class="nav-link active" aria-current="page" href="productos.php">Productos</a>
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
                            <?= htmlspecialchars($nombreUsuario); ?> |
                            <a href="perfil.php">Perfil</a> |
                            <a href="logout.php">Cerrar sesión</a>
                        </span>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </h1>
</div>

<script src="js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

<div class="container my-5">
    <section class="my-5 translucent-section">
        <h2 class="text-center">Nuestras Cervezas</h2>
        <div class="row">
            <div class="col-md-4 text-center mb-4">
                <div class="card shadow-sm">
                    <img src="img/cerveza1.jpg" class="card-img-top" alt="Cerveza 1">
                    <div class="card-body">
                        <h5 class="card-title">Cerveza Clásica</h5>
                        <p class="card-text">Cerveza artesanal con notas de malta y un toque refrescante.</p>
                        <select class="form-select mb-3" id="sizeCervezaClasica">
                            <option value="30L">Barril de 30 litros</option>
                            <option value="50L">Barril de 50 litros</option>
                        </select>
                        <button class="btn btn-primary w-100">Agregar a la Orden</button>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-center mb-4">
                <div class="card shadow-sm">
                    <img src="img/cerveza2.jpg" class="card-img-top" alt="Cerveza 2">
                    <div class="card-body">
                        <h5 class="card-title">Cerveza Rubia</h5>
                        <p class="card-text">Sabor suave y refrescante, perfecta para cualquier ocasión.</p>
                        <select class="form-select mb-3" id="sizeCervezaRubia">
                            <option value="30L">Barril de 30 litros</option>
                            <option value="50L">Barril de 50 litros</option>
                        </select>
                        <button class="btn btn-primary w-100">Agregar a la Orden</button>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-center mb-4">
                <div class="card shadow-sm">
                    <img src="img/cerveza3.jpg" class="card-img-top" alt="Cerveza 3">
                    <div class="card-body">
                        <h5 class="card-title">Cerveza Negra</h5>
                        <p class="card-text">Intensa y con cuerpo, una cerveza para los amantes de sabores fuertes.</p>
                        <select class="form-select mb-3" id="sizeCervezaNegra">
                            <option value="30L">Barril de 30 litros</option>
                            <option value="50L">Barril de 50 litros</option>
                        </select>
                        <button class="btn btn-primary w-100">Agregar a la Orden</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
<!-- Lista de Orden de Compra -->
<section class="my-5 translucent-section p-4">
    <h3 class="text-center">Orden de Compra</h3>
    <ul id="orderList" class="list-group mb-3"></ul>
    <div class="d-flex">
      <button class="btn btn-warning w-50 me-1" onclick="clearOrder()">Vaciar Orden</button>
      <button class="btn btn-success w-50 ms-1" onclick="checkout()">Finalizar Compra</button>
    </div>
  </section>
</div>

<script>
  // Función para agregar productos a la orden de compra con el tamaño de barril seleccionado
  function addToOrder(productName, sizeId) {
    const sizeSelect = document.getElementById(sizeId);
    const selectedSize = sizeSelect.options[sizeSelect.selectedIndex].text;
    const orderList = document.getElementById('orderList');

    // Crear el elemento de lista
    const listItem = document.createElement('li');
    listItem.className = 'list-group-item d-flex justify-content-between align-items-center';
    listItem.textContent = productName + ' - ' + selectedSize;

    // Botón de eliminar
    const deleteButton = document.createElement('button');
    deleteButton.className = 'btn btn-danger btn-sm';
    deleteButton.textContent = 'Eliminar';
    deleteButton.onclick = function() {
      orderList.removeChild(listItem);
    };

    // Agregar botón de eliminar al elemento de lista
    listItem.appendChild(deleteButton);
    orderList.appendChild(listItem);
  }

  // Función para vaciar la orden de compra completa
  function clearOrder() {
    document.getElementById('orderList').innerHTML = ''; // Vaciar la lista de orden
  }

  // Función para finalizar la compra
  function checkout() {
    alert("Tu orden ha sido procesada. Gracias por tu compra!");
    clearOrder(); // Llama a la función de vaciar orden
  }
</script>
</body>
</html>