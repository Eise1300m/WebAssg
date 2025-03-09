<?php
session_start();

// Redirect to login immediately if not logged in
if (!isset($_SESSION['user_name'])) {
    header("Location: CustomerLogin.php");
    exit;
}

$message = $_SESSION['login_message'] ?? 'Redirecting...';
$redirect_url = $_SESSION['redirect_url'] ?? 'MainPage.php';

// Clear session messages
unset($_SESSION['login_message']);
unset($_SESSION['redirect_url']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redirecting...</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../css/loading.css">
</head>
<body>
    <div class="loader-container">
        <div class="loader"></div>
        <p class="loading-text" id="loginMessage"><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></p>
        <span id="redirectUrl" style="display: none;"><?php echo htmlspecialchars($redirect_url, ENT_QUOTES, 'UTF-8'); ?></span>
    </div>
    
    <!-- Include script at the end of body -->
    <script src="../js/Scripts.js"></script>
    
    </script>
</body>
</html>
