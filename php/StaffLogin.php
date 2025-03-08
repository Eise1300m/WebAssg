<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $_title ?? 'Secret Shelf' ?></title>
    <link rel="stylesheet" href="../css/StaffLoginStyles.css">

</head>

<?php
    require_once("navbar.php");
?>

<body>
    <div class="login-container">

        <div class="Login-details">

            <h1>Staff Login</h1>

            <form method="POST" action="StaffLoginProcess.php">

                <label for="StaffID">Staff Username:</label><br>
                <input type="text" id="StaffID" name="StaffUname" placeholder="Username"><br><br>
                <span class="error-message" id="wrongID"></span>

                <label for="Staffpwd">Password:</label><br>
                <input type="password" id="Staffpwd" name="Staffpwd" placeholder="Password"><br><br>
                <span class="error-message" id="wrongPSW"></span>

                <button type="submit" class="login-btn">Login</button>

            </form>

        </div>

    </div>

</body>


</html>