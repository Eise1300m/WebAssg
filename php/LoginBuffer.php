<?php
session_start();
require_once("connection.php");

// Check if user is logged in
if (!isset($_SESSION['user_name'])) {
    header("Location: UserLogin.php");
    exit();
}

$username = $_SESSION['user_name'];
$userRole = $_SESSION['user_role'] ?? 'customer';

// Determine redirect URL based on role
$redirectUrl = ($userRole === 'admin') ? 'AdminMainPage.php' : 'MainPage.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logging In - Secret Shelf</title>
    <link rel="stylesheet" href="../css/LoginBuffer.css">
    <link rel="icon" type="image/x-icon" href="../img/Logo.png">
</head>
<body>
    <div class="buffer-container">
        <div class="buffer-content">
            <img src="../img/Logo.png" alt="Secret Shelf Logo" class="logo">
            <h1>Welcome, <?php echo htmlspecialchars($username); ?>!</h1>
            <div class="loading-spinner"></div>
            <p>Redirecting you to <?php echo ($userRole === 'admin') ? 'Admin Dashboard' : 'Home Page'; ?> in <span id="countdown">3</span> seconds...</p>
            <div id="redirectUrl" data-url="<?php echo $redirectUrl; ?>"></div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let countdown = 3;
            const countdownElement = document.getElementById('countdown');
            const redirectUrl = document.getElementById('redirectUrl').getAttribute('data-url');
            
            const timer = setInterval(function() {
                countdown--;
                countdownElement.textContent = countdown;
                
                if (countdown <= 0) {
                    clearInterval(timer);
                    window.location.href = redirectUrl;
                }
            }, 1000);
        });
    </script>
</body>
</html> 