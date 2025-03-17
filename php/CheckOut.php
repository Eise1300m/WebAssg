<?php
session_start();
require_once("connection.php");

if (!isset($_SESSION['user_name']) || empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit;
}

$username = $_SESSION['user_name']; // Username stored in session
date_default_timezone_set("Asia/Kuala_Lumpur"); // Change to your timezone
$order_date = date("Y-m-d H:i:s");
$totalQuantity = 0;
$totalPrice = 0;

try {
    $_db->beginTransaction();

    // 🔹 Step 1: Retrieve actual UserID from the users table
    $stmt = $_db->prepare("SELECT UserID FROM users WHERE UserName = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        throw new Exception("User does not exist.");
    }

    $user_id = $user['UserID']; // ✅ Now using the correct numeric UserID

    // 🔹 Step 2: Insert new order using correct UserID
    $stmt = $_db->prepare("INSERT INTO `orders` (OrderDate, TotalQuantity, TotalAmount, UserID) 
                           VALUES (?, ?, ?, ?)");
    $stmt->execute([$order_date, 0, 0, $user_id]);

    // 🔹 Step 3: Get last inserted Order ID
    $order_id = $_db->lastInsertId();

    // 🔹 Step 4: Insert items into `order_details`
    foreach ($_SESSION['cart'] as $book) {
        $subtotal = $book['Price'] * $book['Quantity'];
        $stmt = $_db->prepare("INSERT INTO orderdetails (OrderNo, BookNo, Quantity, Price) 
                               VALUES (?, ?, ?, ?)");
        $stmt->execute([$order_id, $book['BookNo'], $book['Quantity'], $subtotal]);

        $totalQuantity += $book['Quantity'];
        $totalPrice += $subtotal;
    }

    // 🔹 Step 5: Update order total values
    $stmt = $_db->prepare("UPDATE `orders` SET TotalQuantity = ?, TotalAmount = ? WHERE OrderNo = ?");
    $stmt->execute([$totalQuantity, $totalPrice, $order_id]);

    $_db->commit();

    // Store order ID in session for payment
    $_SESSION['order_id'] = $order_id;

    // Clear cart after successful order
    unset($_SESSION['cart']);

    // Redirect to payment
    header("Location: Payment.php");
    exit;
} catch (Exception $e) {
    $_db->rollBack();
    die("Checkout failed: " . $e->getMessage());
}
?>
