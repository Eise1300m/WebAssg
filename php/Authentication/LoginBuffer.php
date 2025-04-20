<!-- <?php
session_start();
require_once("../base.php");

if (!isset($_SESSION['user_name'])) {
    header("Location: UserLogin.php");
    exit();
}

$username = $_SESSION['user_name'];
$userRole = $_SESSION['user_role'] ?? 'customer';

// Determine redirect URL based on role
$redirectUrl = ($userRole === 'admin') ? '../Admin/AdminMainPage.php' : '../MainPage.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logging In - Secret Shelf</title>
    <link rel="stylesheet" href="/WebAssg/css/LoginBuffer.css">
    <link rel="icon" type="image/x-icon" href="/WebAssg/img/Logo.png">
    <script src="/WebAssg/js/Scripts.js"></script>
</head>
<body>
    <div class="buffer-container">
        <div class="buffer-content">
            <img src="/WebAssg/img/Logo.png" alt="Secret Shelf Logo" class="logo">
            <h1>Welcome, <?php echo htmlspecialchars($username); ?>!</h1>
            <div class="loading-spinner"></div>
            <p>Redirecting you to <?php echo ($userRole === 'admin') ? 'Admin Dashboard' : 'Home Page'; ?> in <span id="countdown">3</span> seconds...</p>
            <div id="redirectUrl" data-url="<?php echo $redirectUrl; ?>"></div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            initializeLoginBuffer();
        });
    </script>
</body>
</html>  -->