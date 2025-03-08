<?php
session_start();

// Get message and redirect URL from session
$message = $_SESSION['login_message'] ?? 'Something went wrong!';
$redirect_url = $_SESSION['redirect_url'] ?? 'CustomerLogin.php';

// Clear session messages after use
unset($_SESSION['login_message']);
unset($_SESSION['redirect_url']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../js/Scripts.js"></script>
    <link rel="stylesheet" href="loading.css"> <!-- External CSS -->

</head>


<body>
    <div class="loader-container">
        <div class="loader"></div>
        <p class="loading-text">Redirecting, please wait...</p>
    </div>
</body>
</html>