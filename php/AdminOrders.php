<?php
session_start();
require_once("connection.php");

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: UserLogin.php");
    exit();
}

// Determine any filters from GET parameters
$dateFilter = isset($_GET['filter-date']) ? $_GET['filter-date'] : 'all';
$paymentFilter = isset($_GET['filter-payment']) ? $_GET['filter-payment'] : 'all';

// Base query
$query = "
    SELECT o.*, u.Username, u.Email 
    FROM orders o 
    JOIN users u ON o.UserID = u.UserID 
    WHERE 1=1
";

// Add filters if selected
$params = [];

// Date filter
if ($dateFilter !== 'all') {
    switch ($dateFilter) {
        case 'today':
            $query .= " AND DATE(o.OrderDate) = CURDATE()";
            break;
        case 'week':
            $query .= " AND YEARWEEK(o.OrderDate, 1) = YEARWEEK(CURDATE(), 1)";
            break;
        case 'month':
            $query .= " AND MONTH(o.OrderDate) = MONTH(CURDATE()) AND YEAR(o.OrderDate) = YEAR(CURDATE())";
            break;
    }
}

// Payment method filter
if ($paymentFilter !== 'all') {
    $query .= " AND o.PaymentType = ?";
    $params[] = $paymentFilter;
}

$query .= " ORDER BY o.OrderDate DESC";

// Execute the filtered query
$stmt = $_db->prepare($query);
$stmt->execute($params);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get order statistics
$stmt = $_db->prepare("SELECT COUNT(*) as total_orders, SUM(TotalAmount) as total_sales FROM orders");
$stmt->execute();
$orderStats = $stmt->fetch(PDO::FETCH_ASSOC);

$totalOrders = $orderStats['total_orders'] ?? 0;
$totalSales = $orderStats['total_sales'] ?? 0;

// Get user count
$stmt = $_db->prepare("SELECT COUNT(*) as total_users FROM users WHERE Role = 'customer'");
$stmt->execute();
$userData = $stmt->fetch(PDO::FETCH_ASSOC);
$totalUsers = $userData['total_users'] ?? 0;

// Get payment methods for filter dropdown
$stmt = $_db->prepare("SELECT DISTINCT PaymentType FROM orders");
$stmt->execute();
$paymentMethods = $stmt->fetchAll(PDO::FETCH_COLUMN);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management - Secret Shelf</title>
    <link rel="stylesheet" href="../css/HomeStyles.css">
    <link rel="stylesheet" href="../css/NavbarStyles.css">
    <link rel="stylesheet" href="../css/FooterStyles.css">
    <link rel="stylesheet" href="../css/AdminOrders.css">
    <link rel="icon" type="image/x-icon" href="../img/Logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/Scripts.js"></script>
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
                <img src="../upload/icon/back.png" alt="Back"> Back to Dashboard
            </a>
            
            <!-- Order Statistics -->
            <div class="admin-stats">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="stat-info">
                        <span>Total Orders</span>
                        <h3><?php echo $totalOrders; ?></h3>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <div class="stat-info">
                        <span>Total Sales</span>
                        <h3>RM <?php echo number_format($totalSales, 2); ?></h3>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-info">
                        <span>Total Customers</span>
                        <h3><?php echo $totalUsers; ?></h3>
                    </div>
                </div>
            </div>
            
            <div class="order-management">
                <!-- Order Controls -->
                <div class="product-actions">
                    <div class="filter-container">
                        <form id="filterForm" method="get" class="filter-form">
                            <div class="filter-group">
                                <label for="filter-date">Filter by Date</label>
                                <select id="filter-date" name="filter-date">
                                    <option value="all" <?php echo $dateFilter === 'all' ? 'selected' : ''; ?>>All Time</option>
                                    <option value="today" <?php echo $dateFilter === 'today' ? 'selected' : ''; ?>>Today</option>
                                    <option value="week" <?php echo $dateFilter === 'week' ? 'selected' : ''; ?>>This Week</option>
                                    <option value="month" <?php echo $dateFilter === 'month' ? 'selected' : ''; ?>>This Month</option>
                                </select>
                            </div>
                            
                            <div class="filter-group">
                                <label for="filter-payment">Payment Method</label>
                                <select id="filter-payment" name="filter-payment">
                                    <option value="all" <?php echo $paymentFilter === 'all' ? 'selected' : ''; ?>>All Methods</option>
                                    <?php foreach ($paymentMethods as $method): ?>
                                        <option value="<?php echo $method; ?>" <?php echo $paymentFilter === $method ? 'selected' : ''; ?>>
                                            <?php echo $method; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <button type="submit" class="filter-btn">
                                <i class="fas fa-filter"></i> Apply Filter
                            </button>
                            
                            <a href="AdminOrders.php" class="reset-btn">
                                <i class="fas fa-undo"></i> Reset
                            </a>
                        </form>
                    </div>
                </div>
                
                <!-- Orders Table -->
                <div class="product-table-container">
                    <table class="product-table">
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
                            <?php if (empty($orders)): ?>
                            <tr>
                                <td colspan="7" class="no-results">No orders found matching your criteria.</td>
                            </tr>
                            <?php else: ?>
                                <?php foreach ($orders as $order): ?>
                                <tr>
                                    <td><?php echo $order['OrderNo']; ?></td>
                                    <td><?php echo htmlspecialchars($order['Username']); ?></td>
                                    <td><?php echo date('M d, Y', strtotime($order['OrderDate'])); ?></td>
                                    <td><?php echo $order['TotalQuantity']; ?></td>
                                    <td>RM <?php echo number_format($order['TotalAmount'], 2); ?></td>
                                    <td>
                                        <span class="payment-badge payment-<?php echo strtolower(str_replace(' ', '-', $order['PaymentType'])); ?>">
                                            <?php echo $order['PaymentType']; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <button onclick="viewOrderDetails(<?php echo $order['OrderNo']; ?>)" class="view-btn">
                                                <i class="fas fa-eye"></i> View
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination (can be implemented if needed) -->
                <div class="pagination">
                    <a href="#" class="page-link disabled"><i class="fas fa-chevron-left"></i></a>
                    <a href="#" class="page-link active">1</a>
                    <a href="#" class="page-link">2</a>
                    <a href="#" class="page-link">3</a>
                    <a href="#" class="page-link"><i class="fas fa-chevron-right"></i></a>
                </div>
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
                <div class="loading">
                    <i class="fas fa-spinner fa-spin"></i> Loading order details...
                </div>
            </div>
        </div>
    </div>

    <script>
        // View Order Details
        function viewOrderDetails(orderId) {
            $('#orderModal').show();
            $('#orderDetailsContent').html('<div class="loading"><i class="fas fa-spinner fa-spin"></i> Loading order details...</div>');
            
            // Fetch order details via AJAX
            $.ajax({
                url: 'fetchOrderDetails.php',
                method: 'GET',
                data: { order_id: orderId },
                success: function(data) {
                    $('#orderDetailsContent').html(data);
                },
                error: function() {
                    $('#orderDetailsContent').html('<div class="error-message">Error loading order details. Please try again.</div>');
                }
            });
        }

        // Close Order Modal
        function closeOrderModal() {
            $('#orderModal').hide();
        }

        // Close modal when clicking outside of it
        $(window).click(function(event) {
            if ($(event.target).is('#orderModal')) {
                closeOrderModal();
            }
        });
    </script>

    <script src="../js/Scripts.js"></script>
    <?php include 'footer.php'; ?>
</body>
</html> 