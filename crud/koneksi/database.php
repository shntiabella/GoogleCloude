<?php

//config user database
$localhost = "localhost";
$username = "root";
$password = "250806";
$database = "belajar_crud";

//create connection
$connection = mysqli_connect($localhost, $username, $password, $database);

//check connection
if (!$connection){
    die("connection failed: " . mysqli_connect_error());
}

//echo "connected successfully";

?>