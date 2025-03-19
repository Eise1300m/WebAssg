<?php
session_start();
require_once("connection.php");

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: UserLogin.php");
    exit();
}

// Fetch all orders with user information
$stmt = $_db->prepare("
    SELECT o.*, u.Username, u.Email 
    FROM orders o 
    JOIN users u ON o.UserID = u.UserID 
    ORDER BY o.OrderDate ASC
");
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management - Secret Shelf</title>
    <link rel="stylesheet" href="../css/HomeStyles.css">
    <link rel="stylesheet" href="../css/AdminStyles.css">
    <link rel="stylesheet" href="../css/NavbarStyles.css">
    <link rel="stylesheet" href="../css/FooterStyles.css">
    <link rel="icon" type="image/x-icon" href="../img/Logo.png">
    <script src="../js/AdminScripts.js"></script>
    <link rel="stylesheet" href="../css/AdminOrders.css">
</head>
<body>
    <?php include_once("navbaradmin.php") ?>

    <main class="admin-container">
        <div class="admin-header">
            <h1>Order Management</h1>
            <p>View and manage customer orders</p>
        </div>

        <div class="admin-content">
            <a href="AdminMainPage.php" class="admin-nav-back">
                <img src="../upload/icon/arrowback.png" alt="Back"> Back to Dashboard
            </a>
            
            <div class="orders-list">
                <table class="orders-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Date</th>
                            <th>Total Items</th>
                            <th>Total Amount</th>
                            <th>Payment Type</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?php echo $order['OrderNo']; ?></td>
                            <td><?php echo htmlspecialchars($order['Username']); ?></td>
                            <td><?php echo $order['OrderDate']; ?></td>
                            <td><?php echo $order['TotalQuantity']; ?></td>
                            <td>RM <?php echo number_format($order['TotalAmount'], 2); ?></td>
                            <td><?php echo $order['PaymentType']; ?></td>
                            <td>
                                <button onclick="viewOrderDetails(<?php echo $order['OrderNo']; ?>)">
                                    View Details
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Order Details Modal -->
    <div id="orderModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeOrderModal()">&times;</span>
            <h2>Order Details</h2>
            <div id="orderDetailsContent">
                <!-- Order details will be loaded here via AJAX -->
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/AdminScripts.js"></script>
    <?php include 'footer.php'; ?>
</body>
</html> 