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
        <i class="fa fa-user" aria-hidden="true"></i>
    </div>
    <div class="profile-dropdown-content" id="profileDropdown">
        <div class="profile-header">
            <p>Hello, <?= isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : 'Guest' ?></p>
        </div>
        <div class="profile-menu-items">
            <?php if (isset($_SESSION['user_name'])): ?>
                <a href="edit_profile.php"><i class="fa fa-user-circle" aria-hidden="true"></i> Edit Profile</a>
                <a href="order_history.php"><i class="fa fa-history" aria-hidden="true"></i> Order History</a>
                <a href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a>
            <?php else: ?>
                <a href="CustomerLogin.php"><i class="fa fa-sign-in" aria-hidden="true"></i> Login</a>
                <a href="CustomerRegister.php"><i class="fa fa-user-plus" aria-hidden="true"></i> Register</a>
            <?php endif; ?>
        </div>
    </div>
</div>