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
</head>
<body class="bg-light">

<div class="container mt-5 mb-5">
    <div class="card shadow-lg mx-auto" style="max-width: 700px;">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">📝 Build Your Resume</h3>
        </div>
        <div class="card-body p-4">
            <form method="post" enctype="multipart/form-data">
                
                <div class="mb-4 text-center">
                    <label class="form-label fw-bold">Profile Photo</label>
                    <input type="file" name="photo" class="form-control" accept="image/*">
                    <small class="text-muted">Recommended: Square JPG/PNG</small>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Resume Title</label>
                        <input type="text" name="title" class="form-control" placeholder="e.g. Java Developer" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Select Template</label>
                        <select name="template" class="form-select">
                            <option value="Simple" <?php if($last_tpl=="Simple") echo "selected"; ?>>Simple</option>
                            <option value="Modern" <?php if($last_tpl=="Modern") echo "selected"; ?>>Modern</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Phone Number</label>
                    <input type="text" name="phone" class="form-control" placeholder="+91 987..." required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Education Details</label>
                    <textarea name="education" class="form-control" rows="3" placeholder="Degree, College, Year"></textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Technical Skills</label>
                    <textarea name="skills" class="form-control" rows="3" placeholder="Enter skills (PHP, HTML, Java...)"></textarea>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" name="save" class="btn btn-success btn-lg">Save Resume</button>
                    <a href="index.php" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>