<?php
session_start();
require_once("base.php");
require_once("../lib/PaginationHelper.php");

requireAdmin();

// Get pagination parameters
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$itemsPerPage = isset($_GET['items_per_page']) ? intval($_GET['items_per_page']) : 10;
$itemsPerPage = in_array($itemsPerPage, [10, 25, 50, 100]) ? $itemsPerPage : 10;

// Determine if showing all sales or date-filtered sales
$showAllSales = empty($_GET['start_date']) || empty($_GET['end_date']);

if ($showAllSales) {
    // Show all-time sales
    $startDate = '2000-01-01 00:00:00'; // A date far in the past
    $endDate = date('Y-m-d') . ' 23:59:59'; // Today
    $displayStartDate = '';
    $displayEndDate = '';
} else {
    // Show filtered sales based on date range
    $startDate = $_GET['start_date'] . ' 00:00:00';
    $endDate = $_GET['end_date'] . ' 23:59:59';
    $displayStartDate = $_GET['start_date'];
    $displayEndDate = $_GET['end_date'];
}

// Build query for book sales
$baseQuery = "SELECT b.BookNo, b.BookName, b.BookPrice, 
                     SUM(od.Quantity) as TotalQuantity,
                     SUM(od.Quantity * b.BookPrice) as TotalSales,
                     COUNT(DISTINCT o.OrderNo) as TotalOrders
              FROM book b
              JOIN orderdetails od ON b.BookNo = od.BookNo
              JOIN orders o ON od.OrderNo = o.OrderNo
              WHERE o.OrderDate BETWEEN ? AND ?
              GROUP BY b.BookNo, b.BookName, b.BookPrice";

$params = [$startDate, $endDate];

// Get pagination helper
$paginationHelper = PaginationHelper::getInstance();

// Get paginated sales data
$pagination = $paginationHelper->paginate($baseQuery, "ORDER BY TotalSales DESC", $params, $page, $itemsPerPage);
$salesData = $pagination['items'];

// Calculate total sales for the period
$totalSalesQuery = "SELECT SUM(od.Quantity * b.BookPrice) as GrandTotal
                   FROM book b
                   JOIN orderdetails od ON b.BookNo = od.BookNo
                   JOIN orders o ON od.OrderNo = o.OrderNo
                   WHERE o.OrderDate BETWEEN ? AND ?";
$stmt = $_db->prepare($totalSalesQuery);
$stmt->execute([$startDate, $endDate]);
$totalSales = $stmt->fetch(PDO::FETCH_ASSOC)['GrandTotal'] ?? 0;

// Calculate total books sold
$totalBooksQuery = "SELECT SUM(od.Quantity) as TotalBooksSold
                   FROM orderdetails od
                   JOIN orders o ON od.OrderNo = o.OrderNo
                   WHERE o.OrderDate BETWEEN ? AND ?";
$stmt = $_db->prepare($totalBooksQuery);
$stmt->execute([$startDate, $endDate]);
$totalBooksSold = $stmt->fetch(PDO::FETCH_ASSOC)['TotalBooksSold'] ?? 0;

// Calculate total orders
$totalOrdersQuery = "SELECT COUNT(DISTINCT o.OrderNo) as TotalOrders
                    FROM orders o
                    WHERE o.OrderDate BETWEEN ? AND ?";
$stmt = $_db->prepare($totalOrdersQuery);
$stmt->execute([$startDate, $endDate]);
$totalOrders = $stmt->fetch(PDO::FETCH_ASSOC)['TotalOrders'] ?? 0;

// Get date range
$dateRangeText = $showAllSales ? "All Time" : "From " . date('M j, Y', strtotime($startDate)) . " to " . date('M j, Y', strtotime($endDate));

