<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $_title ?? 'Secret Shelf' ?></title>
    <link rel="stylesheet" href="../css/CustomerSignUpStyles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/validation.js"></script>

</head>

<body> 
    <div class="login-container">


            <h1 style="font-size: 25px;">User Sign Up</h1>

            <form id="signupForm" method="post" action="CustomerSignUpProcess.php">

                <label for="CustName">Username</label>
                <input type="text" id="CustName" name="CustName" >
                <span class="error-message" id="nameError"></span>

                <label for="psw">Password</label>
                <input type="password" id="psw" name="psw" >
                <span class="error-message" id="pswError"></span>

                <label for="pswcfm">Password Confirmation</label>
                <input type="password" id="pswcfm" name="pswcfm" >
                <span class="error-message" id="pswcfmError"></span>

                <label for="emails">Email</label>
                <input type="text" id="emails" placeholder="Exp: Secret@example.com" name="emails" >
                <span class="error-message" id="emailError"></span>

                <label for="tel" > No Tel.</label>
                <input type="text" id="tel" name="tel" placeholder = "Exp: 01XXXXXXXX" >
                <span class="error-message" id="telError"></span>

                <button type="submit">Submit</button>

            </form>

        </div>

    </div>

</body>




</html>






