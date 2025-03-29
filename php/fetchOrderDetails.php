<?php
session_start();
require_once("connection.php");

header('Content-Type: application/json');

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    echo json_encode(['error' => 'Unauthorized access']);
    exit();
}

if (!isset($_POST['order_id'])) {
    echo json_encode(['error' => 'No order ID provided']);
    exit();
}

try {
    $orderId = $_POST['order_id'];
    
    // Get order information with user and address details
    $stmt = $_db->prepare("
        SELECT 
            o.*,
            u.Username,
            u.Email,
            u.ContactNo,
            CONCAT(a.Street, ', ', a.City, ', ', a.State, ' ', a.PostalCode) as ShippingAddress
        FROM orders o
        JOIN users u ON o.UserID = u.UserID
        LEFT JOIN address a ON u.UserID = a.UserID
        WHERE o.OrderNo = ?
    ");
    $stmt->execute([$orderId]);
    $order = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$order) {
        echo json_encode(['error' => 'Order not found']);
        exit();
    }
    
    // Get order items with book details
    $stmt = $_db->prepare("
        SELECT 
            od.*,
            b.BookName,
            b.BookImage,
            b.Author
        FROM orderdetails od
        JOIN book b ON od.BookNo = b.BookNo
        WHERE od.OrderNo = ?
    ");
    $stmt->execute([$orderId]);
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Prepare the response
    $response = [
        'success' => true,
        'order' => [
            'OrderNo' => $order['OrderNo'],
            'OrderDate' => $order['OrderDate'],
            'OrderStatus' => $order['OrderStatus'],
            'PaymentType' => $order['PaymentType'],
            'TotalAmount' => $order['TotalAmount'],
            'TotalQuantity' => $order['TotalQuantity'],
            'Username' => $order['Username'],
            'Email' => $order['Email'],
            'ContactNo' => $order['ContactNo'],
            'ShippingAddress' => $order['ShippingAddress']
        ],
        'items' => array_map(function($item) {
            return [
                'BookName' => $item['BookName'],
                'Author' => $item['Author'],
                'Quantity' => $item['Quantity'],
                'Price' => $item['Price'],
                'BookImage' => $item['BookImage'] ?? '../upload/bookPfp/default-book.png'
            ];
        }, $items)
    ];
    
    echo json_encode($response);
    
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    echo json_encode(['error' => 'Database error occurred']);
}
?> 