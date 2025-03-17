<?php
session_start();
require_once("connection.php");

// Ensure only admins can access
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: UserLogin.php");
    exit();
}

require_once ('navbar.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/AdminStyles.css">
</head>
<body>
    <h1>Admin Dashboard</h1>
    <button onclick="window.location.href='UserSignUp.php?type=admin'">Add New Admin</button>
</body>
</html>