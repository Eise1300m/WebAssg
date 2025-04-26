<?php
session_start();
require_once("../base.php");
require_once("../../lib/PaginationHelper.php");

PaginationHelper::init($_db);

// Check if user is admin
requireAdmin();

// Set default values for pagination
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$itemsPerPage = isset($_GET['items_per_page']) ? intval($_GET['items_per_page']) : 10;
$itemsPerPage = in_array($itemsPerPage, [10, 25, 50, 100]) ? $itemsPerPage : 10;

// Get search parameters
$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
$statusFilter = isset($_GET['status']) ? $_GET['status'] : '';

// Build query
$baseQuery = "SELECT o.*, u.Username, u.Email 
               FROM orders o 
               JOIN users u ON o.UserID = u.UserID 
               WHERE 1=1";
$params = [];

// Apply filters
if (!empty($searchTerm)) {
    $baseQuery .= " AND (o.OrderNo LIKE ? OR u.Username LIKE ? OR u.Email LIKE ?)";
    $searchParam = "%$searchTerm%";
    $params[] = $searchParam;
    $params[] = $searchParam;
    $params[] = $searchParam;
}

if (!empty($statusFilter)) {
    $baseQuery .= " AND o.OrderStatus = ?";
    $params[] = $statusFilter;
}

$orderBy = "ORDER BY o.OrderDate DESC";

// Get pagination helper
$paginationHelper = PaginationHelper::getInstance();

// Get paginated orders
$pagination = $paginationHelper->paginate($baseQuery, $orderBy, $params, $page, $itemsPerPage);
$orders = $pagination['items'];

// Get orderstatuses
$stmt = $_db->query("SELECT DISTINCT OrderStatus FROM orders ORDER BY OrderStatus");
$orderStatuses = $stmt->fetchAll(PDO::FETCH_COLUMN);

includeAdminNav();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management - Secret Shelf</title>
    <link rel="stylesheet" href="/WebAssg/css/HomeStyles.css">
    <link rel="stylesheet" href="/WebAssg/css/NavbarStyles.css">
    <link rel="stylesheet" href="/WebAssg/css/FooterStyles.css">
    <link rel="stylesheet" href="/WebAssg/css/AdminOrders.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/WebAssg/js/Scripts.js"></script>
    <script src="/WebAssg/js/AdminScripts.js"></script>
</head>

<body>

    <main class="admin-container">
        <div class="admin-header">
            <h1>Order Listing</h1>
            <p>View and manage customer orders</p>
        </div>

        <div class="admin-content">
            <a href="AdminMainPage.php" class="admin-nav-back">
                <img src="/WebAssg/upload/icon/back.png" alt="Back"> Back to Dashboard
            </a>

            <!-- Search and Filter Form -->
            <div class="search-filter-container">
                <form action="AdminOrders.php" method="GET" class="search-filter-form">
                    <div class="search-group">
                        <input type="text" name="search" placeholder="Search by order ID or customer name" 
                               value="<?php echo htmlspecialchars($searchTerm); ?>">
                        
                    </div>

                    <div class="filter-group">
                        <select name="status">
                            <option value="">All Statuses</option>
                            <?php foreach ($orderStatuses as $status): ?>
                                <option value="<?php echo $status; ?>" <?php echo ($statusFilter === $status) ? 'selected' : ''; ?>>
                                    <?php echo $status; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <select name="items_per_page">
                            <?php foreach ([10, 25, 50, 100] as $value): ?>
                                <option value="<?php echo $value; ?>" <?php echo ($itemsPerPage === $value) ? 'selected' : ''; ?>>
                                    <?php echo $value; ?> per page
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <button type="submit" class="apply-filter-btn">Apply</button>
                        <a href="AdminOrders.php" class="reset-filter-btn">Reset</a>
                    </div>
                </form>
            </div>

            <div class="pagination-summary">
                Showing <?php echo count($orders); ?> of <?php echo $pagination['totalItems']; ?> orders
                (Page <?php echo $pagination['currentPage']; ?> of <?php echo $pagination['totalPages']; ?>)
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
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($orders)): ?>
                            <tr>
                                <td colspan="8" class="no-results">No orders found.</td>
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
                                        <span class="status-badge status-<?php echo strtolower($order['OrderStatus']); ?>">
                                            <?php echo $order['OrderStatus']; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="view-details" onclick="viewOrderDetails(<?php echo $order['OrderNo']; ?>)">
                                                <img src="/WebAssg/upload/icon/view.png" alt="View" class="action-icon" style="width: 13px; height: 13px;">
                                                View
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
            <?php
            // keep any existing filters/search parameters in the URL when paginating, 
            //so users don’t lose their place or search context when clicking to another page
            $urlParams = $_GET;
            unset($urlParams['page']); // Remove page so we can set it in the pattern
            $queryString = http_build_query($urlParams);
            $urlPattern = 'AdminOrders.php?' . ($queryString ? $queryString . '&' : '') . 'page=:page'; // build a URL pattern where ':page' will be replaced with the actual page number.

            // use PaginationHelper to generate the HTML for the page links.
            echo $paginationHelper->generatePaginationLinks(
                $pagination['currentPage'],
                $pagination['totalPages'],
                $urlPattern
            );
            ?>
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
</body>

<script src="/WebAssg/js/Scripts.js"></script>

</html>