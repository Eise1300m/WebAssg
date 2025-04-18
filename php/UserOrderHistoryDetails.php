<?php
session_start();
require_once("base.php");

requireLogin();

includeNavbar();

$username = $_SESSION['user_name'];

$stmt = $_db->prepare("SELECT UserID, ProfilePic FROM users WHERE UserName = ?");
$stmt->execute([$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("User not found.");
}

$user_id = $user['UserID'];

// Get order ID from URL
$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : null;

if (!$order_id) {
    header("Location: UserOrderHistory.php");
    exit;
}

// Fetch order details
$stmt = $_db->prepare("SELECT * FROM orders WHERE OrderNo = ? AND UserID = ?");
$stmt->execute([$order_id, $user_id]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    header("Location: UserOrderHistory.php");
    exit;
}

// Fetch order items - using the correct table names
$stmt = $_db->prepare("
    SELECT od.*, b.BookName, b.BookImage 
    FROM orderdetails od
    JOIN book b ON od.BookNo = b.BookNo
    WHERE od.OrderNo = ?
");
$stmt->execute([$order_id]);
$order_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details - Secret Shelf</title>
    <link rel="stylesheet" href="../css/HomeStyles.css">
    <link rel="stylesheet" href="../css/OrderStyles.css">
    <link rel="stylesheet" href="../css/ProfileStyles.css">
    <link rel="stylesheet" href="../css/NavbarStyles.css">
    <link rel="stylesheet" href="../css/FooterStyles.css">
    <link rel="icon" type="image/x-icon" href="../img/Logo.png">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body data-page="orders">

    <main class="order-history-container">
        <div class="profile-container">
            <div class="profile-header">
                <h1>Order Details</h1>
                <p>Order #<?php echo $order_id; ?></p>
            </div>

            <div class="profile-content">
                <div class="profile-sidebar">
                    <div class="profile-avatar">
                        <img src="<?php echo !empty($user['ProfilePic']) ? htmlspecialchars($user['ProfilePic']) : '../upload/icon/UnknownUser.jpg'; ?>"
                            alt="Profile Picture" id="profile-pic">
                    </div>
                    <nav class="profile-nav">
                        <a href="UserEditProfile.php">Personal Information</a>
                        <a href="UserEditProfile.php#security">Security</a>
                        <a href="UserOrderHistory.php" class="active">Order History</a>
                    </nav>
                </div>

                <div class="profile-main">
                    <div class="order-details-section">
                        <div class="order-summary-card">
                            <div class="order-header">
                                <h3>Order Summary</h3>
                                <span class="order-date">
                                    <?php echo date('F j, Y', strtotime($order['OrderDate'])); ?>
                                </span>
                            </div>
                            <div class="order-info">
                                <p>
                                    </i> Total Items:
                                    <?php echo $order['TotalQuantity']; ?>
                                </p>
                                <p>
                                    Total Price:
                                    RM <?php echo number_format($order['TotalAmount'], 2); ?>
                                </p>
                                <p>
                                    Status:
                                    <span class="order-status <?php echo strtolower($order['OrderStatus']); ?>">
                                        <?php echo $order['OrderStatus']; ?>
                                    </span>
                                </p>
                            </div>
                        </div>

                        <div class="order-items-section">
                            <h3>Order Items</h3>
                            <div class="order-items-list">
                                <?php foreach ($order_items as $item): ?>
                                    <div class="order-item-card">
                                        <div class="item-image">
                                            <img src="<?php echo htmlspecialchars($item['BookImage']); ?>"
                                                alt="<?php echo htmlspecialchars($item['BookName']); ?>">
                                        </div>
                                        <div class="item-details">
                                            <h4><?php echo htmlspecialchars($item['BookName']); ?></h4>
                                            <p class="quantity">Quantity: <?php echo $item['Quantity']; ?></p>
                                            <p class="price">Price: RM <?php echo number_format($item['Price'], 2); ?></p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="order-actions">
                            <?php if ($order['OrderStatus'] === 'Delivering'): ?>
                                <button class="collect-btn" data-order-id="<?php echo htmlspecialchars($order['OrderNo']); ?>">
                                    <i class="fa fa-check"></i>
                                    Confirm Collection
                                </button>
                            <?php endif; ?>
                            <a href="UserOrderHistory.php" class="back-btn">
                                <img src="../upload/icon/back.png" alt="Back" class="back-icon" style="width: 20px; height: 20px;">
                                Back to Orders
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>

</html>