<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$errors = $_SESSION['signup_errors'] ?? [];
$input_data = $_SESSION['signup_data'] ?? [];
unset($_SESSION['signup_errors'], $_SESSION['signup_data']);

$signupType = $_GET['type'] ?? 'user'; // Default to 'user' if not specified
$formAction = ($signupType === 'admin') ? 'UserSignUpProcess.php' : 'UserSignUpProcess.php';
$roleValue = ($signupType === 'admin') ? "admin" : "customer"; // Set role value
?>

<?php if (!empty($errors)): ?>
    <div id="floating-error" class="floating-error">
        <?php
        // Display errors as a list if there are multiple
        if (is_array($errors)) {
            echo htmlspecialchars($errors[0]); // Just show the first error
        } else {
            echo htmlspecialchars($errors);
        }
        ?>
    </div>
<?php endif; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $_title ?? 'Secret Shelf / SignUp' ?></title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../css/NavbarStyles.css">
    <link rel="stylesheet" href="../css/CustomerSignUpStyles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="../js/Scripts.js"></script>
</head>

<?php
include 'navbar.php'
?>

<body>
    <a class="back-button" onclick="window.history.back()">
        <img src="../upload/icon/back.png" alt="Back" class="back-icon"> Back 
    </a>

    <div class="container">
        <h1>Sign Up</h1>

        <form id="signupForm" method="post" action="UserSignUpProcess.php">
            <?php echo FormHelper::hidden('role', $roleValue); ?>

            <div class="input-container">
                <span class="icon"><i class="fas fa-user"></i></span>
                <?php echo FormHelper::text('UName', 'placeholder="Enter Username"'); ?>
                <span class="error-message" id="nameError"><?php echo FormHelper::error('UName'); ?></span>
            </div>

            <div class="input-container">
                <span class="icon"><i class="fas fa-lock"></i></span>
                <?php echo FormHelper::password('psw', 'placeholder="Enter password"'); ?>
                <span class="error-message" id="pswError"><?php echo FormHelper::error('psw'); ?></span>
            </div>

            <div class="input-container">
                <span class="icon"><i class="fas fa-lock"></i></span>
                <?php echo FormHelper::password('pswcfm', 'placeholder="Confirm your password"'); ?>
                <span class="error-message" id="pswcfmError"><?php echo FormHelper::error('pswcfm'); ?></span>
            </div>

            <div class="input-container">
                <span class="icon"><i class="fas fa-envelope"></i></span>
                <?php echo FormHelper::email('emails', 'placeholder="Email - Exp: Secret@example.com"'); ?>
                <span class="error-message" id="emailError"><?php echo FormHelper::error('emails'); ?></span>
            </div>

            <div class="input-container">
                <span class="icon"><i class="fas fa-phone"></i></span>
                <?php echo FormHelper::text('tel', 'placeholder="Phone number - Exp: 01XXXXXXXX"'); ?>
                <span class="error-message" id="telError"><?php echo FormHelper::error('tel'); ?></span>
            </div>

            <?php echo FormHelper::submit('Submit', 'class="submit-but"'); ?>
        </form>

        <div class="signup-container">
            <p>Already have an account ?</p>
            <a href="UserLogin.php">Login</a>
        </div>
    </div>
</body>
</html>