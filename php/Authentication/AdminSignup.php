<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once("../base.php");
require_once("../../lib/FormHelper.php");
require_once("../../lib/ValidationHelper.php");

displayFlashMessage();
// Ensure this page is only accessible to admins
requireAdmin();

// Always set role to admin for this page 
$roleValue = "admin";


includeAdminNav();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $_title ?? 'Secret Shelf / Admin Registration' ?></title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="/WebAssg/css/NavbarStyles.css">
    <link rel="stylesheet" href="/WebAssg/css/SignUpStyles.css">
    <script src="/WebAssg/js/Scripts.js"></script>
</head>


<body>

    <a class="back-button" href="/WebAssg/php/Admin/AdminMainPage.php">
        <img src="/WebAssg/upload/icon/back.png" alt="Back" class="back-icon"> Back 
    </a>

    <div class="container">
        <h1>Admin Sign Up</h1>

        <form id="signupForm" method="post" action="UserSignUpProcess.php" novalidate>
            <?php echo FormHelper::hidden('role', $roleValue); ?>

            <div class="input-container">
                <img src="/WebAssg/upload/icon/personwhite.png" alt="Person" class="input-icon">
                <?php 
                echo FormHelper::text('UName', 'placeholder="Enter Username" value="' . ($formData['UName'] ?? '') . '" required');
                echo FormHelper::error('UName', $errors ?? []);
                ?>
            </div>

            <div class="input-container">
                <img src="/WebAssg/upload/icon/lock.png" alt="Lock" class="input-icon">
                <?php 
                echo FormHelper::password('psw', 'placeholder="Enter password (Use upper,lower,special,> 6char)" required');
                echo FormHelper::error('psw', $errors ?? []);
                ?>
            </div>

            <div class="input-container">
                <img src="/WebAssg/upload/icon/lock.png" alt="Lock" class="input-icon">
                <?php 
                echo FormHelper::password('pswcfm', 'placeholder="Confirm your password" required');
                echo FormHelper::error('pswcfm', $errors ?? []);
                ?>
            </div>

            <div class="input-container">
                <img src="/WebAssg/upload/icon/info.png" alt="Info" class="input-icon">
                <?php 
                echo FormHelper::email('emails', 'placeholder="Email - Exp: Secret@example.com" value="' . ($formData['emails'] ?? '') . '" required');
                echo FormHelper::error('emails', $errors ?? []);
                ?>
            </div>

            <div class="input-container">
                <img src="/WebAssg/upload/icon/phone.png" alt="Phone" class="input-icon">
                <?php 
                echo FormHelper::phone('tel', $formData['tel'] ?? '', 'placeholder="Phone number - Exp: 01XXXXXXXX" required');
                echo FormHelper::error('tel', $errors ?? []);
                ?>
            </div>

            <button type="submit" class="submit-but">Submit</button>
        </form>


    </div>


</body>

<script src="/WebAssg/js/Scripts.js"></script>

</html>