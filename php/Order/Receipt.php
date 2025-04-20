<?php
session_start();
require_once("../base.php");
includeNavbar();

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
    <link rel="stylesheet" href="../../css/NavbarStyles.css">
    <link rel="stylesheet" href="../../css/FooterStyles.css">
    <link rel="stylesheet" href="../../css/ReceiptStyles.css">
    <link rel="icon" type="image/x-icon" href="/WebAssg/img/Logo.png">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../../js/order.js" defer></script>
    <script src="../../js/Scripts.js"></script>
</head>
<body>

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
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    // Get book details from the book table
                    foreach ($order_items as $item): 
                        $stmt = $_db->prepare("SELECT BookName, BookPrice, BookImage FROM book WHERE BookNo = ?");
                        $stmt->execute([$item['BookNo']]);
                        $book = $stmt->fetch(PDO::FETCH_ASSOC);
                        $itemTotal = $book['BookPrice'] * $item['Quantity'];
                    ?>
                    <tr>
                        <td>
                            <div class="book-info">
                                <img src="<?= str_replace('../', '/WebAssg/', htmlspecialchars($book['BookImage'])) ?: '../../img/no-cover.png'; ?>" 
                                     alt="<?php echo htmlspecialchars($book['BookName']); ?>" 
                                     class="book-thumbnail">
                                <span><?php echo htmlspecialchars($book['BookName']); ?></span>
                            </div>
                        </td>
                        <td><?php echo $item['Quantity']; ?></td>
                        <td>RM <?php echo number_format($book['BookPrice'], 2); ?></td>
                        <td>RM <?php echo number_format($itemTotal, 2); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <div class="price-breakdown">
                <div class="section-title">Price Details</div>
                <div class="breakdown-details">
                    <?php
                    if (isset($_SESSION['order_details'])):
                        $orderDetails = $_SESSION['order_details'];
                    ?>
                    <div class="breakdown-row">
                        <span>Subtotal:</span>
                        <span>RM <?php echo number_format($orderDetails['subtotal'], 2); ?></span>
                    </div>
                    
                    <?php if ($orderDetails['is_first_order']): ?>
                    <div class="breakdown-row discount">
                        <span>First Order Discount (20%):</span>
                        <span>-RM <?php echo number_format($orderDetails['discount'], 2); ?></span>
                    </div>
                    <?php endif; ?>

                    <div class="breakdown-row">
                        <span>Shipping Fee:</span>
                        <span>RM <?php echo number_format($orderDetails['shipping'], 2); ?></span>
                    </div>
                    
                    <div class="breakdown-row total">
                        <span>Total Amount:</span>
                        <span>RM <?php echo number_format($orderDetails['total'], 2); ?></span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <button class="print-button" id="print-receipt">
            <img src="/WebAssg/upload/icon/print.png" alt="Print" class="button-icon" style="width: 20px; height: 20px;">
            Print Receipt
        </button>
        
        <div class="thank-you">
            <p>Thank you for shopping with us!</p>
            <a href="../MainPage.php" class="continue-shopping-btn">
                <img src="/WebAssg/upload/icon/shoppingbag.png" alt="Shopping Bag">
                Continue Shopping
            </a>
        </div>
    </div>

    <?php include_once('../footer.php') ?>
</body>

</html>