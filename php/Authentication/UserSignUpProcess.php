<?php
session_start();
require_once("../base.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['UName'] ?? '';
    $password = $_POST['pswcfm'] ?? '';
    $email = $_POST['emails'] ?? '';
    $contact = $_POST['tel'] ?? '';
    $role = $_POST['role'] ?? 'customer'; // Default role is "customer"
    
    $referer = $_SERVER['HTTP_REFERER'] ?? '';
    $redirectUrl = (strpos($referer, 'AdminSignup.php') !== false) ? 'AdminSignup.php' : 'UserLogin.php';

    try {
        // Check if username or email already exists
        $check_sql = "SELECT Username FROM users WHERE Username = :username OR Email = :email";
        $stmt = $_db->prepare($check_sql);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Create flash message
            $_SESSION['flash_message'] = [
                'type' => 'error',
                'message' => 'Username or Email is already registered!'
            ];
            
            header("Location: $redirectUrl");
            exit();
        }

        // Secure password hashing
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert new user record with dynamic role
        $insert_sql = "INSERT INTO users (Username, Password, Email, ContactNo, Role) 
                       VALUES (:username, :password, :email, :contact, :role)";
        $stmt = $_db->prepare($insert_sql);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":password", $hashedPassword);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":contact", $contact);
        $stmt->bindParam(":role", $role);

        if ($stmt->execute()) {

            
            // Redirect to success page or appropriate dashboard
            if ($role === 'admin') {
                $_SESSION['flash_message'] = [
                    'type' => 'success',
                    'message' => 'Registration successful!'
                ];
                
                header("Location: /WebAssg/php/Admin/AdminMainPage.php");
            } else {
                header("Location: /WebAssg/php/Authentication/RegisterSuccess.php");
            }
            exit();
        } else {
            $_SESSION['flash_message'] = [
                'type' => 'error',
                'message' => 'Failed to Register, Please try again later!'
            ];
            
            header("Location: $redirectUrl");
            exit();
        }
    } catch (PDOException $e) {
        // Create flash message for exception
        $_SESSION['flash_message'] = [
            'type' => 'error',
            'message' => "Database Error: " . $e->getMessage()
        ];
        
        header("Location: $redirectUrl");
        exit();
    }
}
?>
