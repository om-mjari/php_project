<?php
// Start the session
session_start();

// Include the database connection file
include 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit;
}

// Process the form data if the update_account form is submitted
if (isset($_POST['update_account'])) {
    // Get user ID from session
    $user_id = $_SESSION['id'];

    // Sanitize and retrieve form inputs
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone_no = mysqli_real_escape_string($conn, $_POST['phone_no']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $city_id = mysqli_real_escape_string($conn, $_POST['city_id']);
    $pincode = mysqli_real_escape_string($conn, $_POST['pincode']);

    // Validate required fields
    if (empty($name) || empty($phone_no) || empty($email) || empty($address) || empty($city_id) || empty($pincode)) {
        $_SESSION['error'] = "All fields are required.";
        header("Location: myaccount.php");
        exit;
    }

    // Update query to update user details
    $update_query = "UPDATE tbl_user SET 
                     Name = '$name', 
                     `Phone_No.` = '$phone_no', 
                     Email = '$email', 
                     Address = '$address', 
                     City_id = '$city_id', 
                     Pincode = '$pincode'
                     WHERE ID = '$user_id';";

    // Execute the query
    if (mysqli_query($conn, $update_query)) {
        // If successful, set success message and redirect
        $_SESSION['success'] = "Account details updated successfully.";
        header("Location: myaccount.php");
        exit;
    } else {
        // If failed, set error message
        $_SESSION['error'] = "Error updating account: " . mysqli_error($conn);
        header("Location: myaccount.php");
        exit;
    }
} else {
    // If accessed without form submission, redirect to account page
    header("Location: myaccount.php");
    exit;
}
?>
