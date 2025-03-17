<?php
session_start();
include 'connection.php';

$username = $_POST['Username'] ?? '';
$password = $_POST['Userpwd'] ?? '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = $_db->prepare("SELECT Username, Password, Role FROM users WHERE Username = :username");
    $stmt->bindParam(":username", $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Secure password verification
    if ($user && password_verify($password, $user['Password'])) {
        // Store session variables
        $_SESSION['user_name'] = $user['Username'];
        $_SESSION['user_role'] = $user['Role'];

        if ($user['Role'] === 'admin') {
            $_SESSION['login_message'] = "Admin Login Successful! Redirecting...";
            $_SESSION['redirect_url'] = "AdminMainPage.php"; // Redirect admin
        } else {
            $_SESSION['login_message'] = "Customer Login Successful! Redirecting...";
            $_SESSION['redirect_url'] = "MainPage.php"; // Redirect customer
        }

        header("Location: LoginStatus.php");
        exit;
    } else {
        // Login failed
        $_SESSION['error_message'] = "Invalid login credentials";
        header("Location: UserLogin.php");
        exit;
    }
}
?>
