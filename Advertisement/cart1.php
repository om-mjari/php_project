<?php
// Include the database connection
require_once 'db.php'; // Include your database connection script
session_start();

// Check if the user is logged in
if (!isset($_SESSION['uid'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

$uid = $_SESSION['uid'];

// Fetch cart items for the user
$query = "SELECT cart.id AS cart_id, cart.product_id, cart.price, cart.quantity, 
          products.name, products.image 
          FROM cart 
          INNER JOIN products ON cart.product_id = products.id 
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Cart</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="eCommerce HTML Template Free Download" name="keywords">
    <meta content="eCommerce HTML Template Free Download" name="description">

    <!-- CSS and Libraries -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
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
                                                <a href="#"><img src="<?= $item['image'] ?>" alt="Image"></a>
                                                <p><?= $item['name'] ?></p>
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
                            <button onclick="window.location.href='ProductList.php'">Update Cart</button>
                            <button onclick="window.location.href='Checkout.php'">Checkout</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Cart End -->

<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>
