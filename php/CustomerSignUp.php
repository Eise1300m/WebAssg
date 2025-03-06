<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $_title ?? 'Secret Shelf / SignUp' ?></title>
    <link rel="stylesheet" href="../css/SidenavStyles.css">
    <link rel="stylesheet" href="../css/CustomerSignUpStyles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/validation.js"></script>

</head>

<?php

require_once("navbar.php");

?>

<body>

    <div class="container">

        <h1>User Sign Up</h1>

        <form id="signupForm" method="post" action="CustomerSignUpProcess.php">

            <label for="CustName">Username</label>
            <input type="text" id="CustName" name="CustName" placeholder="Enter Username">
            <span class="error-message" id="nameError"></span>

            <label for="psw">Password</label>
            <input type="password" id="psw" name="psw" placeholder="Enter passsword">
            <span class="error-message" id="pswError"></span>

            <label for="pswcfm">Password Confirmation</label>
            <input type="password" id="pswcfm" name="pswcfm" placeholder="Comfirm your password">
            <span class="error-message" id="pswcfmError"></span>

            <label for="emails">Email</label>
            <input type="text" id="emails" placeholder="Exp: Secret@example.com" name="emails">
            <span class="error-message" id="emailError"></span>

            <label for="tel"> No Tel.</label>
            <input type="text" id="tel" name="tel" placeholder="Exp: 01XXXXXXXX">
            <span class="error-message" id="telError"></span>

            <button type="submit" class="submit-but">Submit</button>

        </form>

    </div>

</body>


</html>