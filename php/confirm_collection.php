<?php
session_start();
require_once("connection.php");

if (!isset($_SESSION['user_name'])) {
    echo json_encode(['success' => false, 'message' => 'Please login first']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];
    $username = $_SESSION['user_name'];

    try {
        // Get user ID
        $stmt = $_db->prepare("SELECT UserID FROM users WHERE UserName = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            echo json_encode(['success' => false, 'message' => 'User not found']);
            exit();
        }

        // Check if order belongs to user and is in delivering status
        $stmt = $_db->prepare("
            SELECT OrderNo, OrderStatus 
            FROM orders 
            WHERE OrderNo = ? AND UserID = ? AND OrderStatus = 'Delivering'
        ");
        $stmt->execute([$order_id, $user['UserID']]);
        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$order) {
            echo json_encode(['success' => false, 'message' => 'Order not found or not eligible for collection']);
            exit();
        }

        // Update order status to Collected
        $stmt = $_db->prepare("UPDATE orders SET OrderStatus = 'Collected' WHERE OrderNo = ?");
        $stmt->execute([$order_id]);

        echo json_encode(['success' => true, 'message' => 'Order collection confirmed successfully']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
} 