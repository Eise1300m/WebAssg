<?php
session_start();
require_once("../lib/FormHelper.php");
require_once("../lib/SecurityHelper.php");

if (isset($_SESSION['signup_errors'])) {
    echo '<div class="error-box">';
    foreach ($_SESSION['signup_errors'] as $error) {
        echo "<p class='error-message'>$error</p>";
    }
    echo '</div>';
    unset($_SESSION['signup_errors']); // Clear errors after displaying
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration - Secret Shelf</title>
    <link rel="stylesheet" href="../css/CustomerSignUpStyles.css">
    <link rel="stylesheet" href="../css/NavbarStyles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="../img/Logo.png">
    <script src="../js/Scripts.js"></script>

</head>

<body>

    <?php include 'navbaradmin.php'; ?>

    <!-- Back button to AdminMainPage.php -->
    <a class="back-button" onclick="window.history.back()">
        <img src="../upload/icon/back.png" alt="Back" class="back-icon"> Back to Dashboard
    </a>

    <div class="container">
        <h1>Admin Sign Up</h1>

        <form id="signupForm" method="post" action="UserSignUpProcess.php">
            <?php echo FormHelper::hidden('role', 'admin'); ?>

            <div class="input-container">
                <img src="../upload/icon/personwhite.png" alt="Person" class="input-icon">
                <?php echo FormHelper::text('UName', 'placeholder="Enter Username"'); ?>
                <span class="error-message" id="nameError"><?php echo FormHelper::error('UName'); ?></span>
            </div>

            <div class="input-container">
                <img src="../upload/icon/lock.png" alt="Lock" class="input-icon">
                <?php echo FormHelper::password('psw', 'placeholder="Enter password"'); ?>
                <span class="error-message" id="pswError"><?php echo FormHelper::error('psw'); ?></span>
            </div>

            <div class="input-container">
                <img src="../upload/icon/lock.png" alt="Lock" class="input-icon">
                <?php echo FormHelper::password('pswcfm', 'placeholder="Confirm your password"'); ?>
                <span class="error-message" id="pswcfmError"><?php echo FormHelper::error('pswcfm'); ?></span>
            </div>

            <div class="input-container">
                <img src="../upload/icon/info.png" alt="Info" class="input-icon">
                <?php echo FormHelper::email('emails', 'placeholder="Email - Exp: Secret@example.com"'); ?>
                <span class="error-message" id="emailError"><?php echo FormHelper::error('emails'); ?></span>
            </div>

            <div class="input-container">
                <img src="../upload/icon/phone.png" alt="Phone" class="input-icon">
                <?php echo FormHelper::text('tel', 'placeholder="Phone number - Exp: 01XXXXXXXX"'); ?>
                <span class="error-message" id="telError"><?php echo FormHelper::error('tel'); ?></span>
            </div>

            <?php echo FormHelper::submit('Submit', 'class="submit-but"'); ?>
        </form>

        <div class="signup-container">
            <p>Already have an admin account?</p>
            <a href="AdminLogin.php">Login</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/Scripts.js"></script>
</body>


</html>