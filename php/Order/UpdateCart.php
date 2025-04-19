<?php
session_start();
require_once "../base.php";

header('Content-Type: application/json');

if (!isset($_SESSION['user_name'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Please login first'
    ]);
    exit;
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $book_id = $_POST['book_id'] ?? null;
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 0;
    
    if (!isset($_SESSION['cart'][$book_id])) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Book not found in cart'
        ]);
        exit;
    }

    if ($quantity <= 0) {
        // Remove item from cart
        unset($_SESSION['cart'][$book_id]);
        echo json_encode([
            'status' => 'success',
            'message' => 'Item removed from cart',
            'action' => 'remove'
        ]);
    } else {
        // Update quantity
        $_SESSION['cart'][$book_id]['Quantity'] = $quantity;
        echo json_encode([
            'status' => 'success',
            'message' => 'Quantity updated',
            'action' => 'update'
        ]);
    }
}
?>