<?php
session_start();
include 'db.php';

if (isset($_SESSION['id']) && isset($_GET['id'])) {
    $wishlist_id = $_GET['id'];  // Wishlist record ID to remove

    // Delete the product from the wishlist
    $delete_query = "DELETE FROM tbl_wishlist WHERE Id = '$wishlist_id'";

    if ($conn->query($delete_query) === TRUE) {
        header("Location: wishlist1.php");  // Redirect to wishlist page
    } else {
        echo "Error: " . $conn->error;  // Error handling
    }
} else {
    header("Location: login.php");  // Redirect to login if not logged in
}
?>
