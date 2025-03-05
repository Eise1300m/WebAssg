<?php
require_once("connection.php");

$username = $_POST['CustUname'];
$password = $_POST['Custpwd'];

if (isset($username) && isset($password)) {


    // Use prepared statement to prevent SQL Injection
    $stmt = $conn->prepare("SELECT CustUsername, CustomerPassword FROM customer WHERE CustUsername = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result(); 

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

       $pwd = $row["CustomerPassword"];

       if( $password == $pwd){

        echo "<script>alert('Login Sucessful');
        window.location.href='UserMain.php';</script>";
        //Redirect to homepage
       }
       else{
        // echo "Invalid Login credentials"; 
        echo("<script>alert('Invalid Username or Password');
        window.location.href='CustomerLogin.php';</script>");
       }

    } else {
        //echo "Invalid Login credentials";
        echo("<script>alert('Invalid Username or Password');
        window.location.href='CustomerLogin.php';</script>");
    }

    $stmt->close();
} else {
    echo "<script>confirm('Error Database Linking')</script>";
}
$conn->close();
