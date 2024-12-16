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

$userId = $input['userId'] ?? null;
$order = $input['order'] ?? [];

if (!$userId || empty($order)) {
    echo json_encode(['success' => false, 'message' => 'Datos de la orden incompletos.']);
    exit();
}

// Inicia la transacción
sqlsrv_begin_transaction($conexion);

try {
    // Calcular el total de la orden
    $total = 0;
    foreach ($order as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    // Insertar en la tabla OrdenesCompra
    $sqlOrden = "INSERT INTO OrdenesCompra (UsuarioID, FechaOrden, Total) OUTPUT INSERTED.OrdenID VALUES (?, GETDATE(), ?)";
    $paramsOrden = [$userId, $total];
    $stmtOrden = sqlsrv_query($conexion, $sqlOrden, $paramsOrden);

    if ($stmtOrden === false) {
        throw new Exception('Error al insertar en OrdenesCompra: ' . print_r(sqlsrv_errors(), true));
    }

    $ordenId = sqlsrv_fetch_array($stmtOrden)['OrdenID'];

    // Insertar en la tabla DetalleOrden y actualizar la cantidad en Productos
    $sqlDetalle = "INSERT INTO DetalleOrden (OrdenID, ProductoID, Cantidad, PrecioUnitario) VALUES (?, ?, ?, ?)";
    $sqlUpdateProducto = "UPDATE Productos SET Cantidad = Cantidad - ? WHERE ProductoID = ?";

    foreach ($order as $item) {
        // Verificar que haya suficiente stock antes de actualizar
        $sqlCheckStock = "SELECT Cantidad FROM Productos WHERE ProductoID = ?";
        $stmtCheckStock = sqlsrv_query($conexion, $sqlCheckStock, [$item['productId']]);

        if ($stmtCheckStock === false || ($row = sqlsrv_fetch_array($stmtCheckStock)) === null) {
            throw new Exception('Producto no encontrado o sin stock: ID ' . $item['productId']);
        }

        if ($row['Cantidad'] < $item['quantity']) {
            throw new Exception('No hay suficiente stock para el producto: ID ' . $item['productId']);
        }

        // Insertar detalle de la orden
        $paramsDetalle = [$ordenId, $item['productId'], $item['quantity'], $item['price']];
        $stmtDetalle = sqlsrv_query($conexion, $sqlDetalle, $paramsDetalle);

        if ($stmtDetalle === false) {
            throw new Exception('Error al insertar en DetalleOrden: ' . print_r(sqlsrv_errors(), true));
        }

        // Actualizar la cantidad de barriles en Productos
        $paramsUpdateProducto = [$item['quantity'], $item['productId']];
        $stmtUpdateProducto = sqlsrv_query($conexion, $sqlUpdateProducto, $paramsUpdateProducto);

        if ($stmtUpdateProducto === false) {
            throw new Exception('Error al actualizar la cantidad de productos: ' . print_r(sqlsrv_errors(), true));
        }
    }

    // Confirmar la transacción
    sqlsrv_commit($conexion);

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    // Revertir la transacción en caso de error
    sqlsrv_rollback($conexion);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} finally {
    // Cerrar las conexiones
    sqlsrv_close($conexion);
}
