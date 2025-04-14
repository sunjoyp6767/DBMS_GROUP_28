<?php
$host = "localhost";
$user = "root";
$password = "";
$db = "meat_based_product"; 

$conn = new mysqli($host, $user, $password, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
