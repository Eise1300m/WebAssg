<?php
session_start();
require_once("connection.php");
header('Content-Type: application/json');

if (!isset($_SESSION['user_name'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Please log in first.'
    ]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $book_id = $_POST['book_id'];
    // Get quantity from POST and ensure it's at least 1
    $quantity = isset($_POST['quantity']) ? max(1, intval($_POST['quantity'])) : 1;
    
    // Check if book exists in database
    $stmt = $_db->prepare("SELECT BookNo, BookName, BookPrice, BookImage FROM book WHERE BookNo = ?");
    $stmt->execute([$book_id]);
    $book = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$book) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid book!'
        ]);
        exit;
    }

    // Initialize cart if not set
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Check current quantity and add to cart
    if (isset($_SESSION['cart'][$book_id])) {
        $current_quantity = $_SESSION['cart'][$book_id]['Quantity'];
        $new_quantity = $current_quantity + $quantity;
        
        if ($new_quantity > 10) {
            // Cap at maximum 10 items
            $new_quantity = 10;
            $message = "Maximum quantity (10) reached for this book";
        } else {
            $message = "Book quantity updated in cart!";
        }
        
        $_SESSION['cart'][$book_id]['Quantity'] = $new_quantity;
        
    } else {
        // Ensure quantity doesn't exceed 10 for new items too
        if ($quantity > 10) {
            $quantity = 10;
        }
        
        $_SESSION['cart'][$book_id] = [
            'BookNo' => $book_id,
            'BookName' => $book['BookName'],
            'Price' => $book['BookPrice'],
            'Quantity' => $quantity,
            'BookImage' => $book['BookImage']
        ];
        $message = "Book added to cart!";
    }

    echo json_encode([
        'status' => 'success',
        'message' => $message
    ]);
}
?>