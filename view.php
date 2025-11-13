<?php
include 'db.php';
$id = $_GET['id'];
$sql = "SELECT * FROM resumes JOIN users ON resumes.user_id = users.id WHERE resumes.id='$id'";
$res = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($res);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Resume View</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #525659; padding: 20px; }
        .a4-page {
            background: white;
            width: 210mm;
            min-height: 297mm;
            margin: auto;
            padding: 40px;
            box-shadow: 0 0 15px rgba(0,0,0,0.5);
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
    <button onclick="window.print()" class="btn btn-warning fw-bold shadow"> Print / Save PDF</button>
    <a href="index.php" class="btn btn-light ms-2">Back to Dashboard</a>
</div>

<div class="a4-page">
    <div class="text-center border-bottom pb-3 mb-4">
        <h1 class="fw-bold text-uppercase"><?php echo $data['name']; ?></h1>
        <p class="mb-0 text-muted">
            <?php echo $data['email']; ?> | <?php echo $data['phone']; ?>
        </p>
    </div>

    <div class="mb-5">
        <h4 class="text-uppercase text-primary border-bottom pb-2 mb-3"> Education</h4>
        <p class="lead fs-6"><?php echo nl2br($data['education']); ?></p>
    </div>

    <div class="mb-5">
        <h4 class="text-uppercase text-primary border-bottom pb-2 mb-3"> Technical Skills</h4>
        <p class="lead fs-6"><?php echo $data['skills']; ?></p>
    </div>

    <div class="alert alert-light text-center text-muted mt-5 border rounded-pill">

</div>
</div>

</body>
</html>