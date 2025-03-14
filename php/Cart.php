<?php
session_start();
if (!isset($_SESSION['user_name'])) {
    header("Location: CustomerLogin.php");
    exit;
}

$cart = $_SESSION['cart'] ?? [];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="../css/CartStyles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<h1>Your Cart</h1>

<?php if (empty($cart)): ?>
    <p>Your cart is empty.</p>
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
            <?php foreach ($cart as $book_id => $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['BookName']) ?></td>
                    <td>RM<?= number_format($item['Price'], 2) ?></td>
                    <td>
                        <input type="number" class="quantity" data-id="<?= $book_id ?>" value="<?= $item['Quantity'] ?>" min="1">
                    </td>
                    <td>RM<?= number_format($item['Price'] * $item['Quantity'], 2) ?></td>
                    <td>
                        <button class="remove-item" data-id="<?= $book_id ?>">Remove</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <form action="CheckOut.php" method="POST">
        <button type="submit" id="checkout">Proceed to Checkout</button>
    </form>
    
<?php endif; ?>

<script src="../js/order.js"></script>
</body>
</html>
