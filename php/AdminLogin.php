<!DOCTYPE html>
<html lang="en">

<head>  

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $_title ?? 'Secret Shelf' ?></title>
    <link rel="stylesheet" href="css/AdminLoginStyles.css">
    <script src="/js/app.js"></script>

</head>

<body> 
    <div class="login-container">

        <div class="login-left">

            <h1>Login Page</h1>

        </div>

        <div class="login-right">

            <form method="POST" action="AdminLoginProcess.php">
                <label for="AdID">AdminUsername:</label><br>
                <input type="text" id="AdID" name="AdUname" ><br><br>
                <label for="Adpwd">Password:</label><br>
                <input type="password" id="Adpwd" name="Adpwd"><br><br>
                <button type="submit">Login</button>
            </form>

        </div>

        <div id="mySidenav" class="sidenav">
        <a href="#" id="about">About</a>
        <a href="#" id="blog">Blog</a>
        <a href="#" id="projects">Projects</a>
        <a href="#" id="contact">Contact</a>
</div>

    </div>

</body>

</html>


