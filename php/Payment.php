<?php
session_start();
require_once("connection.php");

if (!isset($_SESSION['order_id'])) {
    header("Location: cart.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $payment_type = $_POST['payment_type'];
    $order_id = $_SESSION['order_id'];

    $stmt = $_db->prepare("UPDATE `order` SET PaymentType = ? WHERE OrderNo = ?");
    $stmt->execute([$payment_type, $order_id]);

    header("Location: receipt.php");
    exit;
}
?>

<form method="post">
    <h2>Select Payment Method</h2>
    <label><input type="radio" name="payment_type" value="Credit Card" required> Credit Card</label><br>
    <label><input type="radio" name="payment_type" value="PayPal" required> PayPal</label><br>
    <label><input type="radio" name="payment_type" value="Bank Transfer" required> Bank Transfer</label><br>
    <button type="submit">Confirm Payment</button>
</form>
