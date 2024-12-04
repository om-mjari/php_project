<?php

// Database Connection
$server = "localhost";
$user = "root";
$password = "";
$db = "speczone";

$conn = mysqli_connect($server, $user, $password, $db);

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

// Update User Details
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
//    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];

    $query = "UPDATE tbl_user SET 
                Name = '$name', 
                Email = '$email', 
//                Phone_No. = '$phone', 
                Gender = '$gender', 
                Date_of_Birth = '$dob' 
              WHERE ID = $id";

    if (mysqli_query($conn, $query)) { {
            echo "Records updated successfully.";
            header("location: ../Admin_db.php");
            exit();
        }
    } else {
        echo "Error updating profile: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
