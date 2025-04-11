<?php
require_once("base.php");

// Check if user is admin
requireAdmin();

// Replace the search query section with this simpler version
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$query = "
    SELECT u.UserID, u.Username, u.Email, u.ContactNo, u.ProfilePic,
           a.Street, a.City, a.State, a.PostalCode,
           COUNT(DISTINCT o.OrderNo) as TotalOrders
    FROM users u
    LEFT JOIN address a ON u.UserID = a.UserID
    LEFT JOIN orders o ON u.UserID = o.UserID
    WHERE u.Role = 'customer'";

if (!empty($search)) {
    $query .= " AND (u.Username LIKE ? OR u.UserID LIKE ? OR u.Email LIKE ?)";
    $searchParam = "%$search%";
    $params = [$searchParam, $searchParam, $searchParam];
}

$query .= " GROUP BY u.UserID";

$stmt = $_db->prepare($query);
if (!empty($search)) {
    $stmt->execute($params);
} else {
    $stmt->execute();
}
$customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
$totalCustomers = count($customers);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Management - Secret Shelf</title>
    <link rel="stylesheet" href="../css/NavbarStyles.css">
    <link rel="stylesheet" href="../css/AdminStyles.css">
    <link rel="stylesheet" href="../css/AdminCheckCust.css">
    <link rel="icon" type="image/x-icon" href="../img/Logo.png">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/AdminScripts.js"></script>
</head>

<body>
    <?php require_once("navbaradmin.php") ?>

    <a class="back-button" onclick="window.location.href='AdminMainPage.php'">
        <img src="../upload/icon/back.png" alt="Back" class="back-icon"> Back to Dashboard
    </a>

        <div class="customer-stats-header">
            <div class="total-customers">
                <span class="stats-label">Total Customers</span>
                <span class="stats-number"><?= $totalCustomers ?></span>
            </div>
        </div>

        <div class="admin-container">
            <div class="admin-header">
                <h1>Customer Management</h1>
                <p>Customer list and information</p>
            </div>

            <div class="search-section">
                <form action="" method="GET" class="search-form">
                    <div class="search-wrapper">
                        <input type="text"
                            name="search"
                            placeholder="Search by name, ID, or email..."
                            value="<?= htmlspecialchars($search) ?>"
                            class="search-input">
                        <button type="submit" class="search-but">
                            <img src="../upload/icon/search.png" alt="Search" class="search-icon">
                        </button>
                    </div>
                    <?php if (!empty($search)): ?>
                        <a href="AdminCheckCust.php" class="reset-button">Reset</a>
                    <?php endif; ?>
                </form>
            </div>

            <div class="customers-grid">
                <?php foreach ($customers as $customer): ?>
                    <div class="customer-card">
                        <div class="customer-header">
                            <img src="<?= htmlspecialchars($customer['ProfilePic']) ?>"
                                alt="Profile Picture"
                                class="customer-avatar">
                            <div class="customer-basic-info">
                                <h3><?= htmlspecialchars($customer['Username']) ?></h3>
                                <p>ID: <?= htmlspecialchars($customer['UserID']) ?></p>
                            </div>
                        </div>
                        <div class="customer-details">
                            <div class="info-group">
                                <label>Email:</label>
                                <p><?= htmlspecialchars($customer['Email']) ?></p>
                            </div>
                            <div class="info-group">
                                <label>Contact:</label>
                                <p><?= htmlspecialchars($customer['ContactNo']) ?></p>
                            </div>
                            <div class="info-group">
                                <label>Address:</label>
                                <p><?= $customer['Street'] ?
                                        htmlspecialchars($customer['Street'] . ', ' .
                                            $customer['City'] . ', ' .
                                            $customer['State'] . ' ' .
                                            $customer['PostalCode']) :
                                        'No address provided' ?></p>
                            </div>
                            <div class="customer-stats">
                                <div class="stat">
                                    <span>Orders</span>
                                    <strong><?= $customer['TotalOrders'] ?></strong>
                                </div>

                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
</body>

</html>