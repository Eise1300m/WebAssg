<?php
session_start();
require_once("connection.php");

if (!isset($_SESSION['user_name'])) {
    $_SESSION['login_error'] = "Please log in first."; // Store message in session
    header("Location: CustomerLogin.php"); // Redirect to login page
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $book_id = $_POST['book_id'];
    
    $stmt = $_db->prepare("SELECT * FROM book WHERE BookNo = ?");
    $stmt->execute([$book_id]);
    $book = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$book) {
        echo "Invalid book!";
        exit;
    }

    // Initialize cart session if not set
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Add book to cart (increment quantity if already in cart)
    if (isset($_SESSION['cart'][$book_id])) {
        $_SESSION['cart'][$book_id]['Quantity'] += 1;
    } else {
        $_SESSION['cart'][$book_id] = [
            'BookNo' => $book_id,
            'BookName' => $book['BookName'],
            'Price' => $book['BookPrice'],
            'Quantity' => 1
        ];
    }

    echo "Book added to cart!";
}
?>
