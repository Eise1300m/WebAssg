<?php

session_start();

require_once("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['CustName'];
    $password = $_POST['pswcfm'];
    $email = $_POST['emails'];
    $contact = $_POST['tel'];

    $check_sql = "SELECT CustUsername FROM customer WHERE CustUsername = ? OR Email = ?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param('ss', $username, $email);
    $stmt->execute();
    $stmt->store_result();


    if ($stmt->num_rows > 0) {

        echo "<script> alert('Username or Email is already registered!')
        ;window.history.back()
        ;</script>";

        $stmt->close();
        exit();
    }
    $stmt->close();


    $insert_sql = "INSERT INTO customer (CustUsername,CustomerPassword, Email, ContactNo) VALUES (?,?,?,?)";
    $stmt = $conn->prepare($insert_sql);
    $stmt->bind_param("ssss", $username, $password, $email, $contact);

    if ($stmt->execute()) {
        echo "<script>window.location.href = 'RegisterSuccess.php';</script>";
    } else {
        echo "<script> alert('Failed to Registered, Please try again later!')
        ;window.history.back()
        ;</script>";    }

    $stmt->close();
}

$conn->close();
