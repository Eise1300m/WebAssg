<?php
require_once("../base.php");
require_once("../../lib/ValidationHelper.php");
require_once("../../lib/FormHelper.php");

requireLogin();

$username = $_SESSION['user_name'];

// Get user details
$stmt = $_db->prepare("SELECT * FROM users WHERE Username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    handleError("User not found.", "UserLogin.php");
}

$user_id = $user['UserID'];

// Get user's address
$stmt = $_db->prepare("SELECT * FROM address WHERE UserID = ?");
$stmt->execute([$user_id]);
$address = $stmt->fetch(PDO::FETCH_ASSOC);

$updateMessage = "";
$errors = [];

includeNavbar();

displayFlashMessage();

// Update address
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_address"])) {
    $new_street = trim($_POST["street"]);
    $new_city = trim($_POST["city"]);
    $new_state = trim($_POST["state"]);
    $new_postal = trim($_POST["postal"]);

   
    $errors = [];
    
    if (empty($new_street)) {
        $errors['street'] = 'Street address is required';
    }
    
    if (empty($new_city)) {
        $errors['city'] = 'City is required';
    } elseif (!ValidationHelper::validateCity($new_city)) {
        $errors['city'] = 'City should contain only letters and be at least 2 characters';
    }
    
    if (empty($new_state)) {
        $errors['state'] = 'State is required';
    } elseif (!ValidationHelper::validateState($new_state)) {
        $errors['state'] = 'State should contain only letters';
    }
    
    // Use new postal code validation
    $postalValidation = ValidationHelper::validatePostalCode($new_postal);
    if ($postalValidation !== true) {
        $errors['postal'] = $postalValidation;
    } else {
        // If postal code is valid, get the state from it
        $stateFromPostal = ValidationHelper::getStateFromPostalCode($new_postal);
        if ($stateFromPostal && strtolower($new_state) != strtolower($stateFromPostal)) {
            $errors['postal'] = "Postal code doesn't match the selected state";
        }
    }

    if (empty($errors)) {
        if ($address) {
            $stmt = $_db->prepare("UPDATE address SET Street = ?, City = ?, State = ?, PostalCode = ? WHERE UserID = ?");
            $stmt->execute([$new_street, $new_city, $new_state, $new_postal, $user_id]);
            $updateMessage = "✅ Address updated successfully!";
        } else {
            $stmt = $_db->prepare("INSERT INTO address (UserID, Street, City, State, PostalCode) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$user_id, $new_street, $new_city, $new_state, $new_postal]);
            $updateMessage = "✅ Address added successfully!";
        }

        $stmt = $_db->prepare("SELECT * FROM address WHERE UserID = ?");
        $stmt->execute([$user_id]);
        $address = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        $updateMessage = "❌ Please correct the errors below.";
    }
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

// profile picture upload
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["profile_pic"])) {
    $file = $_FILES["profile_pic"];
    
    // Use ValidationHelper for file validation
    $validation = ValidationHelper::validateProfilePicture($file);
    
    if ($validation['success']) {
        // Use the correct path for customerPfp directory
        $uploadDir = "../../upload/customerPfp/";
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileExt = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
        $newFileName = $user['UserID'] . "_" . time() . "." . $fileExt;
        $uploadPath = $uploadDir . $newFileName;
        $dbPath = "/WebAssg/upload/customerPfp/" . $newFileName;  // Store the web-accessible path in DB

        // Remove old profile picture if it exists
        if (!empty($user['ProfilePic']) && file_exists($_SERVER['DOCUMENT_ROOT'] . $user['ProfilePic']) && strpos($user['ProfilePic'], 'customerPfp') !== false) {
            unlink($_SERVER['DOCUMENT_ROOT'] . $user['ProfilePic']);
        }

        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            // Store the web path in database
            $stmt = $_db->prepare("UPDATE users SET ProfilePic = ? WHERE UserID = ?");
            $stmt->execute([$dbPath, $user['UserID']]);
            
            if ($stmt->rowCount() > 0) {
                $updateMessage = "✅ Profile picture updated successfully!";
                
                // Redirect to same page to refresh
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            } else {
                $updateMessage = "❌ Failed to update database.";
            }
        } else {
            $updateMessage = "❌ Failed to upload file.";
        }
    } else {
        $updateMessage = "❌ " . $validation['message'];
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Profile Management - Secret Shelf</title>
    <link rel="icon" type="image/x-icon" href="../../img/Logo.png">
    <link rel="stylesheet" href="../../css/HomeStyles.css">
    <link rel="stylesheet" href="../../css/ProfileStyles.css">
    <link rel="stylesheet" href="../../css/NavbarStyles.css">
    <link rel="stylesheet" href="../../css/FooterStyles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../../js/Scripts.js"></script>
    <script src="../../js/order.js"></script>
</head>

<body>

    <a class="redirect-button" data-redirect-url="/WebAssg/php/MainPage.php">
        <img src="../../upload/icon/back.png" alt="Back" class="back-icon" style="width: 30px; height: 30px;"> Continue Shopping
    </a>

    <main class="profile-container">
        <div class="profile-header">
            <h1>Profile Management</h1>
            <p>Manage your account information</p>
        </div>

        <div class="profile-content">
            <div class="profile-sidebar">
                <?php echo FormHelper::profilePicture('profile-pic-input', 'profile-pic', $user['ProfilePic']); ?>
                
                <nav class="profile-nav">
                    <a href="#personal-info" class="active">Personal Information</a>
                    <a href="UserSecurity.php">Security</a>
                    <a href="UserOrderHistory.php">Order History</a>
                </nav>
            </div>

            <div class="profile-main">
                <?php if ($updateMessage): ?>
                    <div class="update-message <?php echo strpos($updateMessage, '✅') !== false ? 'success-message' : ''; ?>">
                        <?php echo $updateMessage; ?>
                    </div>
                <?php endif; ?>

                <form class="profile-form" method="POST" action="">
                    <div class="form-section">
                        <h2>Personal Information</h2>

                        <div class="form-group">
                            <label for="username">Username</label>
                            <div class="input-with-icon">
                                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['Username'] ?? ''); ?>" readonly>
                                <img src="../../upload/icon/lock.png" alt="Lock" title="Cannot be changed" class="input-icon">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <div class="input-with-icon">
                                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['Email'] ?? ''); ?>" readonly>
                                <img src="../../upload/icon/lock.png" alt="Lock" title="Cannot be changed" class="input-icon">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <div class="input-with-icon">
                                <?php echo FormHelper::phone('phone', $user['ContactNo']); ?>
                                <img src="../../upload/icon/edit.png" alt="Edit" title="Click to edit" class="input-icon">
                            </div>
                            <small class="input-hint">Malaysian format: 0123456789</small>
                        </div>

                        <div class="form-actions">
                            <button type="submit" name="update_contact" class="save-btn">Update Phone Number</button>
                        </div>
                    </div>
                </form>

                <form class="profile-form" method="POST" action="">
                    <div class="form-section">
                        <h2>Address Information <img src="../../upload/icon/edit.png" alt="Edit" title="Editable section" class="section-icon"></h2>

                        <?php if ($address): ?>
                            <div class="form-group">
                                <label for="street">Street Address</label>
                                <div class="input-with-icon">
                                    <?php echo FormHelper::street('street', $address['Street']); ?>
                                </div>
                                <?php if (isset($errors['street'])): ?>
                                    <span class="error-message"><?php echo $errors['street']; ?></span>
                                <?php endif; ?>
                            </div>

                            <div class="form-group">
                                <label for="city">City</label>
                                <div class="input-with-icon">
                                    <?php echo FormHelper::city('city', $address['City']); ?>
                                </div>
                                <?php if (isset($errors['city'])): ?>
                                    <span class="error-message"><?php echo $errors['city']; ?></span>
                                <?php endif; ?>
                            </div>

                            <div class="form-group">
                                <label for="state">State</label>
                                <div class="input-with-icon">
                                    <?php echo FormHelper::state('state', $address['State']); ?>
                                </div>
                                <?php if (isset($errors['state'])): ?>
                                    <span class="error-message"><?php echo $errors['state']; ?></span>
                                <?php endif; ?>
                            </div>

                            <div class="form-group">
                                <label for="postal">Postal Code</label>
                                <div class="input-with-icon">
                                    <?php echo FormHelper::postalCode('postal', $address['PostalCode']); ?>
                                </div>
                                <?php if (isset($errors['postal'])): ?>
                                    <span class="error-message"><?php echo $errors['postal']; ?></span>
                                <?php endif; ?>
                            </div>

                        <?php else: ?>
                            <p class="no-address-message">
                                <img src="../../upload/icon/info.png" alt="Info" class="info-icon" style="width: 20px; height: 20px;">
                                No address found. Please add your address below.
                            </p><br>

                            <div class="form-group">
                                <label for="street">Street Address</label>
                                <div class="input-with-icon">
                                    <?php echo FormHelper::street('street'); ?>
                                </div>
                                <?php if (isset($errors['street'])): ?>
                                    <span class="error-message"><?php echo $errors['street']; ?></span>
                                <?php endif; ?>
                            </div>

                            <div class="form-group">
                                <label for="city">City</label>
                                <div class="input-with-icon">
                                    <?php echo FormHelper::city('city'); ?>
                                </div>
                                <?php if (isset($errors['city'])): ?>
                                    <span class="error-message"><?php echo $errors['city']; ?></span>
                                <?php endif; ?>
                            </div>

                            <div class="form-group">
                                <label for="state">State</label>
                                <div class="input-with-icon">
                                    <?php echo FormHelper::state('state'); ?>
                                </div>
                                <?php if (isset($errors['state'])): ?>
                                    <span class="error-message"><?php echo $errors['state']; ?></span>
                                <?php endif; ?>
                            </div>

                            <div class="form-group">
                                <label for="postal">Postal Code</label>
                                <div class="input-with-icon">
                                    <?php echo FormHelper::postalCode('postal'); ?>
                                </div>
                                <?php if (isset($errors['postal'])): ?>
                                    <span class="error-message"><?php echo $errors['postal']; ?></span>
                                <?php endif; ?>
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