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
        $_SESSION['user_name'] = $user['CustUsername'];
        $_SESSION['login_message'] = "Login Successful! Redirecting to the main page...";
        $_SESSION['redirect_url'] = "MainPage.php"; // Redirect to the main page
    } else {
        $_SESSION['login_message'] = "Invalid Username or Password! Redirecting back to login...";
        $_SESSION['redirect_url'] = "CustomerLogin.php"; // Redirect back to login
    }

    // Redirect to the Login Status page
    header("Location: LoginStatus.php");
    exit;
}
?>
