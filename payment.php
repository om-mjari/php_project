<?php
include 'db.php';
session_start();

$sub_total = $_SESSION['subtotal'];
$GST = $_SESSION['GST'];
$grand_total = $_SESSION['grandtotal'];

$API = 'rzp_test_RcQ1BlRnKG4USc';
$amount = $grand_total * 100;

// Query to get the order count
$q = "SELECT COUNT(*) AS order_count FROM tbl_order";
$res = mysqli_query($conn, $q);

// Check if the query was successful
if ($res) {
    $row = mysqli_fetch_assoc($res);
    $c = $row['order_count']; // Get the count from the result set
    $oid = $c + 1; // Calculate the next order ID
} else {
    // Handle query failure
    die("Error fetching order count: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Your Payment</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* High-level design enhancements for the payment page */
        body {
            font-family: 'Open Sans', sans-serif;
            color: #353535;
            background: #f3f6ff;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        h1 {
            font-family: 'Source Code Pro', monospace;
            font-weight: 900;
            text-align: center;
            color: #353535;
            margin: 50px 0;
            font-size: 2.5rem;
        }

        .container {
            width: 90%;
            max-width: 900px;
            margin: 0 auto;
            margin-bottom: 20px;
            text-align: center;
            background: #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            padding: 40px 20px;
        }

        .logo img {
            max-height: 80px;
            margin-bottom: 20px;
            object-fit: contain;
        }

        .btn {
            background-color: #FF6F61;
            color: #fff;
            border: 2px solid #FF6F61;
            font-size: 1.1rem;
            padding: 12px 25px;
            text-transform: uppercase;
            font-weight: 600;
            border-radius: 30px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-block;
            margin-top: 20px;
        }

        .btn:hover {
            background-color: #fff;
            color: #FF6F61;
            border-color: #FF6F61;
            box-shadow: 0 4px 8px rgba(255, 111, 97, 0.3);
        }

        .cancel-btn {
            background-color: transparent;
            border: 2px solid #353535;
            color: #353535;
            font-weight: 600;
            border-radius: 30px;
            padding: 12px 25px;
            margin-top: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .cancel-btn:hover {
            background-color: #353535;
            color: #fff;
            border-color: #353535;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* Responsive Design for Mobile */
        @media (max-width: 768px) {
            .container {
                padding: 30px 15px;
            }

            h1 {
                font-size: 2rem;
                margin-top: 30px;
            }

            .logo img {
                max-height: 60px;
            }
        }
    </style>
</head>
<body>
    <?php include 'Homehader.php';?>
    <div class="container">
        <h1>Complete Your Payment</h1>
        <div class="logo">
            <img src="img/om_1.png" alt="Speczone Logo">
        </div>

        <form action="success.php" method="POST">
            <script
                src="https://checkout.razorpay.com/v1/checkout.js"
                data-key="<?php echo $API; ?>"
                data-amount="<?php echo $amount; ?>"
                data-currency="INR"
                data-id="<?php echo $oid; ?>"
                data-buttontext="Pay with Razorpay"
                data-name="Speczone"
                data-description="Complete your order"
                data-image="img/om_1.png"
                data-theme.color="#FF6F61"
            ></script>
            <input type="hidden" custom="Hidden Element" name="hidden">
        </form>

        <button class="cancel-btn" onclick="window.location.href='cart1.php'">Cancel</button>
    </div>
    <?php include 'Footer.php';?>
</body>
</html>
