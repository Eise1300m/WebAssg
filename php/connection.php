<?php

$_db = new PDO('mysql:dbname=bookshop','root','',[PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,]);
if (!$_db){
    echo"Could not connected!";
}

?>