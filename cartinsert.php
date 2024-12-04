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
    $id = isset($_REQUEST['pid']) ? intval($_REQUEST['pid']) : 0; // Product ID
    $uid = isset($_REQUEST['uid']) ? intval($_REQUEST['uid']) : 0; // User ID
    $price = isset($_REQUEST['price']) ? floatval($_REQUEST['price']) : 0.0; // Product Price
    $qua = 1; // Default quantity to 1

    // Check if all required values are valid
    if ($id > 0 && $uid > 0 && $price > 0) {
        // Insert into cart table
        $q2 = "select product_id from cart where uid = $uid ";
        
        $res2 = mysqli_query($conn, $q2);
        while($result = mysqli_fetch_assoc($res2)){
            $pid = $result['product_id'];
        }
        
        if($pid == $id){
            $que = $qua+1;
           
                $q3 ="update cart set quantity = $que where uid = '$uid'";
           
           $res3 = mysqli_query($conn, $q3);
           header("Location: cart1.php");
            
           
        }else{
            
        $qq = "INSERT INTO cart (product_id, uid, price, quantity) VALUES ($id, $uid, $price, $qua)";
        $res = mysqli_query($conn, $qq);

        if ($res) {
            //echo "<p>Product added to cart successfully!</p>";
            // Optionally redirect to cart page
            header("Location: cart1.php");
        } else {
            echo "<p>Error adding product to cart: " . mysqli_error($conn) . "</p>";
        }
    } 
    }else {
        echo "<p>Invalid product or user information provided.</p>";
    }
    
    // Close the database connection
    mysqli_close($conn);
    ?>
</body>
</html>