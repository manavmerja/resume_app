<?php
session_start();
include 'db.php';
if (!isset($_SESSION['user_id'])) { header("Location: index.php"); }

$last_tpl = isset($_COOKIE['last_tpl']) ? $_COOKIE['last_tpl'] : 'Simple';

if (isset($_POST['save'])) {
    $uid = $_SESSION['user_id'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $tpl = mysqli_real_escape_string($conn, $_POST['template']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $edu = mysqli_real_escape_string($conn, $_POST['education']);
    $skills = mysqli_real_escape_string($conn, $_POST['skills']);

    // Image Upload Logic
    $profile_pic = "default.png"; // Default if no image uploaded
    if(isset($_FILES['photo']) && $_FILES['photo']['error'] == 0){
        $allowed = ['jpg', 'jpeg', 'png'];
        $filename = $_FILES['photo']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        if(in_array($ext, $allowed)){
            $new_name = "user_" . $uid . "_" . time() . "." . $ext;
            move_uploaded_file($_FILES['photo']['tmp_name'], "uploads/" . $new_name);
            $profile_pic = $new_name;
        }
    }

    setcookie("last_tpl", $tpl, time() + (86400 * 30), "/");

    $sql = "INSERT INTO resumes (user_id, title, template, phone, education, skills, profile_pic) 
            VALUES ('$uid', '$title', '$tpl', '$phone', '$edu', '$skills', '$profile_pic')";
    
    if(mysqli_query($conn, $sql)){
        header("Location: index.php");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Create Resume</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
<link rel="icon" type="image/png" href="https://img.icons8.com/fluency/96/resume.png">
</head>
<body>

<div class="container mt-5 mb-5">
    <div class="glass-card mx-auto p-0" style="max-width: 800px; overflow: hidden;">
        <div class="p-4 border-bottom border-secondary">
            <h3 class="mb-0 text-white">📝 Build Your Resume</h3>
        </div>
        <div class="p-5">
            <form method="post" enctype="multipart/form-data">
                <div class="text-center mb-4">
                    <label class="d-block mb-2 fw-bold text-white-50">Profile Picture</label>
                    <input type="file" name="photo" class="form-control w-50 mx-auto">
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="text-white-50 mb-1">Resume Title</label>
                        <input type="text" name="title" class="form-control" placeholder="e.g. Web Dev Resume">
                    </div>
                    <div class="col-md-6">
                        <label class="text-white-50 mb-1">Template</label>
                        <select name="template" class="form-select text-white">
                            <option value="Simple">Simple</option>
                            <option value="Modern">Modern</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="text-white-50 mb-1">Contact Phone</label>
                    <input type="text" name="phone" class="form-control" placeholder="+91 9876543210">
                </div>

                <div class="mb-3">
                    <label class="text-white-50 mb-1">Education</label>
                    <textarea name="education" class="form-control" rows="3" placeholder="Degree, University, Year"></textarea>
                </div>

                <div class="mb-4">
                    <label class="text-white-50 mb-1">Skills</label>
                    <textarea name="skills" class="form-control" rows="3" placeholder="PHP, Java, MySQL..."></textarea>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="index.php" class="btn btn-outline-light px-4">Cancel</a>
                    <button type="submit" name="save" class="btn btn-primary px-5 rounded-pill">Save Resume</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>