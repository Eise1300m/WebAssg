<?php
require_once("base.php");

if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'MainPage.php') !== false) {
    $_SESSION['return_to'] = $_SERVER['HTTP_REFERER'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $_title ?? 'Secret Shelf / Login' ?></title>
    <link rel="stylesheet" href="../css/LoginStyles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/Scripts.js"></script>
    <link rel="stylesheet" href="../css/NavbarStyles.css">
    <link rel="icon" type="image/x-icon" href="../img/Logo.png">
</head>

<?php
// Include navbar
includeNavbar();
?>

<body>
    <?php displayFlashMessage(); ?>

    <a class="back-button" onclick="window.history.back()">
        <img src="../upload/icon/back.png" alt="Back" class="back-icon"> Back
    </a>

    <div class="container">
        <h1>Login</h1>

        <form method="POST" action="UserLoginProcess.php" id="login-form" novalidate>
            <div class="input-container">
                <input type="text" id="UserID" name="Username" placeholder="Username..">
                <img src="../upload/icon/personwhite.png" alt="Person" class="person-icon">
                <small class="error-message" id="user-error"></small>
            </div>

            <div class="input-container">
                <input type="password" id="Userpwd" name="Userpwd" placeholder="Password..">
                <img src="../upload/icon/lock.png" alt="Lock" class="lock-icon">
                <small class="error-message" id="pass-error"></small>
            </div>

            <button type="submit" class="submit-but">Login</button>
        </form>

        <div class="signup-container">
            <p>Don't have an account?</p>
            <a href="UserSignUp.php">Register</a>
        </div>
    </div>
</body>
</html>