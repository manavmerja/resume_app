<?php
include 'db.php';
$id = mysqli_real_escape_string($conn, $_GET['id']);
$sql = "SELECT * FROM resumes JOIN users ON resumes.user_id = users.id WHERE resumes.id='$id'";
$res = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($res);

// Image Path Logic
$img_path = "uploads/" . $data['profile_pic'];
if(!file_exists($img_path) || empty($data['profile_pic'])) {
    $img_path = "https://via.placeholder.com/150"; // Default placeholder
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Resume View</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="icon" type="image/png" href="https://img.icons8.com/fluency/96/resume.png">
    <style>
        body { background: #525659; padding: 20px; }
        .a4-page {
            background: white;
            width: 210mm;
            min-height: 297mm;
            margin: auto;
            padding: 40px;
            box-shadow: 0 0 15px rgba(0,0,0,0.5);
            position: relative;
        }
        .profile-img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #f8f9fa;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        @media print {
            body { background: white; padding: 0; }
            .a4-page { box-shadow: none; margin: 0; width: 100%; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>

<div class="container text-center mb-3 no-print">
    <button onclick="window.print()" class="btn btn-warning fw-bold shadow">🖨 Print / Save PDF</button>
    <a href="index.php" class="btn btn-light ms-2">Back to Dashboard</a>
</div>

<div class="a4-page">
    <div class="row align-items-center border-bottom pb-4 mb-4">
        <div class="col-3 text-center">
            <img src="<?php echo $img_path; ?>" alt="Profile" class="profile-img">
        </div>
        <div class="col-9">
            <h1 class="fw-bold text-uppercase text-dark"><?php echo $data['name']; ?></h1>
            <p class="mb-0 text-muted fs-5">
                📧 <?php echo $data['email']; ?> <br>
                📱 <?php echo $data['phone']; ?>
            </p>
        </div>
    </div>

    <div class="mb-5">
        <h4 class="text-uppercase text-primary border-bottom pb-2 mb-3">🎓 Education</h4>
        <p class="lead fs-6"><?php echo nl2br($data['education']); ?></p>
    </div>

    <div class="mb-5">
        <h4 class="text-uppercase text-primary border-bottom pb-2 mb-3">🛠 Technical Skills</h4>
        <p class="lead fs-6"><?php echo nl2br($data['skills']); ?></p>
    </div>

    <div class="alert alert-light text-center text-muted mt-5 border rounded-pill">
        <small>Generated using Resume Builder • Template: <?php echo $data['template']; ?></small>
    </div>
</div>

</body>
</html>