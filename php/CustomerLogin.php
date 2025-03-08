<?php
session_start();
$error_message = $_SESSION['error_message'] ?? '';
unset($_SESSION['error_message']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($_title) ? $_title : 'Secret Shelf / Login' ?></title>
    <link rel="stylesheet" href="../css/LoginStyles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Big+Shoulders:opsz,wght@10..72,100..900&family=Poppins:wght@100..900&family=Roboto+Condensed:wght@537&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../img/Logo.png">
</head>

<?php include 'navbar.php'; ?>

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