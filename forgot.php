<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Forgot Password</title>
        <?php
session_start();
if (isset($_POST['forget'])) {
    require_once 'db.php';

    
    $em = $_POST['email'];
    

    // Check if the passwords match
 
        // Check if email already exists
        $q1 = "SELECT Id FROM tbl_user WHERE Email = ?";
        $stmt = mysqli_prepare($conn, $q1);
        mysqli_stmt_bind_param($stmt, "s", $em);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($res) < 0) {
            echo "<script>alert('User not Exists');</script>";
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
                header("Location: femailveryfy.php");
                exit();
            } else {
                echo "<script>alert('Failed to send OTP. Please try again later.');</script>";
            }
        }
    }

?>
    </head>
    <body>
        <?php
       require_once 'Indexhader.php';
        ?>
        
         <form method="POST">
        <div class="login">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="login-form">
                            <div class="row">
                                <div class="col-md-12">
                                    <h1>Forgot Password</h1>
                                </div>
                                <div class="col-md-6">
                                    <label>E-mail / Username</label>
                                    <input class="form-control" type="email" name="email" placeholder="E-mail" required>
                                </div>
                                
                                
                                <div class="col-md-12">
                                    <input type="submit" value="Send OTP" name="forget" class="btn">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
         <?php
       require_once 'Footer.php';
        ?>
    </body>
</html>
