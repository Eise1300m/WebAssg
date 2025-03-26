<!-- Display Error Messages if Any -->
<?php
session_start();
if (isset($_SESSION['signup_errors'])) {
    echo '<div class="error-box">';
    foreach ($_SESSION['signup_errors'] as $error) {
        echo "<p class='error-message'>$error</p>";
    }
    echo '</div>';
    unset($_SESSION['signup_errors']); // Clear errors after displaying
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration - Secret Shelf</title>
    <link rel="stylesheet" href="../css/CustomerSignUpStyles.css">
    <link rel="stylesheet" href="../css/NavbarStyles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="../js/Scripts.js"></script>

</head>

<body>

    <?php include 'navbaradmin.php'; ?>
    
    <!-- Back button to AdminMainPage.php -->
    <a class="back-button" onclick="window.history.back()">
        <img src = "../upload/icon/back.png" alt="Back" class="back-icon"> Back to Dashboard
    </a>

    <div class="container">
        <h1>Admin Sign Up</h1>

        <form id="adminSignupForm" method="post" action="UserSignUpProcess.php">

            <!-- Hidden input field to mark this as an admin registration -->
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
            <p>Already have an admin account?</p>
            <a href="AdminLogin.php">Login</a>
        </div>
    </div>

</body>


</html>