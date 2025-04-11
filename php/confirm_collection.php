<?php
session_start();
require_once("connection.php");

// Check if user is logged in
if (!isset($_SESSION['user_name'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

// Check if order_id is provided
if (!isset($_POST['order_id']) || empty($_POST['order_id'])) {
    echo json_encode(['success' => false, 'message' => 'Order ID is required']);
    exit;
}

$order_id = $_POST['order_id'];
$username = $_SESSION['user_name'];

// Get user ID
$stmt = $_db->prepare("SELECT UserID FROM users WHERE UserName = ?");
$stmt->execute([$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo json_encode(['success' => false, 'message' => 'User not found']);
    exit;
}

$user_id = $user['UserID'];

// Verify the order belongs to the user
$stmt = $_db->prepare("SELECT * FROM orders WHERE OrderNo = ? AND UserID = ?");
$stmt->execute([$order_id, $user_id]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    echo json_encode(['success' => false, 'message' => 'Order not found or does not belong to you']);
    exit;
}

// Update order status to 'Collected'
$stmt = $_db->prepare("UPDATE orders SET OrderStatus = 'Collected' WHERE OrderNo = ?");
$result = $stmt->execute([$order_id]);

if ($result) {
    echo json_encode(['success' => true, 'message' => 'Order collection confirmed successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update order status']);
} 