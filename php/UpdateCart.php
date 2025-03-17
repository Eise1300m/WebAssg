<?php
session_start();

if (!isset($_SESSION['user_name'])) {
    echo json_encode(["status" => "error", "message" => "Please log in first."]);
    exit;
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $book_id = $_POST['book_id'];
    $quantity = (int)$_POST['quantity'];

    if ($quantity <= 0) {
        // Remove item
        unset($_SESSION['cart'][$book_id]);
    } else {
        // Update quantity
        $_SESSION['cart'][$book_id]['Quantity'] = $quantity;
    }

    echo json_encode([
        'status' => 'success',
        'cart_count' => count($_SESSION['cart'])
    ]);
    exit;
}
?>