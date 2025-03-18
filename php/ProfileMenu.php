<?php
// Ensure we have session data
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Get user data for profile picture if logged in
$userProfilePic = '../upload/icon/UnknownUser.jpg'; // Default image
$isAdmin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';

if (isset($_SESSION['user_name'])) {
    // Get profile picture from database
    require_once("connection.php");
    $username = $_SESSION['user_name'];
    
    $stmt = $_db->prepare("SELECT ProfilePic FROM users WHERE Username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user && !empty($user['ProfilePic'])) {
        $userProfilePic = $user['ProfilePic'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@100..900&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/Scripts.js"></script>
    <link rel="icon" type="image/x-icon" href="../img/Logo.png">
    <link rel="stylesheet" href="../css/NavbarStyles.css">


</head>



<!-- Profile dropdown menu -->
<div class="profile-dropdown">
    <div class="profile-icon" id="profileIcon">
        <?php if ($userProfilePic != '../upload/icon/UnknownUser.jpg'): ?>
            <img src="<?php echo htmlspecialchars($userProfilePic); ?>" alt="Profile" class="user-profile-pic">
        <?php else: ?>
            <i class="fa fa-user" aria-hidden="true"></i>
        <?php endif; ?>
    </div>
    <div class="profile-dropdown-content" id="profileDropdown">
        <div class="profile-header">
            <p>Hello, <?= isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : 'Guest' ?></p>
        </div>
        <div class="profile-menu-items">
            <?php if (isset($_SESSION['user_name'])): ?>
                <?php if ($isAdmin): // Admin menu items ?>
                    <a href="AdminProfile.php"><i class="fa fa-user-circle" aria-hidden="true"></i> Admin Profile</a>
                    <a href="AdminMainPage.php"><i class="fa fa-dashboard" aria-hidden="true"></i> Dashboard</a>
                <?php else: // Customer menu items ?>
                    <a href="UserEditProfile.php"><i class="fa fa-user-circle" aria-hidden="true"></i> Edit Profile</a>
                    <a href="UserOrderHistory.php"><i class="fa fa-history" aria-hidden="true"></i> Order History</a>
                <?php endif; ?>
                <a href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a>
            <?php else: ?>
                <a href="UserLogin.php"><i class="fa fa-sign-in" aria-hidden="true"></i> Login</a>
                <a href="UserRegister.php"><i class="fa fa-user-plus" aria-hidden="true"></i> Register</a>
            <?php endif; ?>
        </div>
    </div>
</div>
