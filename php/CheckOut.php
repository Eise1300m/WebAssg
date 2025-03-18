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
    // Retrieve UserID and check if address exists
    $stmt = $_db->prepare("SELECT u.UserID, COUNT(a.AddressID) as address_count 
                           FROM users u 
                           LEFT JOIN address a ON u.UserID = a.UserID 
                           WHERE u.Username = ?
                           GROUP BY u.UserID");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        throw new Exception("User does not exist.");
    }

    // Check if user has an address
    if ($user['address_count'] == 0) {
        // No address found, redirect to profile page with message
        $_SESSION['checkout_message'] = "Please add a shipping address before checkout.";
        header("Location: UserEditProfile.php");
        exit;
    }

    $user_id = $user['UserID']; // ✅ Now using the correct numeric UserID

    $_db->beginTransaction();

    // Insert new order using correct UserID
    $stmt = $_db->prepare("INSERT INTO `orders` (OrderDate, TotalQuantity, TotalAmount, PaymentType, UserID) 
                           VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$order_date, 0, 0, 'Pending', $user_id]);

    // Get last inserted Order ID
    $order_id = $_db->lastInsertId();

    // Insert items into orderdetails
    foreach ($_SESSION['cart'] as $book) {
        $subtotal = $book['Price'] * $book['Quantity'];
        $stmt = $_db->prepare("INSERT INTO orderdetails (OrderNo, BookNo, Quantity, Price) 
                               VALUES (?, ?, ?, ?)");
        $stmt->execute([$order_id, $book['BookNo'], $book['Quantity'], $subtotal]);

        $totalQuantity += $book['Quantity'];
        $totalPrice += $subtotal;
    }

    // Update order total values
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
    if ($_db->inTransaction()) {
        $_db->rollBack();
    }
    die("Checkout failed: " . $e->getMessage());
}
?>
