<?php
session_start();
require_once("connection.php");

if (!isset($_SESSION['user_name'])) {
    header("Location: UserLogin.php");
    exit;
}

$username = $_SESSION['user_name'];

// Fetch user data from the database
$stmt = $_db->prepare("SELECT * FROM users WHERE Username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("User not found.");
}

$user_id = $user['UserID'];

// Fetch address data
$stmt = $_db->prepare("SELECT * FROM address WHERE UserID = ?");
$stmt->execute([$user_id]);
$address = $stmt->fetch(PDO::FETCH_ASSOC);

$updateMessage = "";

// Update address
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_address"])) {
    $new_street = trim($_POST["street"]);
    $new_city = trim($_POST["city"]);
    $new_state = trim($_POST["state"]);
    $new_postal = trim($_POST["postal"]);
    $new_country = trim($_POST["country"]);

    if (!empty($new_street) && !empty($new_city) && !empty($new_state) && !empty($new_postal) && !empty($new_country)) {
        if ($address) {
            $stmt = $_db->prepare("UPDATE address SET Street = ?, City = ?, State = ?, PostalCode = ?, Country = ? WHERE UserID = ?");
            $stmt->execute([$new_street, $new_city, $new_state, $new_postal, $new_country, $user_id]);
            $updateMessage = "✅ Address updated successfully!";
        } else {
            $stmt = $_db->prepare("INSERT INTO address (UserID, Street, City, State, PostalCode, Country) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$user_id, $new_street, $new_city, $new_state, $new_postal, $new_country]);
            $updateMessage = "✅ Address added successfully!";
        }
    } else {
        $updateMessage = "❌ All address fields are required!";
    }

    $stmt = $_db->prepare("SELECT * FROM address WHERE UserID = ?");
    $stmt->execute([$user_id]);
    $address = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Update contact number
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_contact"])) {
    $new_phone = trim($_POST["phone"]);

    if (!empty($new_phone)) {
        $stmt = $_db->prepare("UPDATE users SET ContactNo = ? WHERE UserID = ?");
        $stmt->execute([$new_phone, $user_id]);
        $updateMessage = "✅ Phone number updated successfully!";
        
        $stmt = $_db->prepare("SELECT * FROM users WHERE Username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        $updateMessage = "❌ Phone number is required!";
    }
}

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
        } elseif ($fileSize > 5000000) {
            $updateMessage = "❌ File is too large! Maximum size is 5MB.";
        } else {
            $uploadDir = "../upload/customerPfp/";
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $newFileName = $user['UserID'] . "_" . time() . "." . $fileExt;
            $uploadPath = $uploadDir . $newFileName;

            if (!empty($user['ProfilePic']) && file_exists($user['ProfilePic']) && strpos($user['ProfilePic'], 'customerPfp') !== false) {
                unlink($user['ProfilePic']);
            }

            if (move_uploaded_file($fileTmpName, $uploadPath)) {
                $stmt = $_db->prepare("UPDATE users SET ProfilePic = ? WHERE UserID = ?");
                if ($stmt->execute([$uploadPath, $user['UserID']])) {
                    $updateMessage = "✅ Profile picture updated successfully!";
                    
                    $stmt = $_db->prepare("SELECT * FROM users WHERE Username = ?");
                    $stmt->execute([$username]);
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);
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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Management - Secret Shelf</title>
    <link rel="stylesheet" href="../css/HomeStyles.css">
    <link rel="stylesheet" href="../css/ProfileStyles.css">
    <link rel="stylesheet" href="../css/NavbarStyles.css">
    <link rel="stylesheet" href="../css/FooterStyles.css">
    <link rel="icon" type="image/x-icon" href="../img/Logo.png">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/Scripts.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <?php include_once("navbar.php") ?>

    <main class="profile-container">
        <div class="profile-header">
            <h1>Profile Management</h1>
            <p>Manage your account information</p>
        </div>

        <div class="profile-content">
            <div class="profile-sidebar">
                <div class="profile-avatar">
                    <img src="<?php echo htmlspecialchars($user['ProfilePic']); ?>" alt="Profile Picture" id="profile-pic">
                    <form method="POST" action="" enctype="multipart/form-data" id="profile-pic-form">
                        <input type="file" name="profile_pic" id="profile-pic-input" style="display: none;" accept="image/jpeg,image/png,image/gif">
                        <div class="avatar-buttons">
                            <button type="button" class="change-avatar-btn" onclick="document.getElementById('profile-pic-input').click()">Select Picture</button>
                            <button type="submit" class="upload-avatar-btn" id="upload-pic-btn" style="display: none;">Upload Picture</button>
                        </div>
                    </form>
                </div>
                <nav class="profile-nav">
                    <a href="#personal-info" class="active">Personal Information</a>
                    <a href="UserSecurity.php">Security</a>
                    <a href="UserOrderHistory.php">Order History</a>
                </nav>
            </div>

            <div class="profile-main">
                <?php if ($updateMessage): ?>
                    <div class="update-message"><?php echo $updateMessage; ?></div>
                <?php endif; ?>

                <form class="profile-form" method="POST" action="">
                    <div class="form-section">
                        <h2>Personal Information</h2>

                        <div class="form-group">
                            <label for="username">Username</label>
                            <div class="input-with-icon">
                                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['Username'] ?? ''); ?>" readonly>
                                <img src="../upload/icon/lock.png" alt="Lock" title="Cannot be changed" class="input-icon">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <div class="input-with-icon">
                                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['Email'] ?? ''); ?>" readonly>
                                <img src="../upload/icon/lock.png" alt="Lock" title="Cannot be changed" class="input-icon">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <div class="input-with-icon">
                                <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($user['ContactNo'] ?? ''); ?>" pattern="^(\+?6?01)[0-46-9]-*[0-9]{7,8}$" placeholder="01x-xxxxxxxx" required>
                                <img src="../upload/icon/edit.png" alt="Edit" title="Click to edit" class="input-icon">
                            </div>
                            <small class="input-hint">Malaysian format: 01x-xxxxxxxx</small>
                        </div>

                        <div class="form-actions">
                            <button type="submit" name="update_contact" class="save-btn">Update Phone Number</button>
                        </div>
                    </div>

                    <div class="form-section">
                        <h2>Address Information <img src="../upload/icon/edit.png" alt="Edit" title="Editable section" class="section-icon"></h2>

                        <?php if ($address): ?>
                            <div class="form-group">
                                <label for="street">Street Address</label>
                                <div class="input-with-icon">
                                    <input type="text" id="street" name="street" value="<?php echo htmlspecialchars($address['Street']); ?>" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="city">City</label>
                                <div class="input-with-icon">
                                    <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($address['City']); ?>" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="state">State</label>
                                <div class="input-with-icon">
                                    <input type="text" id="state" name="state" value="<?php echo htmlspecialchars($address['State']); ?>" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="postal">Postal Code</label>
                                <div class="input-with-icon">
                                    <input type="text" id="postal" name="postal" value="<?php echo htmlspecialchars($address['PostalCode']); ?>" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="country">Country</label>
                                <div class="input-with-icon">
                                    <input type="text" id="country" name="country" value="<?php echo htmlspecialchars($address['Country']); ?>" required>
                                </div>
                            </div>

                        <?php else: ?>
                            <p class="no-address-message">
                                <i class="fas fa-info-circle"></i>
                                No address found. Please add your address below.
                            </p><br>

                            <div class="form-group">
                                <label for="street">Street Address</label>
                                <div class="input-with-icon">
                                    <input type="text" id="street" name="street" placeholder="Enter your street" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="city">City</label>
                                <div class="input-with-icon">
                                    <input type="text" id="city" name="city" placeholder="Enter your city" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="state">State</label>
                                <div class="input-with-icon">
                                    <input type="text" id="state" name="state" placeholder="Enter your state" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="postal">Postal Code</label>
                                <div class="input-with-icon">
                                    <input type="text" id="postal" name="postal" placeholder="Enter postal code" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="country">Country</label>
                                <div class="input-with-icon">
                                    <input type="text" id="country" name="country" placeholder="Enter your country" required>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="form-actions">
                            <button type="submit" name="update_address" class="save-btn">
                                <?php echo $address ? "Update Address" : "Add Address"; ?>
                            </button>
                            <button type="reset" class="cancel-btn">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>

</html>