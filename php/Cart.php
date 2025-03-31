<?php
require_once("base.php");

// Ensure user is logged in
requireLogin();

$username = $_SESSION['user_name'];

// Get user information
$stmt = $db->query("SELECT * FROM users WHERE Username = ?", [$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    handleError("User not found.", "UserLogin.php");
}

$user_id = $user['UserID'];

// Get user's address
$stmt = $db->query("SELECT * FROM address WHERE UserID = ?", [$user_id]);
$address = $stmt->fetch(PDO::FETCH_ASSOC);

// Include navbar
includeNavbar();

// Display any flash messages
displayFlashMessages();

$cart = $_SESSION['cart'] ?? [];
$subtotal = 0;
$shipping = 5.00;

require_once "connection.php";

// Fetch book details for all items in cart
if (!empty($cart)) {
    $bookIds = array_keys($cart);
    $placeholders = str_repeat('?,', count($bookIds) - 1) . '?';
    $stmt = $_db->prepare("SELECT BookNo, BookName, BookPrice, BookImage FROM book WHERE BookNo IN ($placeholders)");
    $stmt->execute($bookIds);
    $bookDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Create a lookup array for easy access
    $bookLookup = [];
    foreach ($bookDetails as $book) {
        $bookLookup[$book['BookNo']] = $book;
    }
}

// Calculate final total (subtotal + shipping)
$total = empty($cart) ? 0 : $subtotal + $shipping;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Secret Shelf</title>
    <link rel="stylesheet" href="../css/NavbarStyles.css">
    <link rel="stylesheet" href="../css/FooterStyles.css">
    <link rel="stylesheet" href="../css/CartStyles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="icon" type="image/x-icon" href="../img/Logo.png">
    <script src="../js/Scripts.js"></script>
    <script src="../js/order.js"></script>
</head>
<body>
    <?php include_once("navbar.php") ?>
    
    <div class="cart-page-wrapper">
        <div class="cart-container">
            <a class="continue-shopping-top" onclick="history.back()">
                <img src="../upload/icon/arrowback.png" alt="Back" class="back-icon">
                Back
            </a>
            
            <div class="cart-content">
                <div class="cart-items">
                    <div class="cart-header">
                        <h2>Your Cart</h2>
                        <span class="item-count"><?= count($cart) ?> Item(s)</span>
                    </div>

                    <?php if (empty($cart)): ?>
                        <div class="empty-cart">
                            <p>Your cart is empty.</p>
                            <a href="MainPage.php" class="continue-shopping-btn">Continue Shopping</a>
                        </div>
                    <?php else: ?>
                        <div class="cart-items-grid">
                            <?php foreach ($cart as $book_id => $item): 
                                $bookInfo = $bookLookup[$book_id] ?? null;
                                if (!$bookInfo) continue;
                                $itemTotal = $bookInfo['BookPrice'] * $item['Quantity'];
                                $subtotal += $itemTotal;
                            ?>
                                <div class="cart-item">
                                    <div class="item-section book">
                                        <h3>Book</h3>
                                        <div class="book-details">
                                            <img src="<?= htmlspecialchars($bookInfo['BookImage']) ?>" 
                                                 alt="<?= htmlspecialchars($bookInfo['BookName']) ?>"
                                                 onerror="this.src='../upload/bookPfp/bookcoverunavailable.png'">
                                            <span><?= htmlspecialchars($bookInfo['BookName']) ?></span>
                                        </div>
                                    </div>
                                    
                                    <div class="item-section price">
                                        <h3>Price</h3>
                                        <span>RM<?= number_format($bookInfo['BookPrice'], 2) ?></span>
                                    </div>
                                    
                                    <div class="item-section quantity">
                                        <h3>Quantity</h3>
                                        <div class="quantity-section">
                                            <div class="quantity-controls">
                                                <button class="quantity-btn minus" data-id="<?= $book_id ?>">-</button>
                                                <input type="text" class="quantity-input" 
                                                       data-id="<?= $book_id ?>" 
                                                       data-price="<?= $bookInfo['BookPrice'] ?>" 
                                                       value="<?= $item['Quantity'] ?>" 
                                                       readonly>
                                                <button class="quantity-btn plus" data-id="<?= $book_id ?>">+</button>
                                            </div>
                                            <div class="quantity-error">Maximum quantity is 10</div>
                                        </div>
                                    </div>
                                    
                                    <div class="item-section total">
                                        <h3>Total</h3>
                                        <span>RM<?= number_format($itemTotal, 2) ?></span>
                                    </div>
                                    
                                    <button class="remove-item" data-id="<?= $book_id ?>">
                                        <img src="../upload/icon/trash.png" alt="Remove">
                                    </button>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="order-summary">
                    <h2>Order Summary</h2>
                    <div class="summary-details">
                        <div class="summary-row">
                            <span>Subtotal</span>
                            <span>RM<?= number_format($subtotal, 2) ?></span>
                        </div>
                        <?php if (!empty($cart)): ?>
                        <div class="summary-row">
                            <span>Shipping</span>
                            <span id="shipping-cost" data-value="<?= $shipping ?>">RM<?= number_format($shipping, 2) ?></span>
                            <div class="shipping-line"></div>
                        </div>
                        <div class="summary-total">
                            <span>Total</span>
                            <span>RM<?= number_format($subtotal + $shipping, 2) ?></span>
                        </div>
                        <?php else: ?>
                        <div class="summary-total">
                            <span>Total</span>
                            <span>RM0.00</span>
                        </div>
                        <?php endif; ?>
                        
                        <button onclick="checkCartAndProceed()" class="checkout-btn" <?= empty($cart) ? 'disabled' : '' ?>>
                            Proceed To Checkout
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php 
    // Recalculate total after the cart items loop is complete
    $total = $subtotal + $shipping;
    // Store the total in session for use in checkout
    $_SESSION['cart_total'] = $total;
    $_SESSION['cart_subtotal'] = $subtotal;
    $_SESSION['cart_shipping'] = $shipping;
    ?>

 
</body>
</html>