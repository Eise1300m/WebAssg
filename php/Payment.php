<?php
session_start();
require_once("connection.php");

if (!isset($_SESSION['order_id'])) {
    header("Location: cart.php");
    exit;
}

$order_id = $_SESSION['order_id'];
$payment_error = isset($_SESSION['payment_error']) ? $_SESSION['payment_error'] : '';
unset($_SESSION['payment_error']);

// Fetch order details
try {
    // Get order information
    $orderStmt = $_db->prepare("
        SELECT o.OrderNo, o.OrderDate, o.TotalQuantity, o.TotalAmount, u.Username, u.Email, u.ContactNo 
        FROM orders o
        JOIN users u ON o.UserID = u.UserID
        WHERE o.OrderNo = ?
    ");
    $orderStmt->execute([$order_id]);
    $orderInfo = $orderStmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$orderInfo) {
        header("Location: cart.php");
        exit;
    }
    
    // Get ordered items
    $itemsStmt = $_db->prepare("
        SELECT od.BookNo, od.Quantity, od.Price, b.BookName, b.Author, b.BookImage 
        FROM orderdetails od
        JOIN book b ON od.BookNo = b.BookNo
        WHERE od.OrderNo = ?
    ");
    $itemsStmt->execute([$order_id]);
    $orderItems = $itemsStmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Get user's address if available
    $addressStmt = $_db->prepare("
        SELECT a.* FROM address a
        JOIN users u ON a.UserID = u.UserID
        JOIN orders o ON o.UserID = u.UserID
        WHERE o.OrderNo = ?
        LIMIT 1
    ");
    $addressStmt->execute([$order_id]);
    $address = $addressStmt->fetch(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    die("Error fetching order details: " . $e->getMessage());
}

// Process payment
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['cancel_order'])) {
        // Cancel order and redirect to cart
        $_db->prepare("DELETE FROM orders WHERE OrderNo = ?")->execute([$order_id]);
        unset($_SESSION['order_id']);
        header("Location: cart.php?cancelled=1");
        exit;
    }
    
    if (isset($_POST['payment_type'])) {
        $payment_type = $_POST['payment_type'];
        
        // Simulate payment processing
        $payment_success = true; // In a real app, you'd verify payment here
        
        if ($payment_success) {
            $stmt = $_db->prepare("UPDATE orders SET PaymentType = ? WHERE OrderNo = ?");
            $stmt->execute([$payment_type, $order_id]);
            
            // Redirect to receipt
            header("Location: receipt.php");
            exit;
        } else {
            $_SESSION['payment_error'] = "Payment processing failed. Please try again.";
            header("Location: Payment.php");
            exit;
        }
    } else {
        $_SESSION['payment_error'] = "Please select a payment method.";
        header("Location: Payment.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Your Payment - Secret Shelf</title>
    <link rel="stylesheet" href="../css/NavbarStyles.css">
    <link rel="stylesheet" href="../css/FooterStyles.css">
    <link rel="stylesheet" href="../css/Paymentstyles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/order.js"></script>

</head>
<body>
    <?php include_once("navbar.php") ?>
    
    <div class="payment-container">
        <div class="payment-header">
            <h1>Complete Your Payment</h1>
            <p>Order #<?php echo $orderInfo['OrderNo']; ?></p>
        </div>
        
        <?php if (!empty($payment_error)): ?>
        <div class="error-message">
            <p><?php echo htmlspecialchars($payment_error); ?></p>
        </div>
        <?php endif; ?>
        
        <div class="payment-body">
            <div class="order-summary">
                <h2 class="section-title">Order Summary</h2>
                
                <div class="order-info">
                    <p><strong>Order ID:</strong> #<?php echo $orderInfo['OrderNo']; ?></p>
                    <p><strong>Date:</strong> <?php echo date('F j, Y, g:i a', strtotime($orderInfo['OrderDate'])); ?></p>
                    <p><strong>Items:</strong> <?php echo $orderInfo['TotalQuantity']; ?></p>
                </div>
                
                <div class="customer-info">
                    <h3>Customer Information</h3>
                    <p><strong>Name:</strong> <?php echo htmlspecialchars($orderInfo['Username']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($orderInfo['Email']); ?></p>
                    <p><strong>Phone:</strong> <?php echo htmlspecialchars($orderInfo['ContactNo']); ?></p>
                </div>
                
                <?php if ($address): ?>
                <div class="address-info">
                    <h3>Shipping Address</h3>
                    <p><?php echo htmlspecialchars($address['Street']); ?></p>
                    <p><?php echo htmlspecialchars($address['City']) . ', ' . 
                              htmlspecialchars($address['State']) . ' ' . 
                              htmlspecialchars($address['PostalCode']); ?></p>
                    <p><?php echo htmlspecialchars($address['Country']); ?></p>
                </div>
                <?php endif; ?>
                
                <h3 class="section-title">Order Items</h3>
                <div class="items-list">
                    <?php foreach ($orderItems as $item): ?>
                    <div class="order-item">
                        <div class="item-image">
                            <img src="<?php echo !empty($item['BookImage']) ? htmlspecialchars($item['BookImage']) : '../upload/bookPfp/BookCoverUnavailable.webp'; ?>" 
                                 alt="<?php echo htmlspecialchars($item['BookName']); ?>">
                        </div>
                        <div class="item-details">
                            <div class="item-title"><?php echo htmlspecialchars($item['BookName']); ?></div>
                            <div class="item-author">by <?php echo htmlspecialchars($item['Author']); ?></div>
                            <div class="item-price">
                                RM <?php echo number_format($item['Price']/$item['Quantity'], 2); ?> × <?php echo $item['Quantity']; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="order-total">
                    <p>Total: RM <?php echo number_format($orderInfo['TotalAmount'], 2); ?></p>
                </div>
            </div>
            
            <div class="payment-methods">
                <h2 class="section-title">Payment Method</h2>
                <p>Please select your preferred payment method:</p>
                
                <form method="post" id="payment-form">
                    <div class="payment-options">
                        <div class="payment-option">
                            <input type="radio" id="credit-card" name="payment_type" value="Credit Card" required>
                            <label for="credit-card">
                                <span class="checkmark"></span>
                                <span class="payment-option-name">Credit Card</span>
                            </label>
                        </div>
                        
                        <div class="payment-option">
                            <input type="radio" id="debit-card" name="payment_type" value="Debit Card" required>
                            <label for="debit-card">
                                <span class="checkmark"></span>
                                <span class="payment-option-name">Debit Card</span>
                            </label>
                        </div>
                        
                        <div class="payment-option">
                            <input type="radio" id="ewallet" name="payment_type" value="E-wallet" required>
                            <label for="ewallet">
                                <span class="checkmark"></span>
                                <span class="payment-option-name">E-Wallet</span>
                            </label>
                        </div>
                        
                        <div class="payment-option">
                            <input type="radio" id="cash" name="payment_type" value="Cash" required>
                            <label for="cash">
                                <span class="checkmark"></span>
                                <span class="payment-option-name">Cash</span>
                            </label>
                        </div>
                    </div>
                    
                    <div class="action-buttons">
                        <button type="submit" name="cancel_order" class="btn btn-back">Back to Cart</button>
                        <button type="submit" class="btn btn-pay">Complete Payment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <?php include 'footer.php'; ?>

</body>
</html>
