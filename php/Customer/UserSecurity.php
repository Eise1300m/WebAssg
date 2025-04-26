<?php
session_start();
require_once("../base.php");
require_once("../../lib/FormHelper.php");
require_once("../../lib/ValidationHelper.php");

requireLogin();

$username = $_SESSION['user_name'];
$updateMessage = "";
$passwordUpdateSuccess = false;
$errors = [];

// Get user details
$stmt = $_db->prepare("SELECT * FROM users WHERE Username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Handle Password Change
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["change_password"])) {
    $old_password = $_POST["old_password"] ?? '';
    $new_password = $_POST["new_password"] ?? '';
    $confirm_password = $_POST["confirm_password"] ?? '';

    // Validate inputs
    if (empty($old_password)) {
        $updateMessage = "❌ Current password is required";
    } elseif (!ValidationHelper::verifyPassword($old_password, $user["Password"])) {
        $updateMessage = "❌ Incorrect current password";
    } elseif (empty($new_password)) {
        $updateMessage = "❌ New password is required";
    } elseif (strlen($new_password) < 6) {
        $updateMessage = "❌ Password must be at least 6 characters long";
    } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).+$/', $new_password)) {
        $updateMessage = "❌ Password must include at least one lowercase letter, one uppercase letter, and one special character";
    } elseif (empty($confirm_password)) {
        $updateMessage = "❌ Please confirm your password";
    } elseif ($new_password !== $confirm_password) {
        $updateMessage = "❌ Passwords do not match";
    } else {
        // All validations passed, update the password
        $hashed_password = ValidationHelper::hashPassword($new_password);
        $stmt = $_db->prepare("UPDATE users SET Password = ? WHERE Username = ?");
        if ($stmt->execute([$hashed_password, $username])) {
            $updateMessage = "✅ Password updated successfully! Please log in again.";
            $passwordUpdateSuccess = true;
            session_regenerate_id(true); // Regenerate session ID for security
        } else {
            $updateMessage = "❌ An error occurred. Please try again.";
        }
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
    <link rel="stylesheet" href="../../css/HomeStyles.css">
    <link rel="stylesheet" href="../../css/ProfileStyles.css">
    <link rel="stylesheet" href="../../css/NavbarStyles.css">
    <link rel="stylesheet" href="../../css/FooterStyles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../../js/Scripts.js"></script>
</head>

<body>

    <a class="redirect-button" data-redirect-url="/WebAssg/php/MainPage.php">
        <img src="/WebAssg/upload/icon/back.png" alt="Back" class="back-icon" style="width: 30px; height: 30px;"> Continue Shopping
    </a>

    <main class="profile-container">
        <div class="profile-header">
            <h1>Security Settings</h1>
            <p>Manage your account security</p>
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
                    <a href="UserSecurity.php" class="active">Security</a>
                    <a href="UserOrderHistory.php">Order History</a>
                </nav>
            </div>

            <div class="profile-main">
                <?php if ($updateMessage): ?>
                    <div class="update-message"><?php echo $updateMessage; ?></div>
                <?php endif; ?>
                
                <?php if ($passwordUpdateSuccess): ?>
                    <!-- Hidden element for JS to detect and perform redirect -->
                    <div id="password-update-success" data-redirect-url="/WebAssg/php/Authentication/logout.php" style="display: none;"></div>
                <?php endif; ?>

                <form class="profile-form" method="POST" action="">
                    <div class="form-section">
                        <h2><img src="/WebAssg/upload/icon/lock.png" alt="Security" class="section-icon"> Change Password</h2>
                        
                        <div class="form-info-message" style="color: white; margin-bottom: 10px;">
                            Password must contain at least 6 characters, including an uppercase letter, 
                            a lowercase letter, and a special character.
                        </div>

                        <div class="form-group">
                            <label for="old_password">Current Password</label>
                            <div class="input-with-icon">
                                <input type="password" id="old_password" name="old_password" required>
                                <img src="/WebAssg/upload/icon/lock.png" alt="Lock" class="input-icon">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="new_password">New Password</label>
                            <div class="input-with-icon">
                                <input type="password" id="new_password" name="new_password" required>
                                <img src="/WebAssg/upload/icon/openlock.png" alt="New Lock" class="input-icon">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="confirm_password">Confirm New Password</label>
                            <div class="input-with-icon">
                                <input type="password" id="confirm_password" name="confirm_password" required>
                                <img src="/WebAssg/upload/icon/openlock.png" alt="Confirm Lock" class="input-icon">
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

</body>

</html>