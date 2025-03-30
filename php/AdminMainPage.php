<?php
session_start();
require_once("connection.php");

// Ensure only admins can access
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: UserLogin.php");
    exit();
}

$username = $_SESSION['user_name'];

// Get admin info
$stmt = $_db->prepare("SELECT * FROM users WHERE Username = ? AND Role = 'admin'");
$stmt->execute([$username]);
$admin = $stmt->fetch(PDO::FETCH_ASSOC);

// Debugging output
if (!$admin) {
    die("Admin not found or not an admin.");
}

// Check if Username key exists
if (!isset($admin['Username'])) {
    die("Username key is missing in the admin data.");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Secret Shelf</title>
    <link rel="stylesheet" href="../css/NavbarStyles.css">
    <link rel="stylesheet" href="../css/HomeStyles.css">
    <link rel="stylesheet" href="../css/AdminStyles.css">
    <link rel="stylesheet" href="../css/FooterStyles.css">
    <link rel="icon" type="image/x-icon" href="../img/Logo.png">
</head>

<body>

    <?php require_once("navbaradmin.php") ?>

    <main class="admin-container">
        <div class="admin-header">
            <h1>Admin Dashboard</h1>
            <p>Manage Bookstore</p>
        </div>

        <div class="admin-content">
            <div class="admin-sidebar">
                <div class="admin-profile" style="text-align: center;">
                    <img src="<?php echo !empty($admin['ProfilePic']) ? htmlspecialchars($admin['ProfilePic']) : '../upload/icon/UnknownUser.jpg'; ?>"
                        alt="Admin Profile" class="admin-avatar" style="display: block; margin: 0 auto;">
                    <h3><?php echo htmlspecialchars($admin['Username']); ?></h3>
                    <p>Administrator</p>
                </div>
                <nav class="admin-nav">

                    <a href="AdminProfile.php" class="admin-nav-item">
                        <img src="../upload/icon/profile.png" alt="Profile" class="nav-icon">
                        Admin Profile
                    </a>
                    <a href="AdminUpdatePassword.php" class="admin-nav-item">
                        <img src="../upload/icon/lock.png" alt="Security" class="nav-icon">
                        Admin Security
                    </a>

                </nav>
            </div>

            <div class="admin-main">
                <div class="admin-cards">
                    <div class="admin-card" onclick="window.location.href='AdminProductManagement.php'">
                        <img src="../upload/icon/product.png" alt="Products" class="card-icon">
                        <h3>Product Management</h3>
                        <p>Add, edit, or remove books from inventory</p>
                    </div>


                    <div class="admin-card" onclick="window.location.href='AdminOrders.php'">
                        <img src="../upload/icon/shoppingcart.png" alt="Orders" class="card-icon">
                        <h3>Order Management</h3>
                        <p>View and manage customer orders</p>
                    </div>

                    <div class="admin-card" onclick="window.location.href='AdminSignUp.php'">
                        <img src="../upload/icon/registration.png" alt="SignUp" class="card-icon">
                        <h3>Admin Registeration</h3>
                        <p>View and manage admin registeration</p>
                    </div>

                    <div class="admin-card" onclick="window.location.href='AdminDeliveryRequests.php'">
                        <div class="notification-badge" id="pendingOrdersCount"></div>
                        <img src="../upload/icon/delivery.png" alt="Delivery" class="card-icon">
                        <h3>Delivery Requests</h3>
                        <p>Manage preparing and delivering orders</p>
                    </div>

                    <div class="admin-card" onclick="window.location.href='AdminCheckCust.php'">
                        <img src="../upload/icon/personwhite.png" alt="user" class="card-icon">
                        <h3>User Management</h3>
                        <p>View and manage customer details</p>
                    </div>
                </div>
            </div>
        </div>
    </main>


</body>

</html>