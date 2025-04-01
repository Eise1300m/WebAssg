<?php
require_once("base.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['Username'] ?? '';
    $password = $_POST['Userpwd'] ?? '';
    
    // Basic validation
    if (empty($username)) {
        $_SESSION['flash_message'] = [
            'type' => 'error',
            'message' => 'Please enter your username.'
        ];
        header("Location: UserLogin.php");
        exit;
    }
    
    if (empty($password)) {
        $_SESSION['flash_message'] = [
            'type' => 'error',
            'message' => 'Please enter your password.'
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
                $_SESSION['user_name'] = $user['Username'];
                $_SESSION['user_role'] = $user['Role'];
                
                
                // Redirect based on role
                if ($user['Role'] === 'admin') {
                    header("Location: AdminMainPage.php");
                } else {
                    header("Location: " . ($_SESSION['return_to'] ?? 'MainPage.php'));
                }
                exit;
            } else {
                $_SESSION['flash_message'] = [
                    'type' => 'error',
                    'message' => 'Invalid login credentials.'
                ];
                header("Location: UserLogin.php");
                exit;
            }
        } else {
            $_SESSION['flash_message'] = [
                'type' => 'error',
                'message' => 'Invalid login credentials.'
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