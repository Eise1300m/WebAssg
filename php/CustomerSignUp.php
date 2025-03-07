<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $_title ?? 'Secret Shelf / SignUp' ?></title>
    <link rel="stylesheet" href="../css/SidenavStyles.css">
    <link rel="stylesheet" href="../css/CustomerSignUpStyles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Big+Shoulders:opsz,wght@10..72,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto+Condensed:ital,wght@0,537;1,537&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/validation.js"></script>

</head>

<?php

require_once("navbar.php");

?>

<body>

    <div class="container">

        <h1>Sign Up</h1>

        <form id="signupForm" method="post" action="CustomerSignUpProcess.php">

            <div class="input-container">
                <span class="icon"><i class="fas fa-user"></i></span>
                <input type="text" id="CustName" name="CustName" placeholder="Enter Username">
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
            <a href="CustomerLogin.php">Login</a>
        </div>


    </div>

</body>


</html>