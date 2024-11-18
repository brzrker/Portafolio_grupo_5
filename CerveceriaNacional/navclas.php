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
                    <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>" href="index.php">Inicio</a>
                </li>
                <li class="nav-item flex-grow-1 text-center">
                    <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'productos.php' ? 'active' : '' ?>" href="productos.php">Productos</a>
                </li>
                <li class="nav-item flex-grow-1 text-center">
                    <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'nosotros.php' ? 'active' : '' ?>" href="nosotros.php">Conócenos</a>
                </li>
                <li class="nav-item flex-grow-1 text-center">
                    <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'contacto.php' ? 'active' : '' ?>" href="contacto.php">Contáctanos</a>
                </li>

                <?php if (isset($_SESSION['id_usuario'])): ?>
                    <?php
                    // Obtener el nombre del usuario desde la base de datos
                    $id_usuario = $_SESSION['id_usuario'];
                    $query = "SELECT nombre FROM Usuarios WHERE id_usuario = ?";
                    $stmt = $conexion->prepare($query);
                    $stmt->bind_param("i", $id_usuario);
                    $stmt->execute();
                    $resultado = $stmt->get_result();
                    $usuario = $resultado->fetch_assoc();
                    ?>
                    <li class="nav-item flex-grow-1 text-center">
                        <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'perfil.php' ? 'active' : '' ?>" href="perfil.php">
                            <?= htmlspecialchars($usuario['nombre']); ?>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
            <button class="btn btn-custom" type="button" data-bs-toggle="modal" data-bs-target="#loginModal">
                <img src="img/button.png" alt="Icono">
            </button>
        </div>
    </div>
</nav>