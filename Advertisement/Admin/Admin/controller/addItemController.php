<?php
    include_once "../config/dbconnect.php";
    
    if(isset($_POST['upload']))
    {
       
        $ProductName = $_POST['p_name'];
        $desc= $_POST['p_desc'];
        $price = $_POST['p_price'];
        $category = $_POST['category'];
        $color = $_POST['color'];
        $age = $_POST['age'];
        $suit = $_POST['suit'];
        $shape = $_POST['shape'];
        $material = $_POST['material'];
        $brand = $_POST['brand'];
        $gen = $_POST['gender'];
        $qun = $_POST['p_quantity'];
        $weight = $_POST['p_weight'];
        $size = $_POST['p_size'];
       
            
        $name = $_FILES['file']['name'];
        $temp = $_FILES['file']['tmp_name'];
    
        $location="./New/";
        $image=$name;

        $target_dir="../New/";
        $finalImage=$target_dir.$name;

        move_uploaded_file($temp,$finalImage);

         $insert = mysqli_query($conn,"INSERT INTO tbl_productinfo
         (Product_name,Image,pirce,Description,Category_Id,Weight,Color_Id ,Matirial_Id ,Quantity,Size,Gender,Age_Id ,Shape_Id ,Suits_Id ,Brand_Id ) 
         VALUES ('$ProductName','$image',$price,'$desc','$category',$weight,$color,$material,$qun,$size,'$gen',$age,$shape,$suit,$brand)");
 
         if(!$insert)
         {
             echo mysqli_error($conn);
         }
         else
         {
             echo "Records added successfully.";
            header("location: ../Admin_db.php");
            exit();
         }
     
    }
        
?>