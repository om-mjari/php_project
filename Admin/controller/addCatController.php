<?php
    include_once "../config/dbconnect.php";
    
    if(isset($_POST['upload'])) {
        $catname = $_POST['c_name'];

        // Insert query
        $insert = mysqli_query($conn,"INSERT INTO tbl_category (Name) VALUES ('$catname')");

        // Check if insertion is successful
        if(!$insert) {
            // Log error for debugging
            echo "Error: " . mysqli_error($conn);
        } else {
            echo "Records added successfully.";
            header("location: ../Admin_db.php?category=success");
            exit();
        }
    }
?>
