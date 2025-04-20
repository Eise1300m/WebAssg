<?php
session_start();
require_once("../base.php");

requireAdmin();
// Handle order status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_status') {
    // Set JSON content type header
    header('Content-Type: application/json');
    
    $order_id = $_POST['order_id'];
    $new_status = $_POST['new_status'];

    try {
        // Check if order exists
        $stmt = $_db->prepare("SELECT OrderStatus FROM orders WHERE OrderNo = ?");
        $stmt->execute([$order_id]);
        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$order) {
            echo json_encode(['success' => false, 'message' => 'Order not found']);
            exit();
        }

        // Validate status transition
        $validTransitions = [
            'Preparing' => ['Delivering'],
            'Collected' => ['Complete']
            // Delivering to Collected is handled by customer
        ];

        if (
            !isset($validTransitions[$order['OrderStatus']]) ||
            !in_array($new_status, $validTransitions[$order['OrderStatus']])
        ) {
            echo json_encode(['success' => false, 'message' => 'Invalid status transition']);
            exit();
        }

        // Update order status
        $stmt = $_db->prepare("UPDATE orders SET OrderStatus = ? WHERE OrderNo = ?");
        $stmt->execute([$new_status, $order_id]);

        // Set flash message
        $_SESSION['flash_message'] = [
            'type' => 'success',
            'message' => 'Order #' . $order_id . ' status updated to ' . $new_status . ' successfully!'
        ];

        echo json_encode(['success' => true, 'message' => 'Order status updated successfully']);
        exit();
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
        exit();
    }
}

// Check for orders that have been in 'Delivering' status for more than 14 days
$stmt = $_db->prepare("
    UPDATE orders 
    SET OrderStatus = 'Complete' 
    WHERE OrderStatus = 'Delivering' 
    AND OrderDate <= DATE_SUB(NOW(), INTERVAL 14 DAY)
");
$stmt->execute();

// Query to get all orders
$query = "
    SELECT o.*, u.Username, u.Email 
    FROM orders o 
    JOIN users u ON o.UserID = u.UserID 
    WHERE o.OrderStatus IN ('Preparing', 'Delivering', 'Collected', 'Complete')
    ORDER BY o.OrderDate DESC
";

$stmt = $_db->prepare($query);
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

$statusCounts = [
    'Preparing' => 0,
    'Delivering' => 0,
    'Collected' => 0,
    'Complete' => 0
];

foreach ($orders as $order) {
    $statusCounts[$order['OrderStatus']]++;
}

includeAdminNav();
displayFlashMessage();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Requests - Secret Shelf</title>
    <link rel="stylesheet" href="/WebAssg/css/HomeStyles.css">
    <link rel="stylesheet" href="/WebAssg/css/NavbarStyles.css">
    <link rel="stylesheet" href="/WebAssg/css/FooterStyles.css">
    <link rel="icon" type="image/x-icon" href="/WebAssg/img/Logo.png">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="/WebAssg/css/DeliveryRequestStyles.css">
    <script src="/WebAssg/js/AdminScripts.js"></script>
</head>

<body data-page="admin">
    

    <a class="back-button" href="AdminMainPage.php">
        <img src="/WebAssg/upload/icon/back.png" alt="Back" class="back-icon"> Back to Dashboard
    </a>

    <main class="admin-container">
        <div class="admin-header">
            <h1>Delivery Requests</h1>
            <p>Manage order deliveries</p>
        </div>

        <!-- Status Overview -->
        <div class="status-overview">
            <div class="status-card preparing">
                <img src="/WebAssg/upload/icon/package.png" alt="Preparing" class="status-icon">
                <div class="status-info">
                    <h3>Preparing</h3>
                    <p><?php echo $statusCounts['Preparing']; ?> Orders</p>
                </div>
            </div>

            <div class="status-card delivering">
                <img src="/WebAssg/upload/icon/delivery.png" alt="Delivering" class="status-icon">
                <div class="status-info">
                    <h3>Delivering</h3>
                    <p><?php echo $statusCounts['Delivering']; ?> Orders</p>
                </div>
            </div>

            <div class="status-card collected">
                <img src="/WebAssg/upload/icon/collect.png" alt="Collected" class="status-icon">
                <div class="status-info">
                    <h3>Collected</h3>
                    <p><?php echo $statusCounts['Collected']; ?> Orders</p>
                </div>
            </div>

            <div class="status-card complete">
                <img src="/WebAssg/upload/icon/check.png" alt="Complete" class="status-icon">
                <div class="status-info">
                    <h3>Complete</h3>
                    <p><?php echo $statusCounts['Complete']; ?> Orders</p>
                </div>
            </div>
        </div>

        <!-- Order Lists -->
        <div class="order-lists">
            <?php foreach (['Preparing', 'Delivering', 'Collected', 'Complete'] as $status): ?>
                <div class="order-section">
                    <h2><?php echo $status; ?> Orders</h2>
                    <div class="order-cards">
                        <?php
                        $filteredOrders = array_filter($orders, function ($order) use ($status) {
                            return $order['OrderStatus'] === $status;
                        });

                        if (empty($filteredOrders)): ?>
                            <div class="no-orders">No <?php echo strtolower($status); ?> orders at the moment.</div>
                            <?php else:
                            foreach ($filteredOrders as $order):
                                $orderDate = new DateTime($order['OrderDate']);
                                $now = new DateTime();
                                $daysDiff = $now->diff($orderDate)->days;
                                $isOverdue = $status === 'Delivering' && $daysDiff >= 14;
                            ?>
                                <div class="order-card <?php echo $isOverdue ? 'overdue' : ''; ?>">
                                    <div class="order-header">
                                        <h3>Order #<?php echo $order['OrderNo']; ?></h3>
                                        <span class="order-date"><?php echo date('M d, Y', strtotime($order['OrderDate'])); ?></span>
                                        <?php if ($isOverdue): ?>
                                            <span class="overdue-badge">Overdue (<?php echo $daysDiff; ?> days)</span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="order-info">
                                        <p><strong>Customer:</strong> <?php echo htmlspecialchars($order['Username']); ?></p>
                                        <p><strong>Items:</strong> <?php echo $order['TotalQuantity']; ?></p>
                                        <p><strong>Total:</strong> RM <?php echo number_format($order['TotalAmount'], 2); ?></p>
                                    </div>
                                    <div class="order-actions">
                                        <button onclick="viewOrderDetails(<?php echo $order['OrderNo']; ?>)" class="view-btn">
                                            <img src="/WebAssg/upload/icon/view.png" alt="View" class="btn-icon" style="filter: invert();"> View Details
                                        </button>
                                        <?php if ($status === 'Preparing'): ?>
                                            <button onclick="updateOrderStatus(<?php echo $order['OrderNo']; ?>, 'Delivering')"
                                                class="status-btn preparing">
                                                <img src="/WebAssg/upload/icon/delivery.png" alt="Status" class="btn-icon">
                                                Mark as Delivering
                                            </button>
                                        <?php elseif ($status === 'Delivering'): ?>
                                            <button disabled class="status-btn delivering" style="opacity: 0.6; cursor: not-allowed;">
                                                <img src="/WebAssg/upload/icon/collect.png" alt="Status" class="btn-icon">
                                                Waiting for Collection
                                            </button>
                                        <?php elseif ($status === 'Collected'): ?>
                                            <button onclick="updateOrderStatus(<?php echo $order['OrderNo']; ?>, 'Complete')"
                                                class="status-btn complete">
                                                <img src="/WebAssg/upload/icon/check.png" alt="Status" class="btn-icon">
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
</body>

</html>