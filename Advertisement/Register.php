<?php
session_start();
if (isset($_POST['btnreg'])) {
    require_once 'db.php';

    $name = $_POST['name'];
    $em = $_POST['email'];
    $mobile = $_POST['mobile'];
    $pass = $_POST['password'];
    $confirm_pass = $_POST['confirm_password'];

    // Check if the passwords match
    if ($pass !== $confirm_pass) {
        echo "<script>alert('Passwords do not match! Please try again.');</script>";
    } else {
        // Check if email already exists
        $q1 = "SELECT Id FROM tbl_user WHERE Email = ?";
        $stmt = mysqli_prepare($conn, $q1);
        mysqli_stmt_bind_param($stmt, "s", $em);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($res) > 0) {
            echo "<script>alert('User Already Exists');</script>";
        } else {
            require 'smtp.php';

            // Configure SMTP
            $mail->IsSMTP();
            $mail->CharSet = 'UTF-8';
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPDebug = 0;
            $mail->SMTPAuth = true;
            $mail->Port = 587;
            $mail->Username = "speczone888@gmail.com"; // Your email
            $mail->Password = "aezkgdzmrolqwvls"; // App password for SMTP

            // Generate OTP
            $otp = random_int(10000, 99999);
            $_SESSION['otp'] = $otp;

            // Prepare email
            $mail->setFrom('speczone888@gmail.com', 'SpecZone');
            $mail->addAddress($em);
            $mail->isHTML(true);
            $mail->Subject = 'Your OTP for Registration';

            // Fetch OTP Template and replace placeholder
            $htmlContent = file_get_contents('otp_template.html');
            $htmlContent = str_replace('{{OTP}}', $otp, $htmlContent);
            $mail->Body = $htmlContent;
            $mail->AltBody = 'Your OTP is: ' . $otp;

            if ($mail->send()) {
                // Store user details temporarily
                $enc = password_hash($pass, PASSWORD_DEFAULT);
                $_SESSION["name"] = $name;
                $_SESSION["email"] = $em;
                $_SESSION["mobile"] = $mobile;
                $_SESSION["passkey"] = $enc;
                $_SESSION["roll"] = 'C'; // Default customer role

                // Debugging log (remove in production)
                error_log("OTP sent successfully: " . $otp);

                // Redirect to OTP verification page
                header("Location: emailveryfy.php");
                exit();
            } else {
                echo "<script>alert('Failed to send OTP. Please try again later.');</script>";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Register</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <script>
        function validateForm() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            if (password !== confirmPassword) {
                alert('Passwords do not match!');
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
    <?php require_once 'Indexhader.php'; ?>
    <form method="POST" onsubmit="return validateForm();">
        <div class="login">
            <div class="container-fluid">
                <div class="register-form">
                    <h1 class="text-center">Registration</h1>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Name</label>
                            <input class="form-control" type="text" name="name" pattern="[A-Za-z ]{2,}" placeholder="Enter Name" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label>E-mail</label>
                            <input class="form-control" type="email" name="email" placeholder="E-mail" required>
                        </div>
                        <div class="col-md-6">
                            <label>Mobile No</label>
                            <input class="form-control" type="text" name="mobile" pattern="[0-9]{10}" placeholder="Mobile No" required>
                        </div>
                        <div class="col-md-6">
                            <label>Password</label>
                            <input class="form-control" id="password" type="password" name="password" placeholder="Password" required>
                        </div>
                        <div class="col-md-6">
                            <label>Retype Password</label>
                            <input class="form-control" id="confirm_password" type="password" name="confirm_password" placeholder="Retype Password" required>
                        </div>
                        <center>
                        <div class="col-md-12">
                            <input type="submit" name="btnreg" value="Register" class="btn btn-primary btn-block">
                        </div>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <?php require_once 'Footer.php'; ?>
</body>
</html>
