<?php
session_start();
include 'db.php';

if (isset($_POST['register'])) {
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (name, email, password) VALUES ('$_POST[name]', '$_POST[email]', '$pass')";
    if(mysqli_query($conn, $sql)) { echo "<script>alert('Registered! Login Now.');</script>"; } 
    else { echo "<script>alert('Email used.');</script>"; }
}

if (isset($_POST['login'])) {
    $res = mysqli_query($conn, "SELECT * FROM users WHERE email='$_POST[email]'");
    $row = mysqli_fetch_assoc($res);
    if ($row && password_verify($_POST['password'], $row['password'])) {
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['name'] = $row['name'];
    } else { echo "<script>alert('Invalid Details');</script>"; }
}

if (isset($_GET['logout'])) { session_destroy(); header("Location: index.php"); exit; }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Resume Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .vh-100-custom { min-height: 100vh; }
        .login-banner {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 50px;
        }
    </style>
</head>
<body>

<?php if (isset($_SESSION['user_id'])) { ?>
    <nav class="navbar navbar-dark bg-dark mb-4"><div class="container"><a class="navbar-brand" href="#">Resume App</a><a href="index.php?logout=true" class="btn btn-danger btn-sm">Logout</a></div></nav>
    <div class="container text-center">
        <h1>Welcome Back, <?php echo $_SESSION['name']; ?>!</h1>
        <p class="lead">Ready to build your next resume?</p>
        <a href="create.php" class="btn btn-primary btn-lg mt-3">+ Create Resume</a>
        <hr class="my-5">
        <h4>My Resumes</h4>
        <div class="list-group w-50 mx-auto">
            <?php
            $uid = $_SESSION['user_id'];
            $res = mysqli_query($conn, "SELECT * FROM resumes WHERE user_id='$uid'");
            while ($row = mysqli_fetch_assoc($res)) {
                echo "<a href='view.php?id=$row[id]' class='list-group-item list-group-item-action'> $row[title] <span class='badge bg-secondary float-end'>Download</span></a>";
            }
            ?>
        </div>
    </div>

<?php } else { ?>
    <div class="container-fluid">
        <div class="row vh-100-custom">
            
            <div class="col-md-6 login-banner d-none d-md-flex">
                <h1 class="display-3 fw-bold">Resume Builder</h1>
                <p class="lead">Create professional resumes in minutes using our secure templates.</p>
                <ul class="list-unstyled mt-4">
                    <li class="mb-2"> Free to use</li>
                    <li class="mb-2"> PDF Download</li>
                    <li class="mb-2"> Secure Login</li>
                </ul>
            </div>

            <div class="col-md-6 bg-white d-flex align-items-center justify-content-center">
                <div style="width: 80%; max-width: 400px;">
                    
                    <ul class="nav nav-pills nav-justified mb-4" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-login-tab" data-bs-toggle="pill" data-bs-target="#pills-login" type="button">Login</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-register-tab" data-bs-toggle="pill" data-bs-target="#pills-register" type="button">Register</button>
                        </li>
                    </ul>

                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-login">
                            <h3 class="mb-3 fw-bold text-primary">Welcome Back</h3>
                            <form method="post">
                                <div class="mb-3"><input type="email" name="email" class="form-control p-3" placeholder="Email Address" required></div>
                                <div class="mb-3"><input type="password" name="password" class="form-control p-3" placeholder="Password" required></div>
                                <button type="submit" name="login" class="btn btn-primary w-100 btn-lg">Login</button>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="pills-register">
                            <h3 class="mb-3 fw-bold text-success">Create Account</h3>
                            <form method="post">
                                <div class="mb-3"><input type="text" name="name" class="form-control p-3" placeholder="Full Name" required></div>
                                <div class="mb-3"><input type="email" name="email" class="form-control p-3" placeholder="Email Address" required></div>
                                <div class="mb-3"><input type="password" name="password" class="form-control p-3" placeholder="Create Password" required></div>
                                <button type="submit" name="register" class="btn btn-success w-100 btn-lg">Register</button>
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