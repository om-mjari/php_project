<?php
// Include the database connection
require_once 'db.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: Login.php");
    exit;
}

$uid = $_SESSION['id'];

// Fetch cart items for the user
$query = "SELECT cart.id AS cart_id, cart.product_id, cart.price, cart.quantity, 
          tbl_productinfo.Product_Name, tbl_productinfo.Image 
          FROM cart 
          INNER JOIN tbl_productinfo ON cart.product_id = tbl_productinfo.id 
          WHERE cart.uid = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $uid);
$stmt->execute();
$result = $stmt->get_result();
$cart_items = $result->fetch_all(MYSQLI_ASSOC);

// Calculate totals
$sub_total = 0;
foreach ($cart_items as $item) {
    $sub_total += $item['price'] * $item['quantity'];
}

if(isset($_POST['shop'])){
    header('location: ProductList.php');
}
// Handle checkout
if (isset($_POST['checkout'])) {
    // Flag to check if all items are in stock
    $all_in_stock = true;
    $out_of_stock_items = [];

    // Loop through each cart item to validate stock
    foreach ($cart_items as $item) {
        $product_id = $item['product_id'];
        $cart_quantity = $item['quantity'];

        // Fetch the available quantity of the product
        $query = "SELECT Quantity FROM tbl_productinfo WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();

        if ($product['Quantity'] < $cart_quantity) {
            $all_in_stock = false;
            $out_of_stock_items[] = $item['Product_Name'];
        }
    }

    if ($all_in_stock) {
        // Redirect to checkout page if all items are in stock
        header("Location: Home.php.php");
        exit;
    } else {
        // Display an alert if some items are out of stock
        echo "<script>alert('Some items are out of stock: " . implode(", ", $out_of_stock_items) . "');</script>";
    }
}


if(isset($_POST['chack'])){
    $ddd ="select product_id from cart where uid = $uid";
    
    $reqq = mysqli_query($conn, $ddd);
    
    while($ros = mysqli_fetch_assoc($reqq)){
        $re = $ros['product_id'];
    }
    if(isset($re)){
        header("location: chackout.php");
    }else{
        echo "Cart is empty";
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<?php require_once 'Homehader.php'; ?>

<!-- Breadcrumb Start -->
<div class="breadcrumb-wrap">
    <div class="container-fluid">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Products</a></li>
            <li class="breadcrumb-item active">Cart</li>
        </ul>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- Cart Start -->
<form method="post">
<div class="cart-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8">
                <div class="cart-page-inner">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="thead-dark">
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Remove</th>
                            </tr>
                            </thead>
                            <tbody class="align-middle">
                            <?php if (count($cart_items) > 0): ?>
                                <?php foreach ($cart_items as $item): ?>
                                    <tr>
                                        <td>
                                            <div class="img">
                                                <a href="#"><img src="Admin/New/<?= $item['Image'] ?>" alt="Image"></a>
                                                <p><?= $item['Product_Name'] ?></p>
                                            </div>
                                        </td>
                                        <td>₹<?= number_format($item['price'], 2) ?></td>
                                        <td>
                                            <form method="post" action="update_cart.php">
                                                <input type="hidden" name="cart_id" value="<?= $item['cart_id'] ?>">
                                                <div class="qty">
                                                    <button class="btn-minus" name="decrease"><i class="fa fa-minus"></i></button>
                                                    <input type="text" name="quantity" value="<?= $item['quantity'] ?>" readonly>
                                                    <button class="btn-plus" name="increase"><i class="fa fa-plus"></i></button>
                                                </div>
                                            </form>
                                        </td>
                                        <td>₹<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                                        <td>
                                            <form method="post" action="remove_cart_item.php">
                                                <input type="hidden" name="cart_id" value="<?= $item['cart_id'] ?>">
                                                <button class="btn"><i class="fa fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center">Your cart is empty!</td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="cart-page-inner">
                    <div class="cart-summary">
                        <div class="cart-content">
                            <h1>Cart Summary</h1>
                            <p>Sub Total<span>₹<?= number_format($sub_total, 2) ?></span></p>
                            <p>Discount<span>₹0</span></p>
                            <h2>Grand Total<span>₹<?= number_format($sub_total, 2) ?></span></h2>
                        </div>
                        <div class="cart-btn">
                            <button name="shop">Shop more</button>
                            <button name="chack">Chackout</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>

<!-- comment -->
<!-- Cart End -->
<?php include 'Footer.php';?>
<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>