<?php
session_start();
include("conexion.php");

// Verifica si el método de solicitud es POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
    exit();
}

// Verifica si el usuario está autenticado
if (!isset($_SESSION['id_usuario'])) {
    echo json_encode(['success' => false, 'message' => 'Usuario no autenticado.']);
    exit();
}

// Decodifica los datos recibidos en formato JSON
$input = json_decode(file_get_contents('php://input'), true);

$userId = $input['userId'] ?? null;
$order = $input['order'] ?? [];

if (!$userId || empty($order)) {
    echo json_encode(['success' => false, 'message' => 'Datos de la orden incompletos.']);
    exit();
}

// Inicia la transacción
$conexion->begin_transaction();

try {
    // Inserta una nueva orden en la tabla "ordenes"
    $queryOrden = $conexion->prepare("INSERT INTO ordenes (id_usuario, fecha) VALUES (?, NOW())");
    $queryOrden->bind_param("i", $userId);
    $queryOrden->execute();

    // Obtiene el ID de la orden recién creada
    $orderId = $conexion->insert_id;

    // Inserta los detalles de la orden en la tabla "detalles_orden"
    $queryDetalle = $conexion->prepare("INSERT INTO detalles_orden (id_orden, producto, tamaño) VALUES (?, ?, ?)");

    foreach ($order as $item) {
        $productName = $item['name'];
        $productSize = $item['size'];
        $queryDetalle->bind_param("iss", $orderId, $productName, $productSize);
        $queryDetalle->execute();
    }

    // Confirma la transacción
    $conexion->commit();

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    // Si ocurre un error, revierte la transacción
    $conexion->rollback();

    echo json_encode(['success' => false, 'message' => 'Error al registrar la orden.']);
} finally {
    $queryOrden->close();
    $queryDetalle->close();
    $conexion->close();
}
?>
