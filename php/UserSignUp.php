<?php
if(session_status() == PHP_SESSION_NONE){
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
    <link rel="stylesheet" href="../css/CustomerSignUpStyles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../css/NavbarStyles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Big+Shoulders:opsz,wght@10..72,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto+Condensed:ital,wght@0,537;1,537&display=swap" rel="stylesheet">
    <script src="../js/Scripts.js"></script>

</head>

<?php

include 'navbar.php'

?>

<body>

    <div class="container">

        <h1>Sign Up</h1>

        <form id="signupForm" method="post" action="UserSignUpProcess.php">

        <input type="hidden" name="role" value="<?= $roleValue ?>">


            <div class="input-container"> 
                <span class="icon"><i class="fas fa-user"></i></span>
                <input type="text" id="UName" name="UName" placeholder="Enter Username">
                <span class="error-message" id="nameError"></span>
            </div>

            <div class="input-container">
                <span class="icon"><i class="fas fa-lock"></i></span>
                <input type="password" id="psw" name="psw" placeholder="Enter password">
                <span class="error-message" id="pswError"></span>
            </div>

            <div class="input-container">
                <span class="icon"><i class="fas fa-lock"></i></span>
                <input type="password" id="pswcfm" name="pswcfm" placeholder="Confirm your password">
                <span class="error-message" id="pswcfmError"></span>
            </div>

            <div class="input-container">
                <span class="icon"><i class="fas fa-envelope"></i></span>
                <input type="text" id="emails" placeholder="Email - Exp: Secret@example.com" name="emails">
                <span class="error-message" id="emailError"></span>
            </div>

            <div class="input-container">
                <span class="icon"><i class="fas fa-phone"></i></span>
                <input type="text" id="tel" name="tel" placeholder="Phone number - Exp: 01XXXXXXXX">
                <span class="error-message" id="telError"></span>
            </div>

            <button type="submit" class="submit-but">Submit</button>
        </form>


        <div class="signup-container">
            <p>Already have an account ?</p>
            <a href="UserLogin.php">Login</a>
        </div>


    </div>

</body>


</html>