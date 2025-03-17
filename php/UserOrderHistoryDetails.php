<?php
session_start();
require_once("connection.php");

if (!isset($_SESSION['user_name']) || !isset($_GET['order_id'])) {
    header("Location: UserOrderHistory.php");
    exit;
}

$order_id = $_GET['order_id'];

// 🔹 Get the UserID from the users table
$stmt = $_db->prepare("SELECT UserID, ProfilePic FROM users WHERE UserName = ?");
$stmt->execute([$_SESSION['user_name']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("User not found.");
}

$user_id = $user['UserID'];

// 🔹 Fetch all orders for this user, sorted by date (newest first)
$stmt = $_db->prepare("SELECT OrderNo FROM orders WHERE UserID = ? ORDER BY OrderDate DESC");
$stmt->execute([$user_id]);
$user_orders = $stmt->fetchAll(PDO::FETCH_COLUMN); // Get only OrderNo values

// 🔹 Find the position of the current order
$order_index = array_search($order_id, $user_orders);
if ($order_index === false) {
    die("Order not found.");
}
$user_order_number = count($user_orders) - $order_index; // Convert index to display number

// 🔹 Fetch order details
$stmt = $_db->prepare("SELECT * FROM orders WHERE OrderNo = ?");
$stmt->execute([$order_id]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

// 🔹 Fetch books in this order
$stmt = $_db->prepare("SELECT od.*, b.BookName, b.BookImage 
                       FROM orderdetails od
                       JOIN book b ON od.BookNo = b.BookNo
                       WHERE od.OrderNo = ?");
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
    <link rel="stylesheet" href="../css/ProfileStyles.css">
    <link rel="stylesheet" href="../css/OrderStyles.css">
    <link rel="stylesheet" href="../css/NavbarStyles.css">
    <link rel="stylesheet" href="../css/FooterStyles.css">
    <link rel="icon" type="image/x-icon" href="../img/Logo.png">
</head>

<body>
    <?php include_once("navbar.php"); ?>

    <main class="profile-container">
        <div class="profile-header">
            <h1>Order Details</h1>
            <p>Order #<?php echo $user_order_number; ?></p>
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
                    <div class="order-summary">
                        <p><strong>Date:</strong> <?php echo $order['OrderDate']; ?></p>
                        <p><strong>Total Items:</strong> <?php echo $order['TotalQuantity']; ?></p>
                        <p><strong>Total Price:</strong> RM <?php echo number_format($order['TotalAmount'], 2); ?></p>
                    </div>

                    <h3>Books in this order:</h3>
                    <div class="books-grid">
                        <?php foreach ($order_items as $item): ?>
                            <div class="book-card">
                                <img src="<?php echo $item['BookImage'] ?: '../images/no-cover.png'; ?>" 
                                     alt="<?php echo htmlspecialchars($item['BookName']); ?>">
                                <div class="book-info">
                                    <h4><?php echo htmlspecialchars($item['BookName']); ?></h4>
                                    <p><strong>Quantity:</strong> <?php echo $item['Quantity']; ?></p>
                                    <p><strong>Subtotal:</strong> RM <?php echo number_format($item['Price'], 2); ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="back-section">
                        <a href="UserOrderHistory.php" class="back-btn">Back to Order History</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>

</html>