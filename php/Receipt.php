<?php
session_start();
require_once("connection.php");

if (!isset($_SESSION['order_id'])) {
    header("Location: Cart.php");
    exit;
}

$order_id = $_SESSION['order_id'];

// Get order information
$stmt = $_db->prepare("
    SELECT o.*, u.Username, u.Email, u.ContactNo 
    FROM orders o 
    JOIN users u ON o.UserID = u.UserID 
    WHERE o.OrderNo = ?
");
$stmt->execute([$order_id]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    die("Order not found.");
}

// Get order items
$stmt = $_db->prepare("
    SELECT od.*, b.BookName, b.BookImage
    FROM orderdetails od 
    JOIN book b ON od.BookNo = b.BookNo 
    WHERE od.OrderNo = ?
");
$stmt->execute([$order_id]);
$order_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get shipping address
$stmt = $_db->prepare("
    SELECT * FROM address WHERE UserID = ?
");
$stmt->execute([$order['UserID']]);
$address = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt - Secret Shelf</title>
    <link rel="stylesheet" href="../css/HomeStyles.css">
    <link rel="stylesheet" href="../css/NavbarStyles.css">
    <link rel="stylesheet" href="../css/FooterStyles.css">
    <link rel="stylesheet" href="../css/ReceiptStyles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="../img/Logo.png">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/order.js" defer></script>
</head>
<body>
    <?php include_once("navbar.php") ?>

    <div class="receipt-container">
        <div class="receipt-header">
            <h1>Purchase Receipt</h1>
            <p>Thank you for your order at Secret Shelf!</p>
        </div>
        
        <div class="order-info">
            <div class="order-details">
                <div class="section-title">Order Information</div>
                <div class="info-row">
                    <span class="info-label">Order Number:</span>
                    <span><?php echo $order['OrderNo']; ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Order Date:</span>
                    <span><?php echo date('F j, Y g:i A', strtotime($order['OrderDate'])); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Payment Method:</span>
                    <span><?php echo $order['PaymentType']; ?></span>
                </div>
            </div>
            
            <div class="customer-details">
                <div class="section-title">Customer Information</div>
                <div class="info-row">
                    <span class="info-label">Name:</span>
                    <span><?php echo htmlspecialchars($order['Username']); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email:</span>
                    <span><?php echo htmlspecialchars($order['Email']); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Phone:</span>
                    <span><?php echo htmlspecialchars($order['ContactNo']); ?></span>
                </div>
            </div>
        </div>
        
        <?php if ($address): ?>
        <div class="shipping-address">
            <div class="section-title">Shipping Address</div>
            <div class="address-content">
                <?php echo htmlspecialchars($address['Street']); ?><br>
                <?php echo htmlspecialchars($address['City']) . ', ' . htmlspecialchars($address['State']) . ' ' . htmlspecialchars($address['PostalCode']); ?><br>
                <?php echo htmlspecialchars($address['Country']); ?>
            </div>
        </div>
        <?php endif; ?>
        
        <div class="order-items">
            <div class="section-title">Order Items</div>
            <table class="order-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($order_items as $item): ?>
                    <tr>
                        <td>
                            <div class="book-info">
                                <img src="<?php echo $item['BookImage'] ?: '../img/no-cover.png'; ?>" 
                                     alt="<?php echo htmlspecialchars($item['BookName']); ?>" 
                                     class="book-thumbnail">
                                <span><?php echo htmlspecialchars($item['BookName']); ?></span>
                            </div>
                        </td>
                        <td><?php echo $item['Quantity']; ?></td>
                        <td>RM <?php echo number_format($item['Price'], 2); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <div class="order-total">
                <div>Total Items: <?php echo $order['TotalQuantity']; ?></div>
                <div>Total Amount: RM <?php echo number_format($order['TotalAmount'], 2); ?></div>
            </div>
        </div>
        
        <button class="print-button" id="print-receipt">
            <i class="fas fa-print"></i> Print Receipt
        </button>
        
        <div class="thank-you">
            <p>Thank you for shopping with us!</p>
            <a href="index.php" class="continue-shopping">Continue Shopping</a>
        </div>
    </div>

    <?php include_once('footer.php') ?>
</body>
</html>