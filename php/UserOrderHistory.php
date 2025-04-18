<?php
session_start();
require_once("base.php");

requireLogin();

includeNavbar();

// Handle order collection confirmation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'confirm_collection') {
    $response = confirmOrderCollection($_POST['order_id']);
    echo json_encode($response);
    exit();
}

// Handle order cancellation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'cancel_order') {
    header('Content-Type: application/json');
    
    // Get user ID
    $stmt = $_db->prepare("SELECT UserID FROM users WHERE UserName = ?");
    $stmt->execute([$_SESSION['user_name']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$user) {
        setSuccessMessage('User not found');
        echo json_encode(['success' => false, 'message' => 'User not found']);
        exit();
    }
    
    $user_id = $user['UserID'];
    $order_id = $_POST['order_id'];
    
    try {
        $checkStmt = $_db->prepare("SELECT OrderStatus FROM orders WHERE OrderNo = ? AND UserID = ?");
        $checkStmt->execute([$order_id, $user_id]);
        $order = $checkStmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$order) {
            setSuccessMessage('Order not found or does not belong to you');
            echo json_encode(['success' => false, 'message' => 'Order not found or does not belong to you']);
            exit();
        }
        
        if ($order['OrderStatus'] !== 'Preparing') {
            setSuccessMessage('Only orders in Preparing status can be cancelled');
            echo json_encode(['success' => false, 'message' => 'Only orders in Preparing status can be cancelled']);
            exit();
        }
        
        // Update the order status
        $stmt = $_db->prepare("UPDATE orders SET OrderStatus = 'Cancelled' WHERE OrderNo = ? AND UserID = ?");
        $stmt->execute([$order_id, $user_id]);
        
        if ($stmt->rowCount() > 0) {
            setSuccessMessage('Order cancelled successfully');
            echo json_encode(['success' => true, 'message' => 'Order cancelled successfully']);
        } else {
            setSuccessMessage('Failed to cancel order');
            echo json_encode(['success' => false, 'message' => 'Failed to cancel order']);
        }
    } catch (PDOException $e) {
        setSuccessMessage('Database error: ' . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
    exit();
}

$username = $_SESSION['user_name'];

$stmt = $_db->prepare("SELECT UserID, ProfilePic FROM users WHERE UserName = ?");
$stmt->execute([$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("User not found.");
}

$user_id = $user['UserID'];

// Get total number of orders for the user
$stmt = $_db->prepare("SELECT COUNT(*) as total_orders FROM orders WHERE UserID = ?");
$stmt->execute([$user_id]);
$order_count = $stmt->fetch(PDO::FETCH_ASSOC)['total_orders'];

// Fetch all orders for the logged-in user
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
    <link rel="stylesheet" href="../css/OrderStyles.css">
    <link rel="stylesheet" href="../css/ProfileStyles.css">
    <link rel="stylesheet" href="../css/NavbarStyles.css">
    <link rel="stylesheet" href="../css/FooterStyles.css">
    <link rel="icon" type="image/x-icon" href="../img/Logo.png">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="../js/order.js"></script>
</head>

<body data-page="orders">

    <a class="redirect-button" data-redirect-url="MainPage.php">
        <img src="../upload/icon/back.png" alt="Back" class="back-icon" style="width: 30px; height: 30px;"> Continue Shopping
    </a>
    <main class="order-history-container">
        <div class="profile-container">
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
                                <a href="MainPage.php" class="browse-btn">Browse Books</a>
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
                                        <p><strong>Total Price:</strong> RM <?php echo number_format($order['TotalAmount'], 2); ?></p>
                                        <p><strong>Status:</strong>
                                            <span class="order-status <?php echo strtolower($order['OrderStatus']); ?>">
                                                <?php echo htmlspecialchars($order['OrderStatus']); ?>
                                            </span>
                                        </p>
                                        <div class="order-actions">
                                            <?php if ($order['OrderStatus'] === 'Delivering'): ?>
                                                <button class="collect-btn" data-order-id="<?php echo htmlspecialchars($order['OrderNo']); ?>">
                                                    <img src="../upload/icon/check.png" alt="Collect" style="width: 12px; height: 12px; filter: invert(1);">
                                                    Confirm Collection
                                                </button>
                                            <?php endif; ?>
                                            <?php if ($order['OrderStatus'] === 'Preparing'): ?>
                                                <button class="cancel-btn" data-order-id="<?php echo htmlspecialchars($order['OrderNo']); ?>">
                                                    <img src="../upload/icon/cancel.png" alt="Cancel" style="width: 15px; height: 15px; filter: invert(1);">
                                                    Cancel Order
                                                </button>
                                            <?php endif; ?>
                                            <a href="UserOrderHistoryDetails.php?order_id=<?php echo htmlspecialchars($order['OrderNo']); ?>"
                                                class="view-details-btn">
                                                <img src="../upload/icon/view.png" alt="View" style="width: 17px; height: 17px; filter: invert(1);">
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

    <?php include 'footer.php'; ?>
    <script src="../js/Scripts.js"></script>

</body>

</html>