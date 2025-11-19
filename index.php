<?php
session_start();
include 'db.php';

// Backend Logic same as before...
if (isset($_POST['register'])) {
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (name, email, password) VALUES ('$_POST[name]', '$_POST[email]', '$pass')";
    if(mysqli_query($conn, $sql)) echo "<script>alert('Registered!');</script>"; 
    else echo "<script>alert('Email exists!');</script>";
}

if (isset($_POST['login'])) {
    $res = mysqli_query($conn, "SELECT * FROM users WHERE email='$_POST[email]'");
    $row = mysqli_fetch_assoc($res);
    if ($row && password_verify($_POST['password'], $row['password'])) {
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['name'] = $row['name'];
    } else echo "<script>alert('Invalid Credentials');</script>";
}

if (isset($_GET['logout'])) { session_destroy(); header("Location: index.php"); exit; }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Resume Pro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="style.css"> </head>
<body>

<?php if (isset($_SESSION['user_id'])) { ?>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand animate__animated animate__fadeInLeft" href="#">⚡ Resume Pro</a>
            <a href="index.php?logout=true" class="btn btn-danger btn-sm animate__animated animate__fadeInRight">Logout</a>
        </div>
    </nav>

    <div class="container mt-5 text-center">
        <h1 class="display-4 fw-bold animate__animated animate__zoomIn">Welcome, <?php echo $_SESSION['name']; ?></h1>
        <p class="lead text-white-50 animate__animated animate__fadeInUp">Design your future with our professional templates.</p>
        
        <a href="create.php" class="btn btn-primary btn-lg mt-4 px-5 rounded-pill animate__animated animate__pulse animate__infinite">
            + Create New Resume
        </a>

        <div class="mt-5 glass-card p-4 w-75 mx-auto animate__animated animate__fadeInUp">
            <h4 class="mb-4 border-bottom pb-2">My Resumes</h4>
            <div class="list-group list-group-flush">
                <?php
                $uid = $_SESSION['user_id'];
                $res = mysqli_query($conn, "SELECT * FROM resumes WHERE user_id='$uid' ORDER BY id DESC");
                if(mysqli_num_rows($res) > 0) {
                    while ($row = mysqli_fetch_assoc($res)) {
                        echo "<div class='list-group-item d-flex justify-content-between align-items-center'>
                                <span>📄 <strong>{$row['title']}</strong> <small class='ms-2 badge bg-dark'>{$row['template']}</small></span>
                                <div>
                                    <a href='view.php?id={$row['id']}' class='btn btn-sm btn-outline-light'>View</a>
                                    <a href='delete.php?id={$row['id']}' class='btn btn-sm btn-outline-danger ms-2' onclick='return confirm(\"Delete?\")'>X</a>
                                </div>
                              </div>";
                    }
                } else {
                    echo "<p class='text-muted'>No resumes yet.</p>";
                }
                ?>
            </div>
        </div>
    </div>

<?php } else { ?>
    <div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
        <div class="row w-100 justify-content-center">
            
            <div class="col-md-5 d-flex flex-column justify-content-center text-white p-4 animate__animated animate__fadeInLeft">
                <h1 class="display-3 fw-bold">Sacrifice<br><span style="color:#00ffcc">For Success.</span></h1>
                <p class="lead mt-3 text-white-50">Build a resume that stands out. Dark mode enabled for late-night grinders.</p>
            </div>

            <div class="col-md-5">
                <div class="glass-card p-5 animate__animated animate__fadeInRight">
                    <ul class="nav nav-pills nav-fill mb-4" id="pills-tab">
                        <li class="nav-item"><button class="nav-link active text-white" data-bs-toggle="pill" data-bs-target="#login">Login</button></li>
                        <li class="nav-item"><button class="nav-link text-white" data-bs-toggle="pill" data-bs-target="#register">Register</button></li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="login">
                            <form method="post">
                                <div class="mb-3"><input type="email" name="email" class="form-control" placeholder="Email" required></div>
                                <div class="mb-3"><input type="password" name="password" class="form-control" placeholder="Password" required></div>
                                <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="register">
                            <form method="post">
                                <div class="mb-3"><input type="text" name="name" class="form-control" placeholder="Full Name" required></div>
                                <div class="mb-3"><input type="email" name="email" class="form-control" placeholder="Email" required></div>
                                <div class="mb-3"><input type="password" name="password" class="form-control" placeholder="Password" required></div>
                                <button type="submit" name="register" class="btn btn-primary w-100">Sign Up</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
<?php } ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>