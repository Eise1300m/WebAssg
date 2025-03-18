<?php
session_start();
require_once("connection.php");

if (!isset($_SESSION['user_name'])) {
    header("Location: UserLogin.php");
    exit;
}

$username = $_SESSION['user_name'];

$stmt = $_db->prepare("SELECT UserID, ProfilePic FROM users WHERE UserName = ?");
$stmt->execute([$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("User not found.");
}

$user_id = $user['UserID'];

// 🔹 Fetch all orders for the logged-in user
$stmt = $_db->prepare("SELECT * FROM orders WHERE UserID = ? ORDER BY OrderDate DESC");
$stmt->execute([$user_id]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History - Secret Shelf</title>
    <link rel="stylesheet" href="../css/HomeStyles.css">
    <link rel="stylesheet" href="../css/ProfileStyles.css">
    <link rel="stylesheet" href="../css/OrderStyles.css">
    <link rel="stylesheet" href="../css/NavbarStyles.css">
    <link rel="stylesheet" href="../css/FooterStyles.css">
    <link rel="icon" type="image/x-icon" href="../img/Logo.png">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/Scripts.js"></script>
</head>

<body>
    <?php include_once("navbar.php"); ?>

    <main class="profile-container">
        <div class="profile-header">
            <h1>Order History</h1>
            <p>View your past orders</p>
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
                <div class="orders-section">
                    <?php if (empty($orders)): ?>
                        <p class="no-orders">No orders found.</p>
                        <?php else:
                        $order_count = count($orders);
                        foreach ($orders as $order):
                        ?>
                            <div class="order-card">
                                <div class="order-header">
                                    <h3>Order #<?php echo $order_count; ?></h3>
                                    <span class="order-date"><?php echo $order['OrderDate']; ?></span>
                                </div>
                                <div class="order-details">
                                    <p><strong>Total Items:</strong> <?php echo $order['TotalQuantity']; ?></p>
                                    <p><strong>Total Price:</strong> RM <?php echo number_format($order['TotalAmount'], 2); ?></p>
                                    <a href="UserOrderHistoryDetails.php?order_id=<?php echo $order['OrderNo']; ?>"
                                        class="view-details-btn">View Details</a>
                                </div>
                            </div>
                    <?php
                            $order_count--;
                        endforeach;
                    endif;
                    ?>
                </div>
            </div>
        </div>
    </main>

    <?php include 'footer.php'; ?>

</body>

</html>