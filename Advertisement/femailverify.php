<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        session_start();
        
        require_once 'Indexhader.php';
        
        
        if(isset($_POST['verify'])){
             $a = $_POST['otp'];
            if (isset($_SESSION['sotp']) && $a == $_SESSION['sotp']) {
                $name = $_SESSION["name"];
                $email = $_SESSION["email"];
                $pass = $_SESSION["passkey"];
                $roll = $_SESSION["roll"];
                $jdate = date("Y/m/d");

                require_once 'db.php';

                $sql = "INSERT INTO tbl_user(Name, Email,Password,Joining_Date,Roll) VALUES ('$name','$email','$pass','$jdate','$roll')";

                if (mysqli_query($conn, $sql)) {
                    header("location: login.php");
                } else {
                    echo "Error: ";
                }
            } else {
                echo "<script>alert('OTP Invalid, Enter Valid ');</script>";
            }            
        }
        
        if(isset($_POST['resend'])){
                $mail->IsSMTP();
                $mail->CharSet = 'UTF-8';

                $mail->Host = "smtp.gmail.com";    // SMTP server example
                $mail->SMTPDebug = 0;                     // enables SMTP debug information (for testing)
                $mail->SMTPAuth = true;                  // enable SMTP authentication
                $mail->Port = 587;                    // set the SMTP port for the GMAIL server
                $mail->Username = "speczone888@gmail.com";            // SMTP account username example
                $mail->Password = "aezkgdzmrolqwvls";            // SMTP account password example
// Content
                $mail->setFrom('speczone888@gmail.com');
                $mail->addAddress($_SESSION['email']);
                $otp = random_int(10000, 99999);
                $mail->isHTML(true);                       // Set email format to HTML
//                $mail->Subject = 'OTP for Login';
//                $mail->Body = '<html><head><title></title></head><body>' . $otp . '</body></html>';
//                $mail->AltBody = 'The login otp is for clients registering on system';

                $htmlContent = file_get_contents('otp_template.html');
                $htmlContent = str_replace('{{OTP}}', $otp, $htmlContent);
                $mail->Body = $htmlContent;
                $mail->AltBody = 'The login OTP is: ' . $otp;
                
                $_SESSION['otp'] = $otp;

                if ($mail->send()) {
//                    header("Location: Emailvarification.php");
                } else {

                    echo "<script> alert('INVALID EMAILID'); </script>";
                }

        }
        ?>
        <form method="POST">
        <div class="login">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6">    
                        <div class="register-form">
                            <div class="row">
                                  <div class="col-md-12">
                                      <center><h1> OTP Verification </h1></center>
                                   </div>
                                <div class="col-md-6">
                                    <label>OTP :</label>
                                    <input class="form-control" type="text" name='otp' pattern="{5}"  placeholder="Enter OTP">
                                </div>
                                <div class="col-md-12">
                                    <input type="submit" name="verify" value="Verify" class="btn">
                                    <input type="submit" name="resend" value="Resend OTP" class="btn">
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
