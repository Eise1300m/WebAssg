<?php
session_start();
require_once("../base.php");

requireLogin();

includeNavbar();
displayFlashMessage();

$username = $_SESSION['user_name'];

$stmt = $_db->prepare("SELECT UserID, ProfilePic, Username FROM users WHERE UserName = ?");
$stmt->execute([$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("User not found.");
}

$user_id = $user['UserID'];

$stmt = $_db->prepare("SELECT COUNT(*) as total_orders FROM orders WHERE UserID = ?");
$stmt->execute([$user_id]);
$order_count = $stmt->fetch(PDO::FETCH_ASSOC)['total_orders'];

$stmt = $_db->prepare("SELECT * FROM orders WHERE UserID = ? ORDER BY OrderDate DESC");
$stmt->execute([$user_id]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get the user's first order number (if any)
$firstOrderStmt = $_db->prepare("SELECT OrderNo FROM orders WHERE UserID = ? ORDER BY OrderDate ASC LIMIT 1");
$firstOrderStmt->execute([$user_id]);
$firstOrder = $firstOrderStmt->fetch(PDO::FETCH_ASSOC);
$firstOrderId = $firstOrder ? $firstOrder['OrderNo'] : null;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History - Secret Shelf</title>
    <link rel="stylesheet" href="../../css/HomeStyles.css">
    <link rel="stylesheet" href="../../css/OrderStyles.css">
    <link rel="stylesheet" href="../../css/ProfileStyles.css">
    <link rel="stylesheet" href="../../css/NavbarStyles.css">
    <link rel="stylesheet" href="../../css/FooterStyles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../../js/order.js"></script>
    <script src="/WebAssg/js/Scripts.js"></script>

</head>

<body data-page="orders">

    <a class="redirect-button" data-redirect-url="/WebAssg/php/MainPage.php">
        <img src="/WebAssg/upload/icon/back.png" alt="Back" class="back-icon" style="width: 30px; height: 30px;"> Continue Shopping
    </a>
    <main class="order-history-container">
        <div class="profile-container">
            <div class="profile-header">
                <h1>Order History</h1>
                <p>View your past orders</p>
            </div>

            <div class="profile-content">
                <div class="profile-sidebar">
                <div class="user-profile" style="text-align: center;">
                    <img src="<?php echo !empty($user['ProfilePic']) ? htmlspecialchars($user['ProfilePic']) : '/WebAssg/upload/icon/UnknownUser.jpg'; ?>"
                        alt="User Profile" class="profile-avatar" id="profile-pic">
                    <p>Customer</p>
                    <h3><?php echo htmlspecialchars($user['Username']); ?></h3>

                </div>
                    <nav class="profile-nav">
                        <a href="UserEditProfile.php">Personal Information</a>
                        <a href="UserSecurity.php">Security</a>
                        <a href="UserOrderHistory.php" class="active">Order History</a>
                    </nav>
                </div>

                <div class="profile-main">
                    <div class="orders-section">
                        <?php if (empty($orders)): ?>
                            <div class="no-orders">
                                <h3>No Orders Yet</h3>
                                <p>You haven't placed any orders yet.</p>
                                <a href="/WebAssg/php/MainPage.php" class="browse-btn">Browse Books</a>
                            </div>
                        <?php else: ?>
                            <?php foreach ($orders as $order): ?>
                                <div class="order-card">
                                    <div class="order-header">
                                        <h3>Order #<?php echo htmlspecialchars($order['OrderNo']); ?></h3>
                                        <span class="order-date">
                                            <?php echo date('F j, Y', strtotime($order['OrderDate'])); ?>
                                        </span>
                                    </div>
                                    <div class="order-details">
                                        <p><strong>Total Items:</strong> <?php echo htmlspecialchars($order['TotalQuantity']); ?></p>
                                        <p><strong>Shipping Fee:</strong> RM 5.00</p>
                                        <?php if ($order['OrderNo'] == $firstOrderId): ?>
                                            <p><strong>First Order Discount:</strong> <span style="color: #4CAF50;">20% OFF</span></p>
                                        <?php endif; ?>
                                        <p><strong>Total Price:</strong> RM <?php echo number_format($order['TotalAmount'], 2); ?></p>
                                        <p><strong>Status:</strong>
                                            <span class="order-status <?php echo strtolower($order['OrderStatus']); ?>">
                                                <?php echo htmlspecialchars($order['OrderStatus']); ?>
                                            </span>
                                        </p>
                                        <div class="order-actions">
                                            <?php if ($order['OrderStatus'] === 'Delivering'): ?>
                                                <button class="collect-btn" data-order-id="<?php echo htmlspecialchars($order['OrderNo']); ?>">
                                                    <img src="/WebAssg/upload/icon/check.png" alt="Collect" style="width: 12px; height: 12px; filter: invert(1);">
                                                    Confirm Collection
                                                </button>
                                            <?php endif; ?>
                                            <?php if ($order['OrderStatus'] === 'Preparing'): ?>
                                                <button class="cancel-btn" data-order-id="<?php echo htmlspecialchars($order['OrderNo']); ?>">
                                                    <img src="/WebAssg/upload/icon/cancel.png" alt="Cancel" style="width: 15px; height: 15px; filter: invert(1);">
                                                    Cancel Order
                                                </button>
                                            <?php endif; ?>
                                            <a href="UserOrderHistoryDetails.php?order_id=<?php echo htmlspecialchars($order['OrderNo']); ?>"
                                                class="view-details-btn">
                                                <img src="/WebAssg/upload/icon/view.png" alt="View" style="width: 17px; height: 17px; filter: invert(1);">
                                                View Details
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include '../../php/footer.php'; ?>

</body>

</html>