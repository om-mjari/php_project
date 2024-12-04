<?php
session_start();
include 'db.php';
include 'Homehader.php';

// Check if the user is logged in
if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];  // Logged-in user ID
    
    // Query to fetch wishlist products for the logged-in user
    $query = "SELECT p.Product_name, p.Pirce, p.Image, p.Description, p.Id as Product_Id, w.Id as wishlist_id
              FROM tbl_wishlist w
              JOIN tbl_productinfo p ON w.Product_Id = p.Id
              WHERE w.uid = '$user_id'";

    $result = $conn->query($query);
} else {
    header("Location: login.php");  // Redirect to login if not logged in
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Wishlist</title>
    <!-- Include your CSS files and other head elements here -->
</head>

<body>
    <?php require_once 'Homehader.php'; ?>

    <!-- Wishlist Page Content -->
    <div class="wishlist-page">
        <div class="container-fluid">
            <div class="wishlist-page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Description</th>
                                        <th>Add to Cart</th>
                                        <th>Remove</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            $product_image = 'Admin/New/' . $row['Image'];
                                            echo '
                                                <tr>
                                                    <td>
                                                        <div class="img">
                                                            <a href="#"><img src="' . $product_image . '" alt="Image"></a>
                                                            <p>' . $row['Product_name'] . '</p>
                                                        </div>
                                                    </td>
                                                    <td>₹' . $row['Pirce'] . '</td>
                                                    <td>' . $row['Description'] . '</td>
                                                    <td>
                                                        <a href="cartinsert.php?pid=' . $row['Product_Id'] . '&uid=' . $_SESSION['id'] . '&price=' . $row['Pirce'] . '">
                                                            <button class="btn-cart">Add to Cart</button>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="wishlist_remove.php?id=' . $row['wishlist_id'] . '">
                                                            <button><i class="fa fa-trash"></i></button>
                                                        </a>
                                                    </td>
                                                </tr>';
                                        }
                                    } else {
                                        echo '<tr><td colspan="5">Your wishlist is empty.</td></tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require 'Footer.php'; ?>

    <!-- Include your footer and JavaScript files here -->
</body>
</html>
