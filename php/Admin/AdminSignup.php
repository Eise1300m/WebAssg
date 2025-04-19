<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once("base.php");
require_once("../lib/FormHelper.php");
require_once("../lib/ValidationHelper.php");

isAdmin();

$roleValue = "admin"; // Always set role to admin for this page

includeAdminNav();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $_title ?? 'Secret Shelf / Admin SignUp' ?></title>
    <link rel="icon" type="image/x-icon" href="../img/Logo.png">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../css/NavbarStyles.css">
    <link rel="stylesheet" href="../css/SignUpStyles.css">
    <script src="../js/Scripts.js"></script>
</head>


<body>
    <?php displayFlashMessage(); ?>

    <a class="back-button" href="AdminMainPage.php">
        <img src="../upload/icon/back.png" alt="Back" class="back-icon"> Back 
    </a>

    <div class="container">
        <h1>Admin Sign Up</h1>

        <form id="signupForm" method="post" action="UserSignUpProcess.php" novalidate>
            <?php echo FormHelper::hidden('role', $roleValue); ?>

            <div class="input-container">
                <img src="../upload/icon/personwhite.png" alt="Person" class="input-icon">
                <?php 
                echo FormHelper::text('UName', 'placeholder="Enter Username" required');
                echo FormHelper::error('UName', $errors ?? []);
                ?>
            </div>

            <div class="input-container">
                <img src="../upload/icon/lock.png" alt="Lock" class="input-icon">
                <?php 
                echo FormHelper::password('psw', 'placeholder="Enter password" required');
                echo FormHelper::error('psw', $errors ?? []);
                ?>
            </div>

            <div class="input-container">
                <img src="../upload/icon/lock.png" alt="Lock" class="input-icon">
                <?php 
                echo FormHelper::password('pswcfm', 'placeholder="Confirm your password" required');
                echo FormHelper::error('pswcfm', $errors ?? []);
                ?>
            </div>

            <div class="input-container">
                <img src="../upload/icon/info.png" alt="Info" class="input-icon">
                <?php 
                echo FormHelper::email('emails', 'placeholder="Email - Exp: Secret@example.com" required');
                echo FormHelper::error('emails', $errors ?? []);
                ?>
            </div>

            <div class="input-container">
                <img src="../upload/icon/phone.png" alt="Phone" class="input-icon">
                <?php 
                echo FormHelper::phone('tel', '', 'placeholder="Phone number - Exp: 01XXXXXXXX" required');
                echo FormHelper::error('tel', $errors ?? []);
                ?>
            </div>

            <button type="submit" class="submit-but">Submit</button>
        </form>

        <div class="signup-container">
            <p>Already have an admin account?</p>
            <a href="AdminLogin.php">Login</a>
        </div>
    </div>
</body>
</html>