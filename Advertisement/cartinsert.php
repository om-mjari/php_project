<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Add to Cart</title>
</head>
<body>
    <?php
    // Include database connection
    include 'db.php';

    // Retrieve and validate inputs
    $id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0; // Product ID
    $uid = isset($_REQUEST['uid']) ? intval($_REQUEST['uid']) : 0; // User ID
    $price = isset($_REQUEST['price']) ? floatval($_REQUEST['price']) : 0.0; // Product Price
    $qua = 1; // Default quantity to 1

    // Check if all required values are valid
    if ($id > 0 && $uid > 0 && $price > 0) {
        // Insert into cart table
        $qq = "INSERT INTO cart (product_id, uid, price, quantity) VALUES ($id, $uid, $price, $qua)";
        $res = mysqli_query($conn, $qq);

        if ($res) {
            echo "<p>Product added to cart successfully!</p>";
            // Optionally redirect to cart page
            // header("Location: cart1.php");
        } else {
            echo "<p>Error adding product to cart: " . mysqli_error($conn) . "</p>";
        }
    } else {
        echo "<p>Invalid product or user information provided.</p>";
    }

    // Close the database connection
    mysqli_close($conn);
    ?>
</body>
</html>
