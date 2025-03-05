<?php

$name_host = "localhost";
$username = "root";
$password = "";
$database = "secretshelf";


$conn = mysqli_connect($name_host,$username,$password,$database);

if (!$conn){
    echo"Could not connected!";
}


?>