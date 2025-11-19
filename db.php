<?php
// LIVE SERVER CREDENTIALS (InfinityFree se jo mila wo yahan daalo)
$host = "sql210.infinityfree.com"; // Aapka Live Hostname
$user = "if0_40456309";             // Aapka Live Username
$pass = "Bk4EVcBWW1tbnX";          // Aapka Panel Password
$db   = "if0_40456309_resume";      // Aapka Live DB Name

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>