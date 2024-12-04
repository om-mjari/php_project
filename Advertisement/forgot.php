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
