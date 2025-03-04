<?php
require_once("connection.php");

$username = $_POST['AdUname'];
$password = $_POST['Adpwd'];
if (isset($username) && isset($password)) {


    // Use prepared statement to prevent SQL Injection
    $stmt = $conn->prepare("SELECT AdminUsername, AdminPassword FROM admin WHERE AdminUsername = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result(); 

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

       $pwd = $row["AdminPassword"];

       if( $password == $pwd){

        echo "<script>alert('Login Successful');
        window.location.href='CustomerLogin.php';</script>";
        //Redirect to homepage
       }
       else{
        // echo "Invalid Login credentials"; 
        echo("<script>alert('Invalid Login Credentials');
        window.location.href='AdminLogin.php';</script>");
       }

    } else {
        //echo "Invalid Login credentials";
        echo("<script>alert('Invalid Login Credentials');
        window.location.href='AdminLogin.php';</script>");
    }

    $stmt->close();
} else {
    echo "<script>confirm('test')</script>";
}
$conn->close();
