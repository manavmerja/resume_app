<?php
session_start();
include 'db.php';
if (!isset($_SESSION['user_id'])) { header("Location: index.php"); }

$last_tpl = isset($_COOKIE['last_tpl']) ? $_COOKIE['last_tpl'] : 'Simple';

if (isset($_POST['save'])) {
    $uid = $_SESSION['user_id'];

    setcookie("last_tpl", $_POST['template'], time() + (86400 * 30), "/");

    $sql = "INSERT INTO resumes (user_id, title, template, phone, education, skills) 
            VALUES ('$uid', '$_POST[title]', '$_POST[template]', '$_POST[phone]', '$_POST[education]', '$_POST[skills]')";
    mysqli_query($conn, $sql);
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Create Resume</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow-lg mx-auto" style="max-width: 700px;">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0"> Build Your Resume</h3>
        </div>
        <div class="card-body p-4">
            <form method="post">
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
                    <textarea name="education" class="form-control" rows="3" placeholder="Enter Degree, College, Year"></textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Technical Skills</label>
                    <textarea name="skills" class="form-control" rows="3" placeholder="Enter skills (PHP, HTML, Java...)"></textarea>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" name="save" class="btn btn-success btn-lg">Save</button>
                    <a href="index.php" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>