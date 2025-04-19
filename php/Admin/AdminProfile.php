<?php
require_once("base.php");

// Check if user is admin
requireAdmin();

require_once("connection.php");
require_once("../lib/FormHelper.php");
require_once("../lib/ValidationHelper.php");

$username = $_SESSION['user_name'];

$stmt = $_db->prepare("SELECT * FROM users WHERE Username = ? AND Role = 'admin'");
$stmt->execute([$username]);
$admin = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$admin) {
    die("Admin not found.");
}

$updateMessage = "";

// Handle profile picture upload
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["profile_pic"])) {
    
    $file = $_FILES["profile_pic"];   
    
    // Use ValidationHelper for file validation
    $validation = ValidationHelper::validateProfilePicture($file);
    
    if ($validation['success']) {
        $uploadDir = "../upload/adminPfp/";
        
        // Ensure upload directory exists with proper permissions
        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0777, true)) {
                $updateMessage = "❌ Failed to create upload directory. Please contact support.";
            }
        }
        
        // Check if directory exists and is writable
        if (!is_dir($uploadDir) || !is_writable($uploadDir)) {
            $updateMessage = "❌ Upload directory is not writable. Please check permissions.";
        } else {
            // Remove old profile picture if it exists
            if (!empty($admin['ProfilePic']) && file_exists($admin['ProfilePic']) && strpos($admin['ProfilePic'], 'adminPfp') !== false) {
                @unlink($admin['ProfilePic']);
            }

            // Use ValidationHelper to handle the file upload
            $upload = ValidationHelper::handleFileUpload($file, $uploadDir, $admin['UserID'] . "_");
            
            if ($upload['success']) {
                $stmt = $_db->prepare("UPDATE users SET ProfilePic = ? WHERE UserID = ?");
                $stmt->execute([$upload['path'], $admin['UserID']]);
                
                if ($stmt->rowCount() > 0) {
                    $updateMessage = "✅ Profile picture updated successfully!";
                    
                    // Refresh admin data
                    $stmt = $_db->prepare("SELECT * FROM users WHERE Username = ?");
                    $stmt->execute([$username]);
                    $admin = $stmt->fetch(PDO::FETCH_ASSOC);
                } else {
                    $updateMessage = "❌ Failed to update database.";
                }
            } else {
                $updateMessage = "❌ " . $upload['message'];
            }
        }
    } else {
        $updateMessage = "❌ " . $validation['message'];
    }
}

// Handle contact number update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_contact"])) {
    $new_phone = trim($_POST["phone"]);
    
    if (!empty($new_phone)) {
        // Validate phone number using ValidationHelper
        if (ValidationHelper::validatePhone($new_phone)) {
            $stmt = $_db->prepare("UPDATE users SET ContactNo = ? WHERE UserID = ?");
            if ($stmt->execute([$new_phone, $admin['UserID']])) {
                $updateMessage = "✅ Phone number updated successfully!";
                
                // Refresh admin data
                $stmt = $_db->prepare("SELECT * FROM users WHERE Username = ?");
                $stmt->execute([$username]);
                $admin = $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                $updateMessage = "❌ Failed to update phone number.";
            }
        } else {
            $updateMessage = "❌ Invalid phone number format. Please use Malaysian format (01xxxxxxxxx).";
        }
    } else {
        $updateMessage = "❌ Phone number is required!";
    }
}

