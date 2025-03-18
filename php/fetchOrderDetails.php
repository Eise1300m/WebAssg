<?php
session_start();
require_once("connection.php");

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    echo "Unauthorized access";
    exit();
}

if (isset($_GET['order_id'])) {
    $orderId = $_GET['order_id'];
    
    // Get order general information
    $stmt = $_db->prepare("
        SELECT o.*, u.Username, u.Email, u.ContactNo 
        FROM orders o 
        JOIN users u ON o.UserID = u.UserID 
        WHERE o.OrderNo = ?
    ");
    $stmt->execute([$orderId]);
    $order = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$order) {
        echo "Order not found";
        exit();
    }
    
    // Get order items - Updated to match the orderdetails table structure in bookstore.sql
    $stmt = $_db->prepare("
        SELECT od.*, b.BookName, b.BookImage, b.Author
        FROM orderdetails od 
        JOIN book b ON od.BookNo = b.BookNo 
        WHERE od.OrderNo = ?
    ");
    $stmt->execute([$orderId]);
    $orderItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Get shipping address
    $stmt = $_db->prepare("
        SELECT * FROM address WHERE UserID = ?
    ");
    $stmt->execute([$order['UserID']]);
    $address = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Output formatted order details
    ?>
    <div class="order-details-header">
        <div>
            <h3>Order #<?php echo $order['OrderNo']; ?></h3>
            <p>Placed on <?php echo date('F j, Y', strtotime($order['OrderDate'])); ?></p>
        </div>
        <div>
            <p>Status: <strong><?php echo 'Completed'; // Sample status ?></strong></p>
        </div>
    </div>
    
    <div class="order-details-section">
        <h3>Customer Details</h3>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($order['Username']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($order['Email']); ?></p>
        <p><strong>Phone:</strong> <?php echo htmlspecialchars($order['ContactNo']); ?></p>
    </div>
    
    <?php if ($address): ?>
    <div class="order-details-section">
        <h3>Shipping Address</h3>
        <p><?php echo htmlspecialchars($address['Street']); ?></p>
        <p><?php echo htmlspecialchars($address['City']) . ', ' . htmlspecialchars($address['State']) . ' ' . htmlspecialchars($address['PostalCode']); ?></p>
        <p><?php echo htmlspecialchars($address['Country']); ?></p>
    </div>
    <?php endif; ?>
    
    <div class="order-details-section">
        <h3>Order Items</h3>
        <?php if (empty($orderItems)): ?>
            <p class="no-items">No items found for this order.</p>
        <?php else: ?>
            <?php foreach ($orderItems as $item): ?>
            <div class="order-item">
                <div class="order-item-details">
                    <img src="<?php echo $item['BookImage'] ?: '../img/no-cover.png'; ?>" 
                         alt="<?php echo htmlspecialchars($item['BookName']); ?>" 
                         class="order-item-image">
                    <div>
                        <p><strong><?php echo htmlspecialchars($item['BookName']); ?></strong></p>
                        <p class="item-author">by <?php echo htmlspecialchars($item['Author']); ?></p>
                        <p>Quantity: <?php echo $item['Quantity']; ?></p>
                    </div>
                </div>
                <div class="order-item-price">
                    <p>RM <?php echo number_format($item['Price'], 2); ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
        
        <div class="order-total">
            <p>Total Items: <strong><?php echo $order['TotalQuantity']; ?></strong></p>
            <p>Total Amount: <strong>RM <?php echo number_format($order['TotalAmount'], 2); ?></strong></p>
            <p>Payment Method: <span class="payment-method"><?php echo $order['PaymentType']; ?></span></p>
        </div>
    </div>
    
    <div class="order-actions">
        <button class="admin-btn primary" onclick="closeOrderModal()">Close</button>
    </div>
    <?php
} else {
    echo "No order ID provided";
}
?> 