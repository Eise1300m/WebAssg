<?php
require_once("../base.php");
require_once("../../lib/ValidationHelper.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['Username'] ?? '';
    $password = $_POST['Userpwd'] ?? '';
    
    // Store redirect URL from form if provided
    if (isset($_POST['redirect'])) {
        $_SESSION['return_to'] = $_POST['redirect'];
    }
    
    // Initialize errors array
    $errors = [];
    
    // Basic validation
    if (empty($username)) {
        $errors['Username'] = 'Username is required';
    }
    
    if (empty($password)) {
        $errors['Userpwd'] = 'Password is required';
    }
    
    // If there are validation errors, store them in session and redirect back
    if (!empty($errors)) {
        $_SESSION['login_errors'] = $errors;
        $_SESSION['flash_message'] = [
            'type' => 'error',
            'message' => 'Password or Username is incorrect'
        ];
        header("Location: UserLogin.php");
        exit;
    }

    try {
        $sql = "SELECT * FROM users WHERE Username = :username";
        $stmt = $_db->prepare($sql);
        $stmt->bindParam(":username", $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if (password_verify($password, $user['Password'])) {
                // Login successful
                $_SESSION['user_id'] = $user['UserID'];
                $_SESSION['user_name'] = $username;
                $_SESSION['user_role'] = $user['Role'];
                
                // Redirect the user based on role
                if ($user['Role'] == 'admin') {
                    // Admin redirect
                    header("Location: /WebAssg/php/Admin/AdminMainPage.php");
                    exit();
                } else {
                    // Regular user redirect
                    // Check if we have a return URL saved in the session
                    if (isset($_SESSION['return_to'])) {
                        $redirect_url = $_SESSION['return_to'];
                        unset($_SESSION['return_to']); // Clear it after use
                        header("Location: $redirect_url");
                        exit();
                    } else {
                        // Default redirect to main page
                        header("Location: /WebAssg/php/MainPage.php");
                        exit();
                    }
                }
            } else {
                $_SESSION['flash_message'] = [
                    'type' => 'error',
                    'message' => 'Invalid username or password'
                ];
                header("Location: UserLogin.php");
                exit;
            }
        } else {
            $_SESSION['flash_message'] = [
                'type' => 'error',
                'message' => 'Invalid username or password'
            ];
            header("Location: UserLogin.php");
            exit;
        }
    } catch (PDOException $e) {
        error_log("Login error: " . $e->getMessage());
        
        $_SESSION['flash_message'] = [
            'type' => 'error',
            'message' => 'An error occurred. Please try again later.'
        ];
        header("Location: UserLogin.php");
        exit;
    }
} else {
    $_SESSION['flash_message'] = [
        'type' => 'error',
        'message' => '❌ Invalid request method.'
    ];
    header("Location: UserLogin.php");
    exit;
}
?>