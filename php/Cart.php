<?php
session_start();
if (!isset($_SESSION['user_name'])) {
    header("Location: CustomerLogin.php");
    exit;
}

$cart = $_SESSION['cart'] ?? [];
$total = 0;
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
</head>
<body>
    <?php include_once("navbar.php") ?>
    
    <div class="cart-container">
        <h1>Your Shopping Cart</h1>

        <div id="cart-container">
            <?php if (empty($cart)): ?>
                <div class="empty-cart">
                    <p>Your cart is empty.</p>
                    <a href="MainPage.php" class="continue-shopping-btn">Continue Shopping</a>
                </div>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Book</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart as $book_id => $item): 
                            $itemTotal = $item['Price'] * $item['Quantity'];
                            $total += $itemTotal;
                        ?>
                            <tr data-book-id="<?= $book_id ?>">
                                <td><?= htmlspecialchars($item['BookName']) ?></td>
                                <td class="price">RM<?= number_format($item['Price'], 2) ?></td>
                                <td>
                                    <input type="number" class="quantity" data-id="<?= $book_id ?>" 
                                           data-price="<?= $item['Price'] ?>" 
                                           value="<?= $item['Quantity'] ?>" min="1">
                                </td>
                                <td class="item-total">RM<?= number_format($itemTotal, 2) ?></td>
                                <td>
                                    <button class="remove-item" data-id="<?= $book_id ?>">Remove</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3"><strong>Cart Total:</strong></td>
                            <td colspan="2" id="cart-total">RM<?= number_format($total, 2) ?></td>
                        </tr>
                    </tfoot>
                </table>

                <div class="cart-actions">
                    <a href="index.php" class="continue-shopping-btn">Continue Shopping</a>
                    <form action="CheckOut.php" method="POST" class="checkout-form">
                        <button type="submit" id="checkout" class="checkout-btn">Proceed to Checkout</button>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <?php include_once('footer.php') ?>
    
    <script src="../js/order.js"></script>
</body>
</html>
