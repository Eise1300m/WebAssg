<?php
session_start();
require_once("connection.php");

if (!isset($_SESSION['user_name']) || empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit;
}

$user_id = $_SESSION['user_name']; // Assuming username is used as Customer ID
$order_date = date("Y-m-d H:i:s");
$totalQuantity = 0;
$totalPrice = 0;

try {
    $_db->beginTransaction();

    // Insert new order
    $stmt = $_db->prepare("INSERT INTO `order` (OrderDate, TotalQuantity, OrderPrice, CustomerID) 
                           VALUES (?, ?, ?, ?)");
    $stmt->execute([$order_date, 0, 0, $user_id]);

    // Get last inserted Order ID
    $order_id = $_db->lastInsertId();

    // Insert items into `order_details`
    foreach ($_SESSION['cart'] as $book) {
        $subtotal = $book['Price'] * $book['Quantity'];
        $stmt = $_db->prepare("INSERT INTO order_details (OrderNo, BookNo, Quantity, Price) 
                               VALUES (?, ?, ?, ?)");
        $stmt->execute([$order_id, $book['BookNo'], $book['Quantity'], $subtotal]);

        $totalQuantity += $book['Quantity'];
        $totalPrice += $subtotal;
    }

    // Update order total values
    $stmt = $_db->prepare("UPDATE `order` SET TotalQuantity = ?, OrderPrice = ? WHERE OrderNo = ?");
    $stmt->execute([$totalQuantity, $totalPrice, $order_id]);

    $_db->commit();

    // Store order ID in session for payment
    $_SESSION['order_id'] = $order_id;

    // Clear cart after successful order
    unset($_SESSION['cart']);

    // Redirect to payment
    header("Location: Payment.php");
    exit;
} catch (PDOException $e) {
    $_db->rollBack();
    die("Checkout failed: " . $e->getMessage());
}
?>
