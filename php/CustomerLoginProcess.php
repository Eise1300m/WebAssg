<?php
require_once("connection.php");

$username = $_POST['CustUname'];
$password = $_POST['Custpwd'];

if (isset($username) && isset($password)) {


    // Use prepared statement to prevent SQL Injection
<<<<<<< HEAD
    $stmt = $conn->prepare("SELECT CustomerUsername, CustomerPassword FROM customer WHERE CustomerUsername = ?");
=======
    $stmt = $conn->prepare("SELECT CustUsername, CustomerPassword FROM customer WHERE CustUsername = ?");
>>>>>>> 6a36f37 (3/5 2.27)
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result(); 

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

       $pwd = $row["CustomerPassword"];

       if( $password == $pwd){

<<<<<<< HEAD
        echo "<script>alert('Login Credentials');
        window.location.href='CustomerLogin.php';</script>";
=======
        echo "<script>alert('Login Sucessful');
        window.location.href='UserMain.php';</script>";
>>>>>>> 6a36f37 (3/5 2.27)
        //Redirect to homepage
       }
       else{
        // echo "Invalid Login credentials"; 
<<<<<<< HEAD
        echo("<script>alert('Invalid Login Credentials');
=======
        echo("<script>alert('Invalid Username or Password');
>>>>>>> 6a36f37 (3/5 2.27)
        window.location.href='CustomerLogin.php';</script>");
       }

    } else {
        //echo "Invalid Login credentials";
<<<<<<< HEAD
        echo("<script>alert('Invalid Login Credentials');
=======
        echo("<script>alert('Invalid Username or Password');
>>>>>>> 6a36f37 (3/5 2.27)
        window.location.href='CustomerLogin.php';</script>");
    }

    $stmt->close();
} else {
    echo "<script>confirm('Error Database Linking')</script>";
}
$conn->close();
