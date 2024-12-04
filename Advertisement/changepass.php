<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Change password</title>
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
        <?php
        include 'Indexhader.php';
        ?>
        <form method="POST" onsubmit="return validateForm();">
        <div class="login">
            <div class="container-fluid">
                <div class="register-form">
                    <h1 class="text-center">Change password</h1>
                    <div class="row">
                       
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
                            <input type="submit" name="btnreg" value="Change password" class="btn btn-primary btn-block">
                        </div>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </form>
        <?php
        include 'Footer.php';
        ?>
    </body>
</html>
