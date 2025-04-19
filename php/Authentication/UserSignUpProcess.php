<?php
session_start();
require_once("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['UName'] ?? '';
    $password = $_POST['pswcfm'] ?? '';
    $email = $_POST['emails'] ?? '';
    $contact = $_POST['tel'] ?? '';
    $role = $_POST['role'] ?? 'customer'; // Default role is "customer" unless specified

    try {
        // Check if username or email already exists
        $check_sql = "SELECT Username FROM users WHERE Username = :username OR Email = :email";
        $stmt = $_db->prepare($check_sql);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $_SESSION['signup_errors'] = ['Username or Email is already registered!'];
            $_SESSION['signup_data'] = $_POST;
            header("Location: UserSignUp.php"); // Redirect back to the signup page
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
            header("Location: RegisterSuccess.php");
            exit();
        } else {
            $_SESSION['signup_errors'] = ['Failed to Register, Please try again later!'];
            $_SESSION['signup_data'] = $_POST;
            header("Location: UserSignUp.php"); // Redirect back to the signup page
            exit();
        }
    } catch (PDOException $e) {
        $_SESSION['signup_errors'] = ["Database Error: " . $e->getMessage()];
        $_SESSION['signup_data'] = $_POST;
        header("Location: UserSignUp.php"); // Redirect back to the signup page
        exit();
    }
}
?>
