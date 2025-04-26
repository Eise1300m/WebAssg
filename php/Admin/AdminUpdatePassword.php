<?php
session_start();
require_once("../base.php");
require_once("../../lib/FormHelper.php");
require_once("../../lib/ValidationHelper.php");

requireAdmin(); 

$username = $_SESSION['user_name'];
$updateMessage = "";
$passwordUpdateSuccess = false;

// Get Admin Info
$stmt = $_db->prepare("SELECT * FROM users WHERE Username = ? AND Role = 'admin'");
$stmt->execute([$username]);
$admin = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$admin) {
    die("Admin not found.");
}

// Handle Password Change
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["change_password"])) {
    $old_password = $_POST["old_password"] ?? '';
    $new_password = $_POST["new_password"] ?? '';
    $confirm_password = $_POST["confirm_password"] ?? '';

    // Validate inputs
    if (empty($old_password)) {
        $updateMessage = "❌ Current password is required";
    } elseif (!ValidationHelper::verifyPassword($old_password, $admin["Password"])) {
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
       
        $hashed_password = ValidationHelper::hashPassword($new_password);
        $stmt = $_db->prepare("UPDATE users SET Password = ? WHERE Username = ? AND Role = 'admin'");
        if ($stmt->execute([$hashed_password, $username])) {
            $updateMessage = "✅ Password updated successfully! Please log in again.";
            $passwordUpdateSuccess = true;
            session_regenerate_id(true); // Regenerate session ID for security
        } else {
            $updateMessage = "❌ An error occurred. Please try again.";
        }
    }
}

includeAdminNav();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Security - Secret Shelf</title>
    <link rel="stylesheet" href="/WebAssg/css/HomeStyles.css">
    <link rel="stylesheet" href="/WebAssg/css/AdminStyles.css">
    <link rel="stylesheet" href="/WebAssg/css/NavbarStyles.css">
    <link rel="stylesheet" href="/WebAssg/css/FooterStyles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/WebAssg/js/Scripts.js"></script>
</head>
<body>

    <main class="admin-container">
        <div class="admin-header">
            <h1>Admin Security</h1>
            <p>Manage your account security</p>
        </div>

        <div class="admin-content">
            <div class="admin-sidebar">
            <div class="admin-profile" style="text-align: center;">
                    <img src="<?php echo !empty($admin['ProfilePic']) ? htmlspecialchars($admin['ProfilePic']) : '/WebAssg/upload/icon/UnknownUser.jpg'; ?>"
                        alt="Admin Profile" class="admin-avatar">
                    <h3><?php echo htmlspecialchars($admin['Username']); ?></h3>
                    <p>Administrator</p>
                </div>
                <nav class="admin-nav">
                    <a href="AdminProfile.php" class="admin-nav-item">
                        <img src="/WebAssg/upload/icon/profile.png" alt="Profile" class="nav-icon">
                        Admin Profile
                    </a>
                    <a href="AdminUpdatePassword.php" class="admin-nav-item active">
                        <img src="/WebAssg/upload/icon/lock.png" alt="Security" class="nav-icon">
                        Admin Security
                    </a>
                    <a href="AdminMainPage.php" class="admin-nav-item">
                        <img src="/WebAssg/upload/icon/dashboard.png" alt="Dashboard" class="nav-icon">
                        Back to Dashboard
                    </a>
                </nav>
            </div>

            <div class="admin-main">
                <?php if ($updateMessage): ?>
                    <div class="admin-message"><?php echo $updateMessage; ?></div>
                <?php endif; ?>
                
                <?php if ($passwordUpdateSuccess): ?>
                    <!-- Hidden element for JS to detect and perform redirect -->
                    <div id="password-update-success" data-redirect-url="/WebAssg/php/Authentication/logout.php" style="display: none;"></div>
                <?php endif; ?>

                <div class="admin-form-section">
                    <h2 class="section-title">
                        <img src="/WebAssg/upload/icon/lock.png" alt="Security" class="section-icon">
                        Change Password
                    </h2>
                    
                    <div class="form-info-message" style="color: white; margin-bottom: 10px;">
                        Password must contain at least 6 characters, including an uppercase letter, 
                        a lowercase letter, and a special character.
                    </div>

                    <form class="admin-form" method="POST" action="">
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

                        <div class="admin-form-actions">
                            <button type="reset" class="admin-btn secondary">Cancel</button>
                            <button type="submit" name="change_password" class="admin-btn primary">Update Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/WebAssg/js/Scripts.js"></script>
</body>
</html>