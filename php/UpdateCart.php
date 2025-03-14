<?php
session_start();

if (!isset($_SESSION['user_name'])) {
    echo json_encode(["status" => "error", "message" => "Please log in first."]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $book_id = $_POST['book_id'];
    $quantity = (int)$_POST['quantity']; // Ensure it's an integer

    if (isset($_SESSION['cart'][$book_id])) {
        if ($quantity > 0) {
            $_SESSION['cart'][$book_id]['Quantity'] = $quantity; // Update quantity
        } else {
            unset($_SESSION['cart'][$book_id]); // Remove item if quantity is 0
        }
    }

    // Calculate updated total items
    $total_items = array_sum(array_column($_SESSION['cart'], 'Quantity'));

    echo json_encode(["status" => "success", "cart_count" => $total_items]);
}
?>