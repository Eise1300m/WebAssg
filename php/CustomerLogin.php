<!DOCTYPE html>
<html lang="en">

<head>  

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $_title ?? 'Secret Shelf' ?></title>
    <link rel="stylesheet" href="../css/AdminLoginStyles.css">

    

</head>

<body> 
    <div class="login-container">

        <div class="login-left">

            <h1 >User Login</h1>

        </div>

        <div class="login-right">

            <form method="POST" action="CustomerLoginProcess.php">
                <label for="CustUname">Username:</label><br>
                <input type="text" id="CustID" name="CustUname" ><br><br>
                <label for="Adpwd">Password:</label><br>
                <input type="password" id="Custpwd" name="Custpwd"><br><br>
                <button type="submit">Login</button>
            </form>

        </div>

    </div>

</body>

</html>

