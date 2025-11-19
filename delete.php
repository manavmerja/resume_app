<?php
session_start();
include 'db.php';

if(isset($_GET['id']) && isset($_SESSION['user_id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $uid = $_SESSION['user_id'];

    // Security: Only allow deleting own resume
    $sql = "DELETE FROM resumes WHERE id='$id' AND user_id='$uid'";
    
    if(mysqli_query($conn, $sql)) {
        header("Location: index.php?msg=deleted");
    } else {
        echo "Error deleting record.";
    }
} else {
    header("Location: index.php");
}
?>