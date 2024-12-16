<?php
session_start();
include("conexion.php");

// Verifica si el método de solicitud es POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
    exit();
}

// Verifica si el usuario está autenticado
if (!isset($_SESSION['UsuarioID'])) {
    echo json_encode(['success' => false, 'message' => 'Usuario no autenticado.']);
    exit();
}

// Decodifica los datos recibidos en formato JSON
$input = json_decode(file_get_contents('php://input'), true);

// Valida los datos de la orden
if (!isset($input['userId']) || !is_array($input['order']) || empty($input['order'])) {
    echo json_encode(['success' => false, 'message' => 'Datos de la orden incompletos o inválidos.']);
    exit();
}

$userId = intval($input['userId']);
$order = $input['order'];

// Inicia la transacción
sqlsrv_begin_transaction($conexion);

try {
    // Decodificar datos
    $userId = $input['userId'] ?? null;
    $order = $input['order'] ?? [];

    // Validar datos
    if (!$userId || empty($order)) {
        throw new Exception('Datos de la orden incompletos.');
    }

    // Calcular el total
    $total = 0;
    foreach ($order as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    // Registrar en OrdenesCompra
    $sqlOrden = "INSERT INTO OrdenesCompra (UsuarioID, FechaOrden, Total) OUTPUT INSERTED.OrdenID VALUES (?, GETDATE(), ?)";
    $paramsOrden = [$userId, $total];
    $stmtOrden = sqlsrv_query($conexion, $sqlOrden, $paramsOrden);

    if ($stmtOrden === false) {
        throw new Exception('Error al insertar en OrdenesCompra: ' . print_r(sqlsrv_errors(), true));
    }

    $ordenId = sqlsrv_fetch_array($stmtOrden)['OrdenID'];

    // Registrar en DetalleOrden
    $sqlDetalle = "INSERT INTO DetalleOrden (OrdenID, ProductoID, Cantidad, PrecioUnitario) VALUES (?, ?, ?, ?)";
    foreach ($order as $item) {
        $paramsDetalle = [$ordenId, $item['productId'], $item['quantity'], $item['price']];
        $stmtDetalle = sqlsrv_query($conexion, $sqlDetalle, $paramsDetalle);

        if ($stmtDetalle === false) {
            throw new Exception('Error al insertar en DetalleOrden: ' . print_r(sqlsrv_errors(), true));
        }
    }

    sqlsrv_commit($conexion);
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    sqlsrv_rollback($conexion);
    file_put_contents('log_error.txt', 'Error: ' . $e->getMessage()); // Registrar error
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    exit();
}
 finally {
    sqlsrv_close($conexion);
}
?>
