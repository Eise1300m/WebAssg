<?php
session_start();
include 'connection.php';

$username = $_POST['CustUname'] ?? '';
$password = $_POST['Custpwd'] ?? '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = $_db->prepare("SELECT CustUsername, CustomerPassword FROM customer WHERE CustUsername = :username");
    $stmt->bindParam(":username", $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && $password === $user['CustomerPassword']) {
        // Login successful
        $_SESSION['user_name'] = $user['CustUsername'];
        $_SESSION['login_message'] = "Login Successful! Redirecting to main page...";
        $_SESSION['redirect_url'] = "MainPage.php";
        header("Location: LoginStatus.php");
        exit;
    } else {
        // Login failed - set error message for login page
        $_SESSION['error_message'] = "Invalid login credentials";
        header("Location: CustomerLogin.php");
        exit;
    }
}
?>