<?php
    include_once "../config/dbconnect.php";
    
    if(isset($_POST['upload']))
    { 
        $Name = $_POST['name'];
        $Email = $_POST['email'];
        $password = $_POST['password'];
        $enc = password_hash($password, PASSWORD_DEFAULT);
        $pass = $enc;
        $Roll = 'D';
        $salary = $_POST['salary'];
         $jdate = date("Y/m/d");
       
         $insert = mysqli_query($conn,"Insert into tbl_user(Name,Email,Password,Joining_Date,Roll)values ('$Name','$Email','$pass','$jdate','$Roll');");
         
         if(!$insert)
         {
             echo mysqli_error($conn);
             
             header("Location: ../Admin_db.php?size=error");
         }
         else
         {
             $q = "select ID from tbl_user where Email = '$Email' ";
             $res = mysqli_query($conn, $q);
             while ($row = mysqli_fetch_row($res)) {
                 $id = $row[0];
             }
             echo "Records added successfully.";
             $insert1 = "Insert into tbl_dilivery_person(User_ID,Lience_No,Vehicle_No,Salary)values ('$id','0000','00000','$salary')";
             $ress = mysqli_query($conn,$insert1);
             header("Location: ../Admin_db.php?Employee=success");
         }
     
    }
        
?>