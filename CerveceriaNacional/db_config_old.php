<?php
// Configuración de la conexión a la base de datos
$host = "localhost";
$user = "root";
$password = ""; 
$database = "CerveceriaNacional";

// Crear conexión
$conexion = new mysqli($host, $user, $password, $database);

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Configuración de charset para evitar problemas con caracteres especiales
$conexion->set_charset("utf8");
?>
