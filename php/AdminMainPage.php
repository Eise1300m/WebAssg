<?php
require_once("base.php");

requireAdmin();

$username = $_SESSION['user_name'];

// Get admin info
$stmt = $_db->prepare("SELECT * FROM users WHERE Username = :username AND Role = 'admin'");
$stmt->execute(['username' => $username]);
$admin = $stmt->fetch(PDO::FETCH_ASSOC);

// Debugging output
if (!$admin) {
    handleError("Only authorized users can access this page.");
}

// Check if Username key exists
if (!isset($admin['Username'])) {
    handleError("Username key is missing in the admin data.");
}

// Output header with custom title
// Include navbar
includeAdminNav();
// Display any flash messages
displayFlashMessage();
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
                    <div class="admin-card redirect-button" data-redirect-url="AdminProductManagement.php">
                        <img src="../upload/icon/product.png" alt="Product Management" class="card-icon">
                        <h3>Product Management</h3>
                        <p>Add, edit, or remove books from inventory</p>
                    </div>

                    <div class="admin-card redirect-button" data-redirect-url="AdminOrders.php">
                        <img src="../upload/icon/shoppingbag.png" alt="Order Management" class="card-icon">
                        <h3>Order Listing</h3>
                        <p>View Orders details and Status</p>
                    </div>

                    <div class="admin-card redirect-button" data-redirect-url="AdminSignUp.php">
                        <img src="../upload/icon/profile.png" alt="Admin Management" class="card-icon">
                        <h3>Admin Registration</h3>
                        <p>Admin registeration page </p>
                    </div>

                    <div class="admin-card redirect-button" data-redirect-url="AdminDeliveryRequests.php">
                        <img src="../upload/icon/delivery.png" alt="Delivery Requests" class="card-icon">
                        <h3>Delivery Requests</h3>
                        <p>Manage preparing and delivering orders</p>
                    </div>

                    <div class="admin-card redirect-button" data-redirect-url="AdminCheckCust.php">
                        <img src="../upload/icon/customer.png" alt="Customer Management" class="card-icon">
                        <h3>Customer Management</h3>
                        <p>View customers</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
    

</body>

</html>