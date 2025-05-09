<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/WebAssg/js/Scripts.js"></script>
    <link rel="stylesheet" href="/WebAssg/css/AdminprofileMenuStyle.css">
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
                <a href="/WebAssg/php/Admin/AdminProfile.php"><img src="/WebAssg/upload/icon/personblack.png" alt="Profile" class="nav-icon"> Edit Profile</a>
                <a href="/WebAssg/php/Admin/AdminMainPage.php"><img src="/WebAssg/upload/icon/dashboardblack.png" alt="Dashboard" class="nav-icon"> Dashboard</a>
                <a href="/WebAssg/php/Authentication/logout.php"><img src="/WebAssg/upload/icon/logoutblack.png" alt="Logout" class="nav-icon"> Logout</a>
            <?php else: ?>
                <a href="/WebAssg/php/Authentication/UserLogin.php"><img src="/WebAssg/upload/icon/loginblack.png" alt="Login" class="nav-icon"> Login</a>
                <a href="/WebAssg/php/Authentication/UserSignUp.php"><img src="/WebAssg/upload/icon/registerblack.png" alt="Register" class="nav-icon"> Register</a>
            <?php endif; ?>
        </div>
    </div>
</div>