includeAdminNav();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Report - Secret Shelf</title>
    <link rel="stylesheet" href="../css/AdminStyles.css">
    <link rel="stylesheet" href="../css/AdminSalesReport.css">
    <link rel="stylesheet" href="../css/NavbarStyles.css">
    <link rel="stylesheet" href="../css/HomeStyles.css">
    <link rel="icon" type="image/x-icon" href="../img/Logo.png">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

    <main class="container">
        <div class="admin-header">
            <h1>Sales Report</h1>
            <p>View book sales and revenue <?php echo $dateRangeText; ?></p>
        </div>

        <div class="contentcontainer">
            <a href="AdminMainPage.php" class="admin-nav-back">
                <img src="../upload/icon/back.png" alt="Back"> Back to Dashboard
            </a>

            <!-- Date Range Filter -->
            <div class="date-filter-container">
                <form action="AdminSalesReport.php" method="GET" class="date-filter-form">
                    <div class="date-range-group">
                        <div class="date-input">
                            <label for="start_date">From:</label>
                            <input type="date" id="start_date" name="start_date" 
                                   value="<?php echo htmlspecialchars($displayStartDate); ?>" required>
                        </div>
                        <div class="date-input">
                            <label for="end_date">To:</label>
                            <input type="date" id="end_date" name="end_date" 
                                   value="<?php echo htmlspecialchars($displayEndDate); ?>" required>
                        </div>
                        <button type="submit" class="apply-date-btn">Apply</button>

                        <a href="AdminSalesReport.php" class="reset">Reset</a>
                    </div>
                </form>
            </div>

            <!-- Summary Cards -->
            <div class="summary-cards">
                <div class="summary-card">
                    <div class="card-icon">
                        <img src="../upload/icon/book.png" alt="Book" style="width: 25px; height: 25px;">
                    </div>
                    <div class="card-info">
                        <span>Total Books Sold</span>
                        <h3><?php echo number_format($totalBooksSold); ?></h3>
                    </div>
                </div>
                <div class="summary-card">
                    <div class="card-icon">
                        <img src="../upload/icon/shoppingcart.png" alt="Shopping Cart" style="width: 25px; height: 25px;">
                    </div>
                    <div class="card-info">
                        <span>Total Orders</span>
                        <h3><?php echo number_format($totalOrders); ?></h3>
                    </div>
                </div>
                <div class="summary-card">
                    <div class="card-icon">
                        <img src="../upload/icon/sales.png" alt="Money" style="width: 25px; height: 25px;">
                    </div>
                    <div class="card-info">
                        <span>Total Revenue</span>
                        <h3>RM <?php echo number_format($totalSales, 2); ?></h3>
                    </div>
                </div>
            </div>

            <!-- Sales Table -->
            <div class="sales-table-container">
                <table class="sales-table">
                    <thead>
                        <tr>
                            <th>Book ID</th>
                            <th>Book Name</th>
                            <th>Unit Price</th>
                            <th>Quantity Sold</th>
                            <th>Total Orders</th>
                            <th>Total Sales</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($salesData)): ?>
                            <tr>
                                <td colspan="6" class="no-results">No sales data found for the selected period.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($salesData as $sale): ?>
                                <tr>
                                    <td><?php echo $sale['BookNo']; ?></td>
                                    <td><?php echo htmlspecialchars($sale['BookName']); ?></td>
                                    <td>RM <?php echo number_format($sale['BookPrice'], 2); ?></td>
                                    <td><?php echo number_format($sale['TotalQuantity']); ?></td>
                                    <td><?php echo number_format($sale['TotalOrders']); ?></td>
                                    <td>RM <?php echo number_format($sale['TotalSales'], 2); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination Summary -->
            <div class="pagination-summary">
                Showing <?php echo count($salesData); ?> of <?php echo $pagination['totalItems']; ?> sales
                (Page <?php echo $pagination['currentPage']; ?> of <?php echo $pagination['totalPages']; ?>)
            </div>

            <!-- Pagination -->
            <div class="pagination">
                <?php
                // Build the URL pattern preserving existing parameters
                $urlParams = $_GET;
                unset($urlParams['page']); // Remove page so we can set it in the pattern
                $queryString = http_build_query($urlParams);
                $urlPattern = 'AdminSalesReport.php?' . ($queryString ? $queryString . '&' : '') . 'page=:page';

                // Previous button
                if ($pagination['currentPage'] > 1) {
                    echo '<a href="' . str_replace(':page', $pagination['currentPage'] - 1, $urlPattern) . '" class="page-link prev">&laquo;</a>';
                } else {
                    echo '<span class="page-link disabled">&laquo;</span>';
                }

                // Show first 3 pages
                for ($i = 1; $i <= min(3, $pagination['totalPages']); $i++) {
                    if ($i == $pagination['currentPage']) {
                        echo '<span class="page-link current">' . $i . '</span>';
                    } else {
                        echo '<a href="' . str_replace(':page', $i, $urlPattern) . '" class="page-link">' . $i . '</a>';
                    }
                }

                // Show ellipsis if there are more pages
                if ($pagination['totalPages'] > 3) {
                    echo '<span class="page-link dots">...</span>';
                }

                // Next button
                if ($pagination['currentPage'] < $pagination['totalPages']) {
                    echo '<a href="' . str_replace(':page', $pagination['currentPage'] + 1, $urlPattern) . '" class="page-link next">&raquo;</a>';
                } else {
                    echo '<span class="page-link disabled">&raquo;</span>';
                }
                ?>
            </div>
        </div>
    </main>

    <script src="../js/Scripts.js"></script>
</body>
</html>
