<?php
require_once("../base.php");
require_once("../../lib/FormHelper.php");

if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'MainPage.php') !== false) {
    $_SESSION['return_to'] = $_SERVER['HTTP_REFERER']; // store the URL of the page the user was on before login
}

$errors = [];
if (isset($_SESSION['login_errors'])) {
    $errors = $_SESSION['login_errors'];
    unset($_SESSION['login_errors']);
}

includeNavbar();
displayFlashMessage();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $_title ?? 'Secret Shelf / Login' ?></title>
    <link rel="stylesheet" href="../../css/LoginStyles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../../js/Scripts.js"></script>
    <link rel="stylesheet" href="../../css/NavbarStyles.css">
</head>


<body>

    <a class="back-button" href="../index.php">
        <img src="../../upload/icon/back.png" alt="Back" class="back-icon"> Back to HomePage
    </a>

    <div class="container">
        <h1>Login</h1>

        <form method="POST" action="UserLoginProcess.php" id="login-form" novalidate>
            <div class="input-container">
                <?php 
                echo FormHelper::text('Username', 'placeholder="Username.." required');
                echo FormHelper::error('Username', $errors ?? []);
                ?>
                <img src="../../upload/icon/personwhite.png" alt="Person" class="person-icon">
            </div>

            <div class="input-container">
                <?php 
                echo FormHelper::password('Userpwd', 'placeholder="Password.." required');
                echo FormHelper::error('Userpwd', $errors ?? []);
                ?>
                <img src="../../upload/icon/lock.png" alt="Lock" class="lock-icon">
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