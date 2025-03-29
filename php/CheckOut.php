<?php
session_start();
require_once("connection.php");

if (!isset($_SESSION['user_name']) || empty($_SESSION['cart'])) {
    header("Location: Cart.php");
    exit;
}

$username = $_SESSION['user_name']; 
date_default_timezone_set("Asia/Kuala_Lumpur");
$order_date = date("Y-m-d H:i:s");
$totalQuantity = 0;
$totalPrice = 0;
$payment_error = isset($_SESSION['payment_error']) ? $_SESSION['payment_error'] : '';
unset($_SESSION['payment_error']);

// Get user information for checkout
try {
    // Retrieve UserID and check if address exists
    $stmt = $_db->prepare("SELECT u.UserID, u.Username, u.Email, u.ContactNo, COUNT(a.AddressID) as address_count 
                           FROM users u 
                           LEFT JOIN address a ON u.UserID = a.UserID 
                           WHERE u.Username = ?
                           GROUP BY u.UserID");
    $stmt->execute([$username]);
    $userInfo = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$userInfo) {
        throw new Exception("User does not exist.");
    }

    // Check if user has an address
    if ($userInfo['address_count'] == 0) {
        // No address found, redirect to profile page with message
        $_SESSION['checkout_message'] = "Please add a shipping address before checkout.";
        header("Location: UserEditProfile.php");
        exit;
    }

    $user_id = $userInfo['UserID'];
    
    // Get user's address
    $addressStmt = $_db->prepare("SELECT * FROM address WHERE UserID = ? LIMIT 1");
    $addressStmt->execute([$user_id]);
    $address = $addressStmt->fetch(PDO::FETCH_ASSOC);
    
} catch (Exception $e) {
    die("Checkout preparation failed: " . $e->getMessage());
}

// After retrieving user information and before calculating totals, add this code:
$isFirstOrder = true;
try {
    $checkOrderStmt = $_db->prepare("SELECT COUNT(*) as order_count FROM orders WHERE UserID = ?");
    $checkOrderStmt->execute([$user_id]);
    $orderCount = $checkOrderStmt->fetch(PDO::FETCH_ASSOC);
    
    if ($orderCount['order_count'] > 0) {
        $isFirstOrder = false;
    }
} catch (Exception $e) {
    // Handle error silently, default to no discount if check fails
    $isFirstOrder = false;
}

// Get shipping fee from Cart session
$shipping = isset($_SESSION['cart_shipping']) ? $_SESSION['cart_shipping'] : 5.00;
$subtotalPrice = isset($_SESSION['cart_subtotal']) ? $_SESSION['cart_subtotal'] : 0;

// Calculate total quantity from cart items
$totalQuantity = 0;
foreach ($_SESSION['cart'] as $item) {
    $totalQuantity += $item['Quantity'];
}

// Calculate discount if first order
if ($isFirstOrder) {
    $discount = $subtotalPrice * 0.20;
    $totalPrice = ($subtotalPrice - $discount) + $shipping;
} else {
    $totalPrice = $subtotalPrice + $shipping;
}

// Store these values in session for Receipt.php
$_SESSION['order_details'] = [
    'subtotal' => $subtotalPrice,
    'shipping' => $shipping,
    'discount' => $isFirstOrder ? $discount : 0,
    'total' => $totalPrice,
    'is_first_order' => $isFirstOrder,
    'total_quantity' => $totalQuantity
];

// Process payment submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['cancel_checkout'])) {
        // Cancel checkout and return to cart
        header("Location: Cart.php?cancelled=1");
        exit;
    }
    
    if (isset($_POST['confirm_payment']) && isset($_POST['payment_type'])) {
        $payment_type = $_POST['payment_type'];
        
        try {
            // Start transaction
            $_db->beginTransaction();
            
            // 1. Create the order - now including AddressID
            $stmt = $_db->prepare("INSERT INTO orders (OrderDate, TotalQuantity, TotalAmount, PaymentType, UserID, AddressID) 
                                  VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$order_date, $totalQuantity, $totalPrice, $payment_type, $user_id, $address['AddressID']]);
            
            // Get the new order ID
            $order_id = $_db->lastInsertId();
            
            // 2. Add order items
            foreach ($_SESSION['cart'] as $book) {
                $subtotal = $book['Price'] * $book['Quantity'];
                $stmt = $_db->prepare("INSERT INTO orderdetails (OrderNo, BookNo, Quantity, Price) 
                                      VALUES (?, ?, ?, ?)");
                $stmt->execute([$order_id, $book['BookNo'], $book['Quantity'], $subtotal]);
            }
            
            // 3. Complete the transaction
            $_db->commit();
            
            // 4. Store order ID in session for receipt
            $_SESSION['order_id'] = $order_id;
            
            // 5. Clear cart after successful order
            unset($_SESSION['cart']);
            
            // 6. Redirect to receipt
            header("Location: Receipt.php");
            exit;
            
        } catch (Exception $e) {
            // Rollback transaction on error
            if ($_db->inTransaction()) {
                $_db->rollBack();
            }
            
            $_SESSION['payment_error'] = "Payment processing failed: " . $e->getMessage();
            header("Location: CheckOut.php");
            exit;
        }
    } elseif (isset($_POST['confirm_payment']) && !isset($_POST['payment_type'])) {
        $_SESSION['payment_error'] = "Please select a payment method.";
        header("Location: CheckOut.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Secret Shelf</title>
    <link rel="stylesheet" href="../css/NavbarStyles.css">
    <link rel="stylesheet" href="../css/FooterStyles.css">
    <link rel="stylesheet" href="../css/Paymentstyles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/Scripts.js"></script>

>

</head>
<body>
    <?php include_once("navbar.php") ?>
    
    <div class="payment-container">
        <div class="payment-header">
            <h1>Checkout and Payment</h1>
            <p>Complete your order</p>
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
                    <p><strong>Date:</strong> <?php echo date('F j, Y, g:i a'); ?></p>
                    <p><strong>Items:</strong> <?php echo $totalQuantity; ?></p>
                </div>
                
                <div class="customer-info">
                    <h3>Customer Information</h3>
                    <p><strong>Name:</strong> <?php echo htmlspecialchars($userInfo['Username']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($userInfo['Email']); ?></p>
                    <p><strong>Phone:</strong> <?php echo htmlspecialchars($userInfo['ContactNo']); ?></p>
                </div>
                
                <?php if ($address): ?>
                <div class="address-info">
                    <h3>Shipping Address</h3>
                    <p><?php echo htmlspecialchars($address['Street']); ?></p>
                    <p><?php echo htmlspecialchars($address['City']) . ', ' . 
                              htmlspecialchars($address['State']) . ' ' . 
                              htmlspecialchars($address['PostalCode']); ?></p>
                </div>
                <?php endif; ?>
                
                <h3 class="section-title">Order Items</h3>
                <div class="items-list">
                    <?php foreach ($_SESSION['cart'] as $item): ?>
                    <div class="order-item">
                        <div class="item-image">
                            <img src="<?php echo !empty($item['BookImage']) ? htmlspecialchars($item['BookImage']) : '../upload/bookPfp/BookCoverUnavailable.webp'; ?>" 
                                 alt="<?php echo htmlspecialchars($item['BookName']); ?>">
                        </div>
                        <div class="item-details">
                            <div class="item-title"><?php echo htmlspecialchars($item['BookName']); ?></div>
                            <div class="item-author"><?php echo isset($item['Author']) ? 'by ' . htmlspecialchars($item['Author']) : ''; ?></div>
                            <div class="item-price">
                                RM <?php echo number_format($item['Price'], 2); ?> × <?php echo $item['Quantity']; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="price-breakdown">
                    <?php if ($isFirstOrder): ?>
                        <p>
                            <span>Subtotal:</span>
                            <span>RM <?php echo number_format($_SESSION['cart_subtotal'], 2); ?></span>
                        </p>
                        <p class="discount-amount">
                            <span>Discount (20% for first order):</span>
                            <span>-RM <?php echo number_format($discount, 2); ?></span>
                        </p>
                        <p class="shipping-fee">
                            <span>Shipping Fee:</span>
                            <span>RM <?php echo number_format($shipping, 2); ?></span>
                        </p>
                        <p class="final-total">
                            <span>Total:</span>
                            <span>RM <?php echo number_format($totalPrice, 2); ?></span>
                        </p>
                    <?php else: ?>
                        <p>
                            <span>Subtotal:</span>
                            <span>RM <?php echo number_format($_SESSION['cart_subtotal'], 2); ?></span>
                        </p>
                        <p class="shipping-fee">
                            <span>Shipping Fee:</span>
                            <span>RM <?php echo number_format($shipping, 2); ?></span>
                        </p>
                        <p class="final-total">
                            <span>Total:</span>
                            <span>RM <?php echo number_format($totalPrice, 2); ?></span>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="payment-methods">
                <h2 class="section-title">Payment Method</h2>
                <p>Please select your preferred payment method:</p>
                
                <form method="post" id="payment-form" action="CheckOut.php">
                    <div class="payment-options">
                        <div class="payment-option">
                            <input type="radio" id="credit-card" name="payment_type" value="Credit Card">
                            <label for="credit-card">
                                <span class="checkmark"></span>
                                <span class="payment-option-name">Credit Card</span>
                            </label>
                        </div>
                        
                        <div class="payment-option">
                            <input type="radio" id="debit-card" name="payment_type" value="Debit Card">
                            <label for="debit-card">
                                <span class="checkmark"></span>
                                <span class="payment-option-name">Debit Card</span>
                            </label>
                        </div>
                        
                        <div class="payment-option">
                            <input type="radio" id="ewallet" name="payment_type" value="ewallet">
                            <label for="ewallet">
                                <span class="checkmark"></span>
                                <span class="payment-option-name">E-Wallet</span>
                            </label>
                        </div>
                        
                        <div class="payment-option">
                            <input type="radio" id="banktransfer" name="payment_type" value="Bank Transfer">
                            <label for="banktransfer">
                                <span class="checkmark"></span>
                                <span class="payment-option-name">Bank Transfer</span>
                            </label>
                        </div>
                    </div>
                    
                    <div class="action-buttons">
                        <button type="submit" name="cancel_checkout" value="1" class="btn btn-back">Back to Cart</button>
                        <button type="submit" name="confirm_payment" value="1" class="btn btn-pay">Confirm & Pay</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <?php include 'footer.php'; ?>
    <script src="../js/order.js"></script>
    
</body>
</html>
