
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>OTP Verification</title>
        <?php
session_start();
require_once 'db.php';
require_once 'Indexhader.php';

if (isset($_POST['verify'])) {
    if (!isset($_SESSION['otp'])) {
        echo "<script>alert('Session expired. Please request a new OTP.');</script>";
        exit();
    }

    $a = $_POST['otp']; // Trim whitespace
    if ( $a ==  $_SESSION['otp']) {
        $name = $_SESSION["name"];
        $email = $_SESSION["email"];
        $pass = $_SESSION["passkey"];
        $roll = $_SESSION["roll"];
        $jdate = date("Y/m/d");

        $sql = "INSERT INTO tbl_user(Name, Email, Password, Joining_Date, Roll) VALUES ('$name', '$email', '$pass', '$jdate', '$roll')";

        if (mysqli_query($conn, $sql)) {
            header("Location: Login.php");
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('Invalid OTP. Please try again.');</script>";
    }
}

if (isset($_POST['resend'])) {
    require 'smtp.php';

    $otp = random_int(10000, 99999);
    $_SESSION['otp'] = $otp;

    $mail->IsSMTP();
    $mail->CharSet = 'UTF-8';
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPDebug = 0;
    $mail->SMTPAuth = true;
    $mail->Port = 587;
    $mail->Username = "speczone888@gmail.com";
    $mail->Password = "aezkgdzmrolqwvls";

    $mail->setFrom('speczone888@gmail.com', 'SpecZone');
    $mail->addAddress($_SESSION["email"]);
    $mail->isHTML(true);
    $mail->Subject = 'Your OTP for Registration';

    $htmlContent = file_get_contents('otp_template.html');
    $htmlContent = str_replace('{{OTP}}', $otp, $htmlContent);
    $mail->Body = $htmlContent;
    $mail->AltBody = 'Your OTP is: ' . $otp;

    if ($mail->send()) {
        echo "<script>alert('OTP resent successfully.');</script>";
    } else {
        echo "<script>alert('Failed to resend OTP. Please try again later.');</script>";
    }
}
?>
    </head>
    <body>
        <form method="POST">
            <div class="login">
                <div class="container-fluid">
                    <div class="register-form">
                        <h1 class="text-center">OTP Verification</h1>
                        <div class="row">
                            <div class="col-md-6">
                                <label>OTP:</label>
                                <input class="form-control" type="text" name="otp" pattern="\d{5}" placeholder="Enter OTP">
                            </div>
                            <div class="col-md-12">
                                <input type="submit" name="verify" value="Verify" class="btn btn-primary">
                                <input type="submit" name="resend" value="Resend OTP" class="btn btn-secondary">
                            </div>
                        </div>
                    </div><!-- comment -->
                </div>
            </div><!-- comment -->
        </form><!-- comment -->
    </body><!-- comment -->
</html><!-- comment -->

<?php require_once 'Footer.php';?>