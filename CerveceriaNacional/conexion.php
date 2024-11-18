<?php
// Parámetros de conexión
$servidor = "localhost";
$usuario = "root";
$password = "";
$base_datos = "CerveceriaNacional";

// Crear conexión
$conexion = new mysqli($servidor, $usuario, $password, $base_datos);

// Verificar conexión
if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}

// Opcional: Configurar el juego de caracteres
$conexion->set_charset("utf8");

?>