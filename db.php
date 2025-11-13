<?php
$conn = mysqli_connect("127.0.0.1", "root", "usbw", "resume_simple");


//connection check
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>