<?php
session_start();
require_once("base.php");

// Check if user is admin
requireAdmin();

// Determine any filters from GET parameters
$dateFilter = isset($_GET['filter-date']) ? $_GET['filter-date'] : 'all';
$paymentFilter = isset($_GET['filter-payment']) ? $_GET['filter-payment'] : 'all';

// Pagination settings
$orders_per_page = 10;
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($current_page - 1) * $orders_per_page;

// Base query
$count_query = "SELECT COUNT(*) as total FROM orders o JOIN users u ON o.UserID = u.UserID WHERE 1=1";
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
    $count_query .= " AND DATE(o.OrderDate) = CURDATE()";
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
    $count_query .= " AND o.PaymentType = ?";
    $query .= " AND o.PaymentType = ?";
    $params[] = $paymentFilter;
}

// Get total number of orders
$stmt = $_db->prepare($count_query);
$stmt->execute($params);
$total_orders = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
$total_pages = ceil($total_orders / $orders_per_page);

// Add pagination to main query
$query .= " ORDER BY o.OrderDate DESC LIMIT $orders_per_page OFFSET $offset";

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
    <script src="../js/AdminScripts.js"></script>
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
                        <img src="../upload/icon/shoppingcart.png" alt="Total Orders">
                    </div>
                    <div class="stat-info">
                        <span>Total Orders</span>
                        <h3><?php echo $totalOrders; ?></h3>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <img src="../upload/icon/sales.png" alt="Total Sales">
                    </div>
                    <div class="stat-info">
                        <span>Total Sales</span>
                        <h3>RM <?php echo number_format($totalSales, 2); ?></h3>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <img src="../upload/icon/customer.png" alt="Total Customers">
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
                                <img src="../upload/icon/filter.png" style="width: 20px; height: 20px;"> Apply Filter
                            </button>
                            
                            <a href="AdminOrders.php" class="reset-btn">
                                <img src="../upload/icon/reset.png" style="width: 20px; height: 20px;"> Reset
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
                                            <button class="view-details" onclick="viewOrderDetails(<?php echo $order['OrderNo']; ?>)">
                                                <img src="../upload/icon/view.png" alt="View" class="action-icon" style="width: 13px; height: 13px;">
                                                View
                                            </button>
                                            <button class="status-btn <?php echo strtolower($order['OrderStatus']); ?>"
                                                    data-order-id="<?php echo $order['OrderNo']; ?>"
                                                    onclick="updateOrderStatus(<?php echo $order['OrderNo']; ?>, '<?php echo $order['OrderStatus']; ?>')"
                                                    <?php echo $order['OrderStatus'] === 'Complete' ? 'disabled' : ''; ?>>
                                                <img src="../upload/icon/<?php echo $order['OrderStatus'] === 'Complete' ? 'check.png' : 'package.png'; ?>" 
                                                     alt="Status" 
                                                     class="status-icon" 
                                                     style="width: 13px; height: 13px;">
                                                <?php echo $order['OrderStatus']; ?>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="pagination">
                    <?php if ($total_pages > 1): ?>
                        <!-- Previous page -->
                        <a href="<?php 
                            echo $current_page > 1 ? 
                                '?page=' . ($current_page - 1) . 
                                '&filter-date=' . $dateFilter . 
                                '&filter-payment=' . $paymentFilter 
                                : '#'; 
                            ?>" 
                            class="page-link <?php echo $current_page <= 1 ? 'disabled' : ''; ?>">
                            <img src="../upload/icon/arrowback.png" alt="Previous" class="arrow" style="width: 13px; height: 13px;">
                        </a>

                        <!-- Page numbers -->
                        <?php
                        // Calculate range of pages to show
                        $start_page = max(1, $current_page - 2);
                        $end_page = min($total_pages, $current_page + 2);

                        // Show first page if not in range
                        if ($start_page > 1) {
                            echo '<a href="?page=1&filter-date=' . $dateFilter . '&filter-payment=' . $paymentFilter . '" class="page-link">1</a>';
                            if ($start_page > 2) {
                                echo '<span class="page-link dots">...</span>';
                            }
                        }

                        // Show page numbers
                        for ($i = $start_page; $i <= $end_page; $i++) {
                            echo '<a href="?page=' . $i . '&filter-date=' . $dateFilter . '&filter-payment=' . $paymentFilter . '" 
                                    class="page-link ' . ($current_page == $i ? 'active' : '') . '">' . $i . '</a>';
                        }

                        // Show last page if not in range
                        if ($end_page < $total_pages) {
                            if ($end_page < $total_pages - 1) {
                                echo '<span class="page-link dots">...</span>';
                            }
                            echo '<a href="?page=' . $total_pages . '&filter-date=' . $dateFilter . '&filter-payment=' . $paymentFilter . '" class="page-link">' . $total_pages . '</a>';
                        }
                        ?>

                        <!-- Next page -->
                        <a href="<?php 
                            echo $current_page < $total_pages ? 
                                '?page=' . ($current_page + 1) . 
                                '&filter-date=' . $dateFilter . 
                                '&filter-payment=' . $paymentFilter 
                                : '#'; 
                            ?>" 
                            class="page-link <?php echo $current_page >= $total_pages ? 'disabled' : ''; ?>">
                            <img src="../upload/icon/arrowfoward.png" alt="Next" class="arrow" style="width: 13px; height: 13px;">
                        </a>
                    <?php endif; ?>
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
                <!-- Order details will load here using AJAX -->

            </div>
        </div>
    </div>


    <script src="../js/Scripts.js"></script>
</body>
</html> 