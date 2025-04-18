<?php
session_start();
require_once("base.php");

requireLogin();

$username = $_SESSION['user_name'];
$updateMessage = "";

// Get user details
$stmt = $_db->prepare("SELECT * FROM users WHERE Username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Handle Password Change
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["change_password"])) {
    $old_password = $_POST["old_password"];
    $new_password = $_POST["new_password"];
    $confirm_password = $_POST["confirm_password"];

    if (!password_verify($old_password, $user["Password"])) {
        $updateMessage = "❌ Incorrect old password!";
    } elseif ($new_password !== $confirm_password) {
        $updateMessage = "❌ New passwords do not match!";
    } else {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $_db->prepare("UPDATE users SET Password = ? WHERE Username = ?");
        $stmt->execute([$hashed_password, $username]);
        $updateMessage = "✅ Password updated successfully!";
    }
}

includeNavbar();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Security Settings - Secret Shelf</title>
    <link rel="stylesheet" href="../css/HomeStyles.css">
    <link rel="stylesheet" href="../css/ProfileStyles.css">
    <link rel="stylesheet" href="../css/NavbarStyles.css">
    <link rel="stylesheet" href="../css/FooterStyles.css">
    <link rel="icon" type="image/x-icon" href="../img/Logo.png">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/Scripts.js"></script>
</head>

<body>

    <a class="redirect-button" data-redirect-url="MainPage.php">
        <img src="../upload/icon/back.png" alt="Back" class="back-icon" style="width: 30px; height: 30px;"> Continue Shopping
    </a>

    <main class="profile-container">
        <div class="profile-header">
            <h1>Security Settings</h1>
            <p>Manage your account security</p>
        </div>

        <div class="profile-content">
            <div class="profile-sidebar">
                <div class="profile-avatar">
                    <img src="<?php echo !empty($user['ProfilePic']) ? htmlspecialchars($user['ProfilePic']) : '../upload/icon/UnknownUser.jpg'; ?>" alt="Profile Picture">
                </div>
                <nav class="profile-nav">
                    <a href="UserEditProfile.php">Personal Information</a>
                    <a href="UserSecurity.php" class="active">Security</a>
                    <a href="UserOrderHistory.php">Order History</a>
                </nav>
            </div>

            <div class="profile-main">
                <?php if ($updateMessage): ?>
                    <div class="update-message"><?php echo $updateMessage; ?></div>
                <?php endif; ?>

                <form class="profile-form" method="POST" action="">
                    <div class="form-section">
                        <h2><img src="../upload/icon/lock.png" alt="Security" class="section-icon"> Change Password</h2>

                        <div class="form-group">
                            <label for="old_password">Current Password</label>
                            <div class="input-with-icon">
                                <input type="password" id="old_password" name="old_password" required>
                                <img src="../upload/icon/lock.png" alt="Lock" class="input-icon">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="new_password">New Password</label>
                            <div class="input-with-icon">
                                <input type="password" id="new_password" name="new_password" required>
                                <img src="../upload/icon/openlock.png" alt="New Lock" class="input-icon">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="confirm_password">Confirm New Password</label>
                            <div class="input-with-icon">
                                <input type="password" id="confirm_password" name="confirm_password" required>
                                <img src="../upload/icon/openlock.png" alt="Confirm Lock" class="input-icon">
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" name="change_password" class="save-btn">Update Password</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>

</html>