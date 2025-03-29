<?php
session_start();
require_once("connection.php");

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_name'])) {
    echo json_encode(['success' => false, 'message' => 'Not authorized']);
    exit;
}

// Check if required parameters are present
if (!isset($_POST['order_id']) || !isset($_POST['status'])) {
    echo json_encode(['success' => false, 'message' => 'Missing parameters']);
    exit;
}

$order_id = $_POST['order_id'];
$status = $_POST['status'];

// Verify valid status
$valid_statuses = ['Preparing', 'Delivering', 'Collected', 'Complete', 'Cancelled'];
if (!in_array($status, $valid_statuses)) {
    echo json_encode(['success' => false, 'message' => 'Invalid status']);
    exit;
}

try {
    // Get current order status
    $stmt = $_db->prepare("
        SELECT o.OrderStatus, o.UserID, u.Username 
        FROM orders o 
        JOIN users u ON o.UserID = u.UserID 
        WHERE o.OrderNo = ?
    ");
    $stmt->execute([$order_id]);
    $order = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$order) {
        echo json_encode(['success' => false, 'message' => 'Order not found']);
        exit;
    }

    // Define valid status transitions
    $valid_transitions = [
        'Preparing' => ['Delivering'],
        'Delivering' => ['Collected'],
        'Collected' => ['Complete'],
        'Complete' => [],
        'Cancelled' => []
    ];

    // Check if status transition is valid
    if (!isset($valid_transitions[$order['OrderStatus']]) || 
        !in_array($status, $valid_transitions[$order['OrderStatus']])) {
        echo json_encode(['success' => false, 'message' => 'Invalid status transition']);
        exit;
    }

    // Update the order status
    $updateStmt = $_db->prepare("UPDATE orders SET OrderStatus = ? WHERE OrderNo = ?");
    $updateStmt->execute([$status, $order_id]);

    echo json_encode([
        'success' => true,
        'message' => 'Order status updated successfully',
        'newStatus' => $status
    ]);

} catch (Exception $e) {
    error_log($e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Database error']);
}
?>