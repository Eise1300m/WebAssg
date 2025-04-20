<?php
session_start();

// Check if the role is set in the session (assuming you store it after registration)
$userRole = $_SESSION['user_role'] ?? 'customer'; // Default to customer if not set

// Determine the redirect page
$redirectPage = ($userRole === 'admin') ? '/WebAssg/php/Admin/AdminMainPage.php' : '/WebAssg/php/MainPage.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>  
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secret Shelf - Registration Success</title>
    <link rel="stylesheet" href="/WebAssg/css/RegisterSucessStyles.css">
</head>

<body>
    <div class="container">
        <div class="success-icon">
            <img src="/WebAssg/upload/icon/check.png" alt="Success" class="check-icon">
        </div>
        <div class="success-message">
            <h1>Welcome to Secret Shelf!</h1>
            <p>Your registration was successful</p>
        </div>
        <div class="action-button">
            <button onclick="window.location.href='/WebAssg/php/Authentication/UserLogin.php';" id="login-btn">
                <img src="/WebAssg/upload/icon/login.png" alt="Login" class="button-icon">
                Login Now
            </button>
        </div>
    </div>
</body>

</html>
