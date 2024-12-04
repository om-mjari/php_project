<?php 
session_start(); 
include 'db.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $em = mysqli_real_escape_string($conn, $_POST['email']);
    $pa = $_POST['password'];

    $q1 = "SELECT ID, Name, Roll, Password FROM tbl_user WHERE Email = ?";
    $stmt = mysqli_prepare($conn, $q1);
    mysqli_stmt_bind_param($stmt, "s", $em);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);

    if ($res && mysqli_num_rows($res) > 0) {
        $user = mysqli_fetch_assoc($res);
        $id = $user['ID'];
        $name = $user['Name'];
        $roll = $user['Roll'];
        $pswd = $user['Password'];

        if (password_verify($pa, $pswd)) {
            $_SESSION['id'] = $id;
            $_SESSION["name"] = $name;
            $_SESSION["email"] = $em;
            $_SESSION["roll"] = $roll;

            if ($roll == 'A') {
                header("Location: Admin_db.php");
            } elseif ($roll == 'C') {
                header("Location: Home.php");
            }
            exit;
        } else {
            echo "<script>alert('Wrong Password');</script>";
        }
    } else {
        echo "<script>alert('User Does Not Exist');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Login</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="img/favicon.ico" rel="icon">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <?php require_once 'Indexhader.php'; ?>

    <div class="breadcrumb-wrap">
        <div class="container-fluid">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Login</li>
            </ul>
        </div>
    </div>

    <form method="POST">
        <div class="login">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="login-form">
                            <div class="row">
                                <div class="col-md-12">
                                    <h1>Login</h1>
                                </div>
                                <div class="col-md-6">
                                    <label>E-mail / Username</label>
                                    <input class="form-control" type="email" name="email" placeholder="E-mail" required>
                                </div>
                                <div class="col-md-6">
                                    <label>Password</label>
                                    <input class="form-control" type="password" name="password" placeholder="Password" required>
                                </div>

                                <div class="col-md-12">
                                    <input type="submit" value="Log in" name="login" class="btn">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <?php require_once 'Footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>