// Handle password update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["change_password"])) {
    $old_password = $_POST["old_password"];
    $new_password = $_POST["new_password"];
    $confirm_password = $_POST["confirm_password"];

    if (!password_verify($old_password, $admin["Password"])) {
        $updateMessage = "❌ Incorrect current password!";
    } elseif ($new_password !== $confirm_password) {
        $updateMessage = "❌ New passwords do not match!";
    } else {
        $hashed_password = ValidationHelper::hashPassword($new_password);
        $stmt = $_db->prepare("UPDATE users SET Password = ? WHERE UserID = ?");
        if ($stmt->execute([$hashed_password, $admin['UserID']])) {
            $updateMessage = "✅ Password updated successfully!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile - Secret Shelf</title>
    <link rel="stylesheet" href="../css/HomeStyles.css">
    <link rel="stylesheet" href="../css/AdminStyles.css">
    <link rel="stylesheet" href="../css/NavbarStyles.css">
    <link rel="stylesheet" href="../css/FooterStyles.css">
    <link rel="icon" type="image/x-icon" href="../img/Logo.png">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/AdminScripts.js"></script>
</head>
<body>
    <?php include_once("navbaradmin.php") ?>

    <main class="admin-container">
        <div class="admin-header">
            <h1>Admin Profile</h1>
            <p>Manage your account information</p>
        </div>

        <div class="admin-content">
            <div class="admin-sidebar">
                <div class="admin-profile" style="text-align: center;">
                    <img src="<?php echo !empty($admin['ProfilePic']) ? htmlspecialchars($admin['ProfilePic']) : '../upload/icon/UnknownUser.jpg'; ?>"
                        alt="Admin Profile" class="admin-avatar" id="profile-pic" style="display: block; margin: 0 auto;">
                    <h3><?php echo htmlspecialchars($admin['Username']); ?></h3>
                    <p>Administrator</p>
                    
                    <form method="POST" action="" enctype="multipart/form-data" id="profile-pic-form">
                        <input type="file" name="profile_pic" id="profile-pic-input" 
                               style="display: none;" 
                               accept="image/jpeg,image/png,image/gif">
                        <div class="avatar-buttons">
                            <button type="button" class="admin-btn" onclick="document.getElementById('profile-pic-input').click()">
                                Change Picture
                            </button>
                            <button type="submit" class="admin-btn" id="upload-pic-btn" style="display: none;">
                                Upload
                            </button>
                        </div>
                    </form>
                </div>
                <nav class="admin-nav">
                    <a href="AdminProfile.php" class="admin-nav-item active">
                        <img src="../upload/icon/profile.png" alt="Profile" class="nav-icon">
                        Admin Profile
                    </a>
                    <a href="AdminUpdatePassword.php" class="admin-nav-item">
                        <img src="../upload/icon/lock.png" alt="Security" class="nav-icon">
                        Admin Security
                    </a>
                    <a href="AdminMainPage.php" class="admin-nav-item">
                        <img src="../upload/icon/dashboard.png" alt="Dashboard" class="nav-icon">
                        Back to Dashboard
                    </a>
                </nav>
            </div>

            <div class="admin-main">
                <?php if ($updateMessage): ?>
                    <div class="admin-message <?php echo strpos($updateMessage, '✅') !== false ? 'success-message' : 'error-message'; ?>">
                        <?php echo $updateMessage; ?>
                    </div>
                <?php endif; ?>

                <div class="admin-form-section">
                    <h2 class="section-title">
                        <img src="../upload/icon/profile.png" alt="Profile" class="section-icon">
                        Personal Information
                    </h2>

                    <form class="admin-form" method="POST" action="">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <div class="input-with-icon">
                                <input type="text" id="username" name="username"
                                    value="<?php echo htmlspecialchars($admin['Username']); ?>" readonly>
                                <img src="../upload/icon/lock.png" alt="Lock" title="Cannot be changed" class="input-icon">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <div class="input-with-icon">
                                <input type="email" id="email" name="email"
                                    value="<?php echo htmlspecialchars($admin['Email']); ?>" readonly>
                                <img src="../upload/icon/lock.png" alt="Lock" title="Cannot be changed" class="input-icon">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <div class="input-with-icon">
                                <?php echo FormHelper::phone('phone', $admin['ContactNo'] ?? ''); ?>
                                <img src="../upload/icon/edit.png" alt="Edit" title="Click to edit" class="input-icon">
                            </div>
                            <small class="input-hint">Malaysian format: 01Xxxxxxxxx</small>
                            <span class="error-message" id="phoneError"><?php echo FormHelper::error('phone'); ?></span>
                        </div>

                        <div class="admin-form-actions">
                            <button type="reset" class="admin-btn secondary">Cancel</button>
                            <button type="submit" name="update_contact" class="admin-btn primary">Update Phone Number</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <!-- No inline scripts - functionality moved to AdminScripts.js -->
</body>
</html> 