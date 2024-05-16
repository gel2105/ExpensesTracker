<?php

$servername = "localhost";
$port = "3306"; 
$username = "root";
$password = "";
$db_name = "ipt101";

// Create connection
$con = new mysqli($servername, $username, $password, $db_name);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
?>
