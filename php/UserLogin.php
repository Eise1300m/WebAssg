<?php
require_once("base.php");
require_once("../lib/FormHelper.php");
require_once("../lib/ValidationHelper.php");

if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'MainPage.php') !== false) {
    $_SESSION['return_to'] = $_SERVER['HTTP_REFERER'];
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = ValidationHelper::sanitizeInput($_POST['Username'] ?? '');
    $password = $_POST['Userpwd'] ?? '';
    
    $errors = [];
    
    if (empty($username)) {
        $errors['Username'] = 'Username is required';
    }
    
    if (empty($password)) {
        $errors['Userpwd'] = 'Password is required';
    }
    
    if (empty($errors)) {
        // Validate credentials
        $stmt = $_db->prepare("SELECT UserID, Username, Password, Role FROM users WHERE Username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && ValidationHelper::verifyPassword($password, $user['Password'])) {
            $_SESSION['user_name'] = $user['Username'];
            $_SESSION['user_role'] = $user['Role'];
            

            header("Location: LoginBuffer.php");
            exit();
        } else {

            $_SESSION['flash_message'] = [
                'type' => 'error',
                'message' => 'Invalid username or password'
            ];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $_title ?? 'Secret Shelf / Login' ?></title>
    <link rel="stylesheet" href="../css/LoginStyles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/Scripts.js"></script>
    <link rel="stylesheet" href="../css/NavbarStyles.css">
    <link rel="icon" type="image/x-icon" href="../img/Logo.png">
</head>

<?php
// Include navbar
includeNavbar();
?>

<body>
    <?php displayFlashMessage(); ?>

    <a class="back-button" onclick="window.history.back()">
        <img src="../upload/icon/back.png" alt="Back" class="back-icon"> Back
    </a>

    <div class="container">
        <h1>Login</h1>

        <form method="POST" action="UserLogin.php" id="login-form" novalidate>
            <div class="input-container">
                <?php 
                echo FormHelper::text('Username', 'placeholder="Username.." required');
                echo FormHelper::error('Username', $errors ?? []);
                ?>
                <img src="../upload/icon/personwhite.png" alt="Person" class="person-icon">
            </div>

            <div class="input-container">
                <?php 
                echo FormHelper::password('Userpwd', 'placeholder="Password.." required');
                echo FormHelper::error('Userpwd', $errors ?? []);
                ?>
                <img src="../upload/icon/lock.png" alt="Lock" class="lock-icon">
            </div>

            <button type="submit" class="submit-but">Login</button>
        </form>

        <div class="signup-container">
            <p>Don't have an account?</p>
            <a href="UserSignUp.php">Register</a>
        </div>
    </div>
</body>
</html>