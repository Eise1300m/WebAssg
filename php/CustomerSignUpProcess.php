<?php

session_start();

require_once("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['CustName'];
    $password = $_POST['pswcfm'];
    $email = $_POST['emails'];
    $contact = $_POST['tel'];

    $check_sql = "SELECT CustUsername FROM customer WHERE CustUsername = :username OR Email = :email";
    $stmt = $_db->prepare($check_sql);
    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":email", $email);
    $stmt->execute();


    if ($stmt->rowCount() > 0) {

        echo "<script> alert('Username or Email is already registered!')
        ;window.history.back()
        ;</script>";

        exit();
    }



    $insert_sql = "INSERT INTO customer (CustUsername, CustomerPassword, Email, ContactNo) 
                   VALUES (:username, :password, :email, :contact)";
    $stmt = $_db->prepare($insert_sql);
    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":password", $password); 
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":contact", $contact);

    if ($stmt->execute()) {
        echo "<script>window.location.href = 'RegisterSuccess.php';</script>";
    } else {
        echo "<script>alert('Failed to Register, Please try again later!'); window.history.back();</script>";
    }
}
?>
