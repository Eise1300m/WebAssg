<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $_title ?? 'Secret Shelf / Login' ?></title>
    <link rel="stylesheet" href="../css/StaffLoginStyles.css">
    <link href="https://fonts.googleapis.com/css2?family=Big+Shoulders:opsz,wght@10..72,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto+Condensed:ital,wght@0,537;1,537&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined">
    <link rel="icon" type="image/x-icon" href="../img/Logo.png">


</head>

<?php

require_once("navbar.php");

?>


<body>

    <div class="container">

        <h1>Login</h1>

        <form method="POST" action="CustomerLoginProcess.php">

            <div class="input-container">
                <input type="text" id="CustID" name="CustUname" placeholder="Username..">
                <span class="material-symbols-outlined">person</span><br>
            </div>

            <div class="input-container">
                <input type="password" id="Custpwd" name="Custpwd" placeholder="Password..">
                <span class="material-symbols-outlined">lock</span>
            </div>

            <button type="submit" class="submit-but">Login</button>

        </form>


        <div class="signup-container">
            <p>Don't have an account ?</p>
            <a href="CustomerSignUp.php">Register</a>
        </div>

    </div>

    </div>

</body>

</html>