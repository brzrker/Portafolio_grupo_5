<?php

$serverName = " 35.232.8.173,1433"; // Reemplaza con la IP de tu servidor SQL Server
$connectionOptions = [
    "Database" => "cerveceria",
    "Uid" => "sqlserver",
    "PWD" => "1q2w3e4r",
    "CharacterSet" => "UTF-8"
];
// Establecer conexión
$conexion = sqlsrv_connect($serverName, $connectionOptions);

// Verificar conexión
if ($conexion === false) {
    die("Error al conectar con la base de datos: " . print_r(sqlsrv_errors(), true));
}
?>
