<?php
session_start();
require_once("connection.php");

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: UserLogin.php");
    exit();
}

$query = "
    SELECT o.*, u.Username, u.Email 
    FROM orders o 
    JOIN users u ON o.UserID = u.UserID 
    WHERE o.OrderStatus IN ('Preparing', 'Delivering', 'Completed')
    ORDER BY o.OrderDate DESC
";

$stmt = $_db->prepare($query);
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Count orders by status
$statusCounts = [
    'Preparing' => 0,
    'Delivering' => 0,
    'Completed' => 0
];

foreach ($orders as $order) {
    $statusCounts[$order['OrderStatus']]++;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Requests - Secret Shelf</title>
    <link rel="stylesheet" href="../css/HomeStyles.css">
    <link rel="stylesheet" href="../css/NavbarStyles.css">
    <link rel="stylesheet" href="../css/DeliveryRequestStyles.css">
    <link rel="icon" type="image/x-icon" href="../img/Logo.png">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include_once("navbaradmin.php") ?>

    <main class="admin-container">
        <div class="admin-header">
            <h1>Delivery Requests</h1>
            <p>Manage order deliveries</p>
        </div>

        <div class="admin-content">
            <a href="AdminMainPage.php" class="admin-nav-back">
                <img src="../upload/icon/back.png" alt="Back"> Back to Dashboard
            </a>

            <!-- Status Overview -->
            <div class="status-overview">
                <div class="status-card preparing">
                    <img src="../upload/icon/package.png" alt="Preparing" class="status-icon">
                    <div class="status-info">
                        <h3>Preparing</h3>
                        <p><?php echo $statusCounts['Preparing']; ?> Orders</p>
                    </div>
                </div>

                <div class="status-card delivering">
                    <img src="../upload/icon/delivery.png" alt="Delivering" class="status-icon"">
                    <div class="status-info">
                        <h3>Delivering</h3>
                        <p><?php echo $statusCounts['Delivering']; ?> Orders</p>
                    </div>
                </div>
            </div>

            <!-- Order Lists -->
            div class="order-lists">
    <?php foreach (['Preparing', 'Delivering', 'Collected'] as $status): ?>
        <div class="order-section">
            <h2><?php echo $status; ?> Orders</h2>
            <div class="order-cards">
                <?php 
                $filteredOrders = array_filter($orders, function($order) use ($status) {
                    return $order['OrderStatus'] === $status;
                });
                
                if (empty($filteredOrders)): ?>
                    <div class="no-orders">No <?php echo strtolower($status); ?> orders at the moment.</div>
                <?php else: 
                    foreach ($filteredOrders as $order): ?>
                    <div class="order-card">
                        <div class="order-header">
                            <h3>Order #<?php echo $order['OrderNo']; ?></h3>
                            <span class="order-date"><?php echo date('M d, Y', strtotime($order['OrderDate'])); ?></span>
                        </div>
                        <div class="order-info">
                            <p><strong>Customer:</strong> <?php echo htmlspecialchars($order['Username']); ?></p>
                            <p><strong>Items:</strong> <?php echo $order['TotalQuantity']; ?></p>
                            <p><strong>Total:</strong> RM <?php echo number_format($order['TotalAmount'], 2); ?></p>
                        </div>
                        <div class="order-actions">
                            <button onclick="viewOrderDetails(<?php echo $order['OrderNo']; ?>)" class="view-btn">
                                <img src="../upload/icon/view.png" alt="View" class="btn-icon"> View Details
                            </button>
                            <?php if ($status === 'Preparing'): ?>
                                <button onclick="updateOrderStatus(<?php echo $order['OrderNo']; ?>, 'Preparing')" 
                                        class="status-btn preparing">
                                    <img src="../upload/icon/delivery.png" alt="Status" class="btn-icon">
                                    Mark as Delivering
                                </button>
                            <?php elseif ($status === 'Delivering'): ?>
                                <!-- Button disabled until user confirms collection -->
                                <button class="status-btn delivering" disabled>
                                    <img src="../upload/icon/check.png" alt="Status" class="btn-icon">
                                    Waiting for Collection
                                </button>
                            <?php elseif ($status === 'Collected'): ?>
                                <button onclick="updateOrderStatus(<?php echo $order['OrderNo']; ?>, 'Collected')" 
                                        class="status-btn complete">
                                    <img src="../upload/icon/check.png" alt="Status" class="btn-icon">
                                    Mark as Complete
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach;
                endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div> 
        </div>
    </main>

    <!-- Order Details Modal -->
    <div id="orderModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Order Details</h2>
            <div id="orderDetailsContent">

            </div>
        </div>
    </div>

    <script src="../js/AdminScripts.js"></script>
</body>
</html>