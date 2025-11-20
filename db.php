<?php
// Database Configuration
// NOTE: Change these credentials to match your local or live environment
$host = "localhost";      // Ya "YOUR_HOST_HERE"
$user = "root";           // Ya "YOUR_USERNAME_HERE"
$pass = "";               // password 
$db   = "resume_pro";     // Ya "YOUR_DB_NAME_HERE"

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>