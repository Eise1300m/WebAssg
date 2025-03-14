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


<?php include_once 'navbar.php';
$error_message = $_SESSION['error_message'] ?? '';
unset($_SESSION['error_message']); 
?>

<?php if (!empty($error_message)): ?>
    <div id="floating-error" class="floating-error"><?= htmlspecialchars($error_message) ?></div>
<?php endif; ?>

<body>
    <div class="container">

        <h1>Login</h1>

        <form method="POST" action="CustomerLoginProcess.php" id="login-form" novalidate>

            <div class="input-container">
                <input type="text" id="CustID" name="CustUname" placeholder="Username..">
                <span class="material-symbols-outlined">person</span>
                <small class="error-message" id="user-error"></small>
            </div>

            <div class="input-container">
                <input type="password" id="Custpwd" name="Custpwd" placeholder="Password..">
                <span class="material-symbols-outlined">lock</span>
                <small class="error-message" id="pass-error"></small>
            </div>

            <button type="submit" class="submit-but">Login</button>
        </form>

        <div class="signup-container">
            <p>Don't have an account?</p>
            <a href="CustomerSignUp.php">Register</a>
        </div>
    </div>


</body>

</html>