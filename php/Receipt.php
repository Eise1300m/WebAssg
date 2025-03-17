<?php
session_start();
require_once("connection.php");

require_once("navbar.php");

if (!isset($_SESSION['order_id'])) {
    header("Location: Cart.php");
    exit;
}

$order_id = $_SESSION['order_id'];

$stmt = $_db->prepare("SELECT * FROM `orders` WHERE OrderNo = ?");
$stmt->execute([$order_id]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $_db->prepare("SELECT * FROM orderdetails od JOIN book b ON od.BookNo = b.BookNo WHERE od.OrderNo = ?");
$stmt->execute([$order_id]);
$order_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<h2>Receipt</h2>";
echo "<p>Order No: {$order['OrderNo']}</p>";
echo "<p>Order Date: {$order['OrderDate']}</p>";
echo "<p>Payment Type: {$order['PaymentType']}</p>";
echo "<table border='1'>
        <tr><th>Book</th><th>Quantity</th><th>Price</th></tr>";

foreach ($order_items as $item) {
    echo "<tr><td>{$item['BookName']}</td><td>{$item['Quantity']}</td><td>RM" . number_format($item['Price'], 2) . "</td></tr>";
}

echo "</table>";
echo "<h3>Total Price: RM" . number_format($order['TotalAmount'], 2) . "</h3>";
?>
