<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Chackout</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="eCommerce HTML Template Free Download" name="keywords">
        <meta content="eCommerce HTML Template Free Download" name="description">

        <!-- Favicon -->
        <link href="img/favicon.ico" rel="icon">

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400|Source+Code+Pro:700,900&display=swap" rel="stylesheet">

        <!-- CSS Libraries -->
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
        <link href="lib/slick/slick.css" rel="stylesheet">
        <link href="lib/slick/slick-theme.css" rel="stylesheet">

        <!-- Template Stylesheet -->
        <link href="css/style.css" rel="stylesheet">
        <?php
        session_start();
        $server = "localhost";
        $user = "root";
        $password = "";
        $db = "speczone";

        $conn = mysqli_connect($server, $user, $password, $db);

        if (!$conn) {
            die("Connection Failed: " . mysqli_connect_error());
        }



// Check if user is logged in
        if (!isset($_SESSION['id'])) {
            die("User not logged in.");
        }
        $uid = $_SESSION['id'];

// Fetch user details for billing
        $query_user = "SELECT Name, Email, `Phone_No.`, Address, City_id, Pincode FROM tbl_user WHERE Id = ?";
        $stmt_user = $conn->prepare($query_user);
        if ($stmt_user === false) {
            die("Error in query: " . $conn->error);
        }
        $stmt_user->bind_param('i', $uid);
        $stmt_user->execute();
        $user_result = $stmt_user->get_result();
        $user_data = $user_result->fetch_assoc();

// Fetch cart details
        $query_cart = "SELECT cart.product_id, cart.price, cart.quantity, tbl_productinfo.Product_name 
               FROM cart 
               INNER JOIN tbl_productinfo ON cart.product_id = tbl_productinfo.Id 
               WHERE cart.uid = ?";
        $stmt_cart = $conn->prepare($query_cart);
        if ($stmt_cart === false) {
            die("Error in query: " . $conn->error);
        }
        $stmt_cart->bind_param('i', $uid);
        $stmt_cart->execute();
        $cart_result = $stmt_cart->get_result();
        $cart_items = $cart_result->fetch_all(MYSQLI_ASSOC);

// Calculate totals
        $sub_total = 0;
        foreach ($cart_items as $item) {
            $sub_total += $item['price'] * $item['quantity'];
        }
        $GST = ($sub_total*12)/100; // Flat shipping cost
        $grand_total = $sub_total + $GST;
        $_SESSION['subtotal'] = $sub_total;
        $_SESSION['GST'] = $GST;
        $_SESSION['grandtotal'] = $grand_total;
        
        
         
        if(isset($_POST['plo'])){
            $contact = $_POST['billing_mobile'];
            $address = $_POST['billing_address'];
            $city = $_POST['billing_city'];
            $pincode = $_POST['billing_pincode'];
            $payment = $_POST['payment'];
            
            $up = "update tbl_user set Phone_No.=$contact,Address='$address',City_id='$city',Pincode=$pincode where ID = $uid";
            
            $upq = mysqli_query($conn,$up);
            
            header("Location: payment.php");
        }
        ?>


    </head>

    <body>
        <!-- Top bar Start -->
        <?php include 'Homehader.php'; ?>
        <!-- Bottom Bar End --> 

        <!-- Breadcrumb Start -->
        <div class="breadcrumb-wrap">
            <div class="container-fluid">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="Home.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="Cart1.php">Cart</a></li>
                    <li class="breadcrumb-item active">Checkout</li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumb End -->

        <!-- Checkout Start -->
        <form method="post">
        <div class="checkout">
            <div class="container-fluid"> 
                <div class="row">
                    <div class="col-lg-8">
                        <div class="checkout-inner">
                            <div class="billing-address">
                                <h2>Billing Address</h2>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Name</label>
                                        <input class="form-control" type="text" name="billing_name" value="<?= $user_data['Name'] ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Email</label>
                                        <input class="form-control" type="text" name="billing_email" value="<?= $user_data['Email'] ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Mobile No</label>
                                        <input class="form-control" type="text" name="billing_mobile" value="<?= $user_data['Phone_No.'] ?>" required>
                                    </div>
                                    <div class="col-md-12">
                                        <label>Address</label>
                                        <input class="form-control" type="text" name="billing_address" value="<?= $user_data['Address'] ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label>City</label>
                                        <input class="form-control" type="text" name="billing_city" value="<?= $user_data['City_id'] ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Pincode</label>
                                        <input class="form-control" type="text" name="billing_pincode" value="<?= $user_data['Pincode'] ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Payment Method</label> <br>
                                        <input type="Radio" name="payment" value="Cod" required>Cod
                                        <input type="Radio" name="payment" value="Online" required>Online
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="checkout-summary">
                                <h1>Cart Total</h1>
                                <?php foreach ($cart_items as $item): ?>
                                    <p><?= $item['Product_name'] ?>: <span><?= $item['price'] * $item['quantity'] ?></span></p>
                                <?php endforeach; ?>
                                <p class="sub-total">Sub Total: <span><?= $sub_total; ?></span></p>
                                <p class="ship-cost">GST: <span><?= $GST; ?></span></p>
                                <h2>Grand Total: <span><?= $grand_total; ?></span></h2>
                            </div>
                        </div>

                        <div class="checkout-payment">
                            
                            <div class="checkout-btn">
                                <button name="plo">Place Order</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
        
    <!-- Checkout End -->

    <?php include 'Footer.php'; ?>
    <!-- Footer Bottom End -->     

    <!-- Back to Top -->
    <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/slick/slick.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>
</html>