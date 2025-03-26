<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@100..900&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/Scripts.js"></script>
    <link rel="icon" type="image/x-icon" href="../img/Logo.png">
    <link rel="stylesheet" href="../css/AdminprofileMenuStyle.css">
</head>

<?php
// Always use default profile picture
$profile_pic = '../upload/icon/UnknownUser.jpg';
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
                <a href="AdminProfile.php"><img src="../upload/icon/personblack.png" alt="Profile" class="nav-icon"> Edit Profile</a>
                <a href="AdminMainPage.php"><img src="../upload/icon/dashboardblack.png" alt="Dashboard" class="nav-icon"> Dashboard</a>
                <a href="logout.php"><img src="../upload/icon/logoutblack.png" alt="Logout" class="nav-icon"> Logout</a>
            <?php else: ?>
                <a href="UserLogin.php"><i class="fa fa-sign-in" aria-hidden="true"></i> Login</a>
                <a href="UserRegister.php"><i class="fa fa-user-plus" aria-hidden="true"></i> Register</a>
            <?php endif; ?>
        </div>
    </div>
</div>