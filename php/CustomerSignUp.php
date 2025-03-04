<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $_title ?? 'Secret Shelf' ?></title>
<<<<<<< HEAD
    <link rel="stylesheet" href="css/AdminLoginStyles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/validation.js"></script>
=======
    <link rel="stylesheet" href="../css/CustomerSignUpStyles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/validation.js"></script>

>>>>>>> 6a36f37 (3/5 2.27)
</head>

<body> 
    <div class="login-container">

<<<<<<< HEAD
        <div class="login-left">

            <h1 style="font-size: 25px;">User Sign Up</h1>

        </div>

        <div class="login-right">

            <form id="signupForm" method="post" action="CustomerSignUpProcess.php">

                <label for="CustName">Your Name</label>
=======

            <h1 style="font-size: 25px;">User Sign Up</h1>

            <form id="signupForm" method="post" action="CustomerSignUpProcess.php">

                <label for="CustName">Username</label>
>>>>>>> 6a36f37 (3/5 2.27)
                <input type="text" id="CustName" name="CustName" >
                <span class="error-message" id="nameError"></span>

                <label for="psw">Password</label>
                <input type="password" id="psw" name="psw" >
                <span class="error-message" id="pswError"></span>

                <label for="pswcfm">Password Confirmation</label>
                <input type="password" id="pswcfm" name="pswcfm" >
                <span class="error-message" id="pswcfmError"></span>

                <label for="emails">Email</label>
<<<<<<< HEAD
                <input type="email" id="emails" placeholder="Exp: Secret@example.com" name="emails" >
                <span class="error-message" id="emailError"></span>

                <label for="tel" > No Tel.</label>
                <input type="text" id="tel" name="tel" placeholder = "Exp: 01XXXXXXXX" pattern="^01\d{8,9}$" >
                <span class="error-message" id="telError"></span>

                <label for="add">Address</label>
                <input type="text" id="add" name="add" pattern="[A-Za-z0-9\s,.-]{5,}">
                <span class="error-message" id="addError"></span>

=======
                <input type="text" id="emails" placeholder="Exp: Secret@example.com" name="emails" >
                <span class="error-message" id="emailError"></span>

                <label for="tel" > No Tel.</label>
                <input type="text" id="tel" name="tel" placeholder = "Exp: 01XXXXXXXX" >
                <span class="error-message" id="telError"></span>

>>>>>>> 6a36f37 (3/5 2.27)
                <button type="submit">Submit</button>

            </form>

        </div>

    </div>

</body>

<<<<<<< HEAD
=======



>>>>>>> 6a36f37 (3/5 2.27)
</html>






