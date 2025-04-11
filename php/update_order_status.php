<?php
session_start();
require_once("connection.php");

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id']) && isset($_POST['new_status'])) {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['new_status'];
    
    try {
        // Check if order exists
        $stmt = $_db->prepare("SELECT OrderStatus FROM orders WHERE OrderNo = ?");
        $stmt->execute([$order_id]);
        $order = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$order) {
            echo json_encode(['success' => false, 'message' => 'Order not found']);
            exit();
        }
        
        // Validate status transition
        $validTransitions = [
            'Preparing' => ['Delivering', 'Cancelled'],
            'Delivering' => ['Collected', 'Complete'],
            'Collected' => ['Complete']
        ];
        
        if (!isset($validTransitions[$order['OrderStatus']]) || 
            !in_array($new_status, $validTransitions[$order['OrderStatus']])) {
            echo json_encode(['success' => false, 'message' => 'Invalid status transition']);
            exit();
        }
        
        // Update order status
        $stmt = $_db->prepare("UPDATE orders SET OrderStatus = ? WHERE OrderNo = ?");
        $stmt->execute([$new_status, $order_id]);
        
        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
} 