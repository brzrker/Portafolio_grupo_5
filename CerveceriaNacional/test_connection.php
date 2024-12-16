<?php
require_once 'db_config.php';

if ($conexion) {
    echo "Conexión exitosa a la base de datos.";
} else {
    echo "Error al conectar con la base de datos.";
}
?>
