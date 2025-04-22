<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="/WebAssg/css/NavbarStyles.css">
</head>

<?php
require_once("base.php");

$profile_pic = getUserProfilePic();
?>

<!-- Profile dropdown menu -->
<div class="profile-dropdown">
    <div class="profile-icon" id="profileIcon">
    <img src="<?= htmlspecialchars($profile_pic) ?>" alt="Profile" class="user-profile-pic">
    </div>
    <div class="profile-dropdown-content" id="profileDropdown">
        <div class="profile-header">
            <p>Hello, <?= isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : 'Guest' ?></p>
        </div>
        <div class="profile-menu-items">
            <?php if (isset($_SESSION['user_name'])): ?>
                <a href="/WebAssg/php/Customer/UserEditProfile.php"><img src="/WebAssg/upload/icon/edit.png" alt="Edit Profile" style="width: 20px; height: 20px; filter: invert(1);"> Edit Profile</a>
                <a href="/WebAssg/php/Customer/UserOrderHistory.php"><img src="/WebAssg/upload/icon/history.png" alt="Order History" style="width: 20px; height: 20px; filter: invert(1);"> Order History</a>
                <a href="/WebAssg/php/Authentication/logout.php"><img src="/WebAssg/upload/icon/logout.png" alt="Logout" style="width: 20px; height: 20px; filter: invert(1);"> Logout</a>
            <?php else: ?>
                <a href="../Authentication/UserLogin.php"><i class="fa fa-sign-in" aria-hidden="true"></i> Login</a>
                <a href="../Authentication/UserSignUp.php"><i class="fa fa-user-plus" aria-hidden="true"></i> Register</a>
            <?php endif; ?>
        </div>
    </div>
</div>
