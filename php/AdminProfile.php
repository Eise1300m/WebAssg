<?php
session_start();
require_once("connection.php");

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: UserLogin.php");
    exit();
}

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
    
    if ($file["error"] === UPLOAD_ERR_OK) {
        $fileName = $file["name"];
        $fileTmpName = $file["tmp_name"];
        $fileSize = $file["size"];
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExtensions = ["jpg", "jpeg", "png", "gif"];

        if (!in_array($fileExt, $allowedExtensions)) {
            $updateMessage = "❌ Invalid file type! Only JPG, PNG & GIF files are allowed.";
        } elseif ($fileSize > 5000000) { // 5MB max
            $updateMessage = "❌ File is too large! Maximum size is 5MB.";
        } else {
            // Set the correct upload directory for admins
            $uploadDir = "../upload/adminPfp/";
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Create unique filename using admin ID and timestamp
            $newFileName = $admin['UserID'] . "_" . time() . "." . $fileExt;
            $uploadPath = $uploadDir . $newFileName;

            // Delete old profile picture if exists
            if (!empty($admin['ProfilePic']) && 
                file_exists($admin['ProfilePic']) && 
                strpos($admin['ProfilePic'], 'adminPfp') !== false) {
                unlink($admin['ProfilePic']);
            }

            if (move_uploaded_file($fileTmpName, $uploadPath)) {
                $stmt = $_db->prepare("UPDATE users SET ProfilePic = ? WHERE UserID = ?");
                if ($stmt->execute([$uploadPath, $admin['UserID']])) {
                    $updateMessage = "✅ Profile picture updated successfully!";
                    
                    // Refresh admin data
                    $stmt = $_db->prepare("SELECT * FROM users WHERE Username = ?");
                    $stmt->execute([$username]);
                    $admin = $stmt->fetch(PDO::FETCH_ASSOC);
                } else {
                    $updateMessage = "❌ Failed to update database.";
                }
            } else {
                $updateMessage = "❌ Failed to upload file.";
            }
        }
    } else {
        $updateMessage = "❌ Upload failed: " . $file["error"];
    }
}

// Handle contact number update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_contact"])) {
    $new_phone = trim($_POST["phone"]);
    
    if (!empty($new_phone)) {
        $stmt = $_db->prepare("UPDATE users SET ContactNo = ? WHERE UserID = ?");
        if ($stmt->execute([$new_phone, $admin['UserID']])) {
            $updateMessage = "✅ Phone number updated successfully!";
            
            // Refresh admin data
            $stmt = $_db->prepare("SELECT * FROM users WHERE Username = ?");
            $stmt->execute([$username]);
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);
        }
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
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
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
                <div class="admin-profile">
                    <img src="<?php echo !empty($admin['ProfilePic']) ? htmlspecialchars($admin['ProfilePic']) : '../upload/icon/UnknownUser.jpg'; ?>" 
                         alt="Admin Profile" class="admin-avatar">
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
                        Back toDashboard
                    </a>
                </nav>
            </div>

            <div class="admin-main">
                <?php if ($updateMessage): ?>
                    <div class="admin-message"><?php echo $updateMessage; ?></div>
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
                                <input type="tel" id="phone" name="phone"
                                    value="<?php echo htmlspecialchars($admin['ContactNo']); ?>"
                                    pattern="^(\+?6?01)[0-46-9]-*[0-9]{7,8}$"
                                    placeholder="01x-xxxxxxxx"
                                    required>
                                <img src="../upload/icon/edit.png" alt="Edit" title="Click to edit" class="input-icon">
                            </div>
                            <small class="input-hint">Malaysian format: 01Xxxxxxxxx</small>
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

    <?php include 'footer.php'; ?>

</body>
</html> 