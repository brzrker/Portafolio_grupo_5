<?php
session_start();
include("conexion.php");

// Verifica si la sesión está activa
if (!isset($_SESSION['id_usuario'])) {
    echo "<script>alert('Debes iniciar sesión para acceder a los productos.'); window.location.href='login.php';</script>";
    exit();
}

// Obtener el nombre del usuario de la sesión
$nombreUsuario = $_SESSION['nombre'] ?? 'Usuario';
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
                <ul class="navbar-nav w-100 d-flex justify-content-around">
                    <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link active" href="productos.php">Productos</a></li>
                    <li class="nav-item"><a class="nav-link" href="nosotros.php">Conócenos</a></li>
                    <li class="nav-item"><a class="nav-link" href="contacto.php">Contáctanos</a></li>
                </ul>
                <?php if (isset($_SESSION['id_usuario'])): ?>
                    <span class="navbar-text">
                        <?= htmlspecialchars($nombreUsuario); ?> |
                        <a href="perfil.php">Perfil</a> |
                        <a href="logout.php">Cerrar sesión</a>
                    </span>
                <?php endif; ?>
            </div>
        </nav>
    </h1>
</div>

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
                        <button class="btn btn-primary w-100" onclick="addToOrder('Cerveza Clásica', 'sizeCervezaClasica')">Agregar a la Orden</button>
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
                        <button class="btn btn-primary w-100" onclick="addToOrder('Cerveza Rubia', 'sizeCervezaRubia')">Agregar a la Orden</button>
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
                        <button class="btn btn-primary w-100" onclick="addToOrder('Cerveza Negra', 'sizeCervezaNegra')">Agregar a la Orden</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
  let order = [];
  function addToOrder(productName, sizeId) {
    const sizeSelect = document.getElementById(sizeId);
    const selectedSize = sizeSelect.options[sizeSelect.selectedIndex].text;
    order.push({ name: productName, size: selectedSize });
    updateOrderList();
  }

  function updateOrderList() {
    const orderList = document.getElementById('orderList');
    orderList.innerHTML = '';
    order.forEach((item, index) => {
      const listItem = document.createElement('li');
      listItem.className = 'list-group-item d-flex justify-content-between align-items-center';
      listItem.textContent = `${item.name} - ${item.size}`;
      const deleteButton = document.createElement('button');
      deleteButton.className = 'btn btn-danger btn-sm';
      deleteButton.textContent = 'Eliminar';
      deleteButton.onclick = () => {
        order.splice(index, 1);
        updateOrderList();
      };
      listItem.appendChild(deleteButton);
      orderList.appendChild(listItem);
    });
  }

  function clearOrder() {
    order = [];
    updateOrderList();
  }

  function checkout() {
    if (order.length === 0) {
      alert('Tu orden está vacía.');
      return;
    }

    const userId = <?= json_encode($_SESSION['id_usuario']); ?>;

    fetch('registrar_orden.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ userId, order })
    })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          alert('Orden registrada correctamente. ¡Gracias por tu compra!');
          clearOrder();
        } else {
          alert('Error al registrar la orden: ' + data.message);
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('Hubo un problema al procesar tu orden.');
      });
  }
</script>
</body>
</html>
