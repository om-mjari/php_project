<?php
session_start();  // Start session at the beginning
require_once 'db.php';

if (isset($_POST['login'])) {
    // Get the user input
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    // Validate input
    if (empty($email) || empty($password)) {
        echo "<script>alert('Please enter both email and password.');</script>";
    } else {
        // Query to check user credentials
        if ($email == 'admin123@gmail.com') {
            if($password == 'Admin123@'){
                header("location: Admin/Admin_db.php");
            }
            
        } else {
            $query = "SELECT Id, Name, Email, Roll, Password FROM tbl_user WHERE Email = ?";
            $stmt = $conn->prepare($query);

            // Check if the query preparation succeeded
            if ($stmt === false) {
                die("Error preparing query: " . $conn->error);
            }

            // Bind parameters and execute
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $result = $stmt->get_result();

            // Check if the user exists
            if ($result->num_rows === 1) {
                // Fetch user data
                $user = $result->fetch_assoc();

                // Verify the password
                if (password_verify($password, $user['Password'])) {
                    // Set session variables
                    $_SESSION['id'] = $user['Id'];
                    $_SESSION['email'] = $user['Email'];
                    $_SESSION['name'] = $user['Name'];
                    $_SESSION['role'] = $user['Roll'];

                    // Redirect based on role
                    if ($user['Roll'] === 'A') {
                        // Admin dashboard
                        header("Location: admin_db.php");
                        exit();
                    } elseif ($user['Roll'] === 'C') {
                        // Customer homepage
                        header("Location: Home.php");
                        exit();
                    } else {
                        echo "<script>alert('Unknown role.');</script>";
                    }
                } else {
                    echo "<script>alert('Invalid password.');</script>";
                }
            } else {
                echo "<script>alert('User not found.');</script>";
            }
        }
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

        <form method="post">
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
                                    <a href="forgot.php">Forget Password </a>
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
