<!-- <?php
session_start();
require_once("connection.php");

header('Content-Type: application/json');

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Not authorized']);
    exit;
}

if (!isset($_POST['order_id']) || !isset($_POST['status'])) {
    echo json_encode(['success' => false, 'message' => 'Missing parameters']);
    exit;
}

$order_id = $_POST['order_id'];
$new_status = $_POST['status'];

try {
    $stmt = $_db->prepare("
        SELECT OrderStatus 
        FROM orders 
        WHERE OrderNo = ?
    ");
    $stmt->execute([$order_id]);
    $order = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$order) {
        echo json_encode(['success' => false, 'message' => 'Order not found']);
        exit;
    }

    $current_status = $order['OrderStatus'];

    $valid_transitions = [
        'Preparing' => ['Delivering'],
        'Delivering' => [], 
        'Collected' => ['Complete'],
        'Complete' => [],
        'Cancelled' => []
    ];

    if (!isset($valid_transitions[$current_status]) || 
        !in_array($new_status, $valid_transitions[$current_status])) {
        echo json_encode([
            'success' => false, 
            'message' => 'Invalid status transition from ' . $current_status . ' to ' . $new_status
        ]);
        exit;
    }

    $updateStmt = $_db->prepare("
        UPDATE orders 
        SET OrderStatus = ? 
        WHERE OrderNo = ?
    ");
    $updateStmt->execute([$new_status, $order_id]);

    $stmt = $_db->prepare("
        SELECT o.*, u.Username 
        FROM orders o 
        JOIN users u ON o.UserID = u.UserID 
        WHERE o.OrderNo = ?
    ");
    $stmt->execute([$order_id]);
    $updatedOrder = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'message' => 'Order status updated successfully',
        'order' => [
            'id' => $updatedOrder['OrderNo'],
            'status' => $new_status,
            'customer' => $updatedOrder['Username'],
            'date' => date('M d, Y', strtotime($updatedOrder['OrderDate'])),
            'total' => number_format($updatedOrder['TotalAmount'], 2)
        ]
    ]);

} catch (Exception $e) {
    error_log('Error in adminupdateorderstatus.php: ' . $e->getMessage());
    echo json_encode([
        'success' => false, 
        'message' => 'Database error occurred'
    ]);
}
?>  -->