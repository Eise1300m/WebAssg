<?php
session_start();

// Check if the role is set in the session (assuming you store it after registration)
$userRole = $_SESSION['user_role'] ?? 'customer'; // Default to customer if not set

// Determine the redirect page
$redirectPage = ($userRole === 'admin') ? 'AdminMainPage.php' : 'index.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>  
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secret Shelf - Registration Success</title>
    <link rel="stylesheet" href="../css/RegisterSucessStyles.css">
</head>

<body>
    <div class="container">
        <p>Sign Up Successful</p>
        <p>Click here to login</p><br>
        <button onclick="window.location.href='<?= $redirectPage ?>';" id="login-btn">Login</button>
    </div>
</body>

</html>
