<?php
session_start();
include 'db.php';

if (isset($_SESSION['id']) && isset($_GET['pid'])) {
    $user_id = $_SESSION['id'];  // Logged-in user ID
    $product_id = $_GET['pid'];   // Product ID passed in URL

    // Check if the product is already in the wishlist
    $check_query = "SELECT * FROM tbl_wishlist WHERE uid = '$user_id' AND Product_Id = '$product_id'";
    $check_result = $conn->query($check_query);
    
    if ($check_result->num_rows == 0) {
        // Insert the product into the wishlist table
        $insert_query = "INSERT INTO tbl_wishlist (uid, Product_Id) VALUES ('$user_id', '$product_id')";
        
        if ($conn->query($insert_query) === TRUE) {
            header("Location: wishlist1.php");  // Redirect to the wishlist page
        } else {
            echo "Error: " . $conn->error;  // Error handling
        }
    } else {
        // If product is already in the wishlist, redirect to wishlist page
        header("Location: wishlist1.php");
    }
} else {
    header("Location: login.php");  // Redirect to login if not logged in
}
?>
