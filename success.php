<?php
session_start();

// Database configuration
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'speczone';

// Database connection
$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch session variables
$uid = intval($_SESSION['id']);
$sub_total = floatval($_SESSION['subtotal']);
$GST = floatval($_SESSION['GST']);
$grand_total = floatval($_SESSION['grandtotal']);
$payment_method = 'Online'; // Example: Assuming payment method is Online

try {
    // Get current date
    $date = date('Y-m-d H:i:s');

    // Insert into tbl_order
    $order_sql = "INSERT INTO tbl_order (User_Id, Ostatus) VALUES ($uid, 1)";
    if (!$conn->query($order_sql)) {
        throw new Exception("Error inserting into tbl_order: " . $conn->error);
    }
    $order_id = $conn->insert_id;

    // Fetch cart data for the user
    $cart_query = "SELECT product_id, quantity FROM cart WHERE uid = $uid";
    $cart_result = $conn->query($cart_query);
    if (!$cart_result) {
        throw new Exception("Error fetching cart data: " . $conn->error);
    }

    // Insert data into tbl_ordercart
    while ($row = $cart_result->fetch_assoc()) {
        $product_id = intval($row['product_id']);
        $quantity = intval($row['quantity']);
        $ordercart_sql = "INSERT INTO tbl_ordercart (Order_Id, Product_Id, Quantity, date) 
                          VALUES ($order_id, $product_id, $quantity, '$date')";
        if (!$conn->query($ordercart_sql)) {
            throw new Exception("Error inserting into tbl_ordercart: " . $conn->error);
        }
    }

    // Calculate total quantity from cart
    $quantity_query = "SELECT COUNT(product_id) AS total_quantity FROM cart WHERE uid = $uid";
    $quantity_result = $conn->query($quantity_query);
    if (!$quantity_result) {
        throw new Exception("Error fetching total quantity: " . $conn->error);
    }
    $quantity_row = $quantity_result->fetch_assoc();
    $total_quantity = intval($quantity_row['total_quantity']);

    // Insert into tbl_bill
    // Insert data into tbl_ordercart and retrieve its ID
    $cart_query = "SELECT product_id, quantity FROM cart WHERE uid = $uid";
    $cart_result = $conn->query($cart_query);
    if (!$cart_result) {
        throw new Exception("Error fetching cart data: " . $conn->error);
    }

    $ordercart_ids = []; // To store generated IDs from tbl_ordercart
    while ($row = $cart_result->fetch_assoc()) {
        $product_id = intval($row['product_id']);
        $quantity = intval($row['quantity']);
        $ordercart_sql = "INSERT INTO tbl_ordercart (Order_Id, Product_Id, Quantity, date) 
                      VALUES ($order_id, $product_id, $quantity, '$date')";
        if (!$conn->query($ordercart_sql)) {
            throw new Exception("Error inserting into tbl_ordercart: " . $conn->error);
        }
        $ordercart_ids[] = $conn->insert_id; // Store the generated ID
    }

// Use the first generated Ordercart_Id for tbl_bill (assuming a 1-to-1 relationship)
    if (empty($ordercart_ids)) {
        throw new Exception("No items found in cart to generate a bill.");
    }

    $first_ordercart_id = $ordercart_ids[0]; // Use the first Ordercart_Id
    $bill_sql = "INSERT INTO tbl_bill (Ordercart_Id, Total_Quantity, Total_Amount, Payment_Method, Date, GST, Grant_Amount) 
             VALUES ($first_ordercart_id, $total_quantity, $sub_total, '$payment_method', '$date', $GST, $grand_total)";
    if (!$conn->query($bill_sql)) {
        throw new Exception("Error inserting into tbl_bill: " . $conn->error);
    }
    $bill_id = $conn->insert_id;
    $_SESSION['bid'] = $bill_id;

    // Re-fetch the cart data for stock updates
    $cart_result = $conn->query("SELECT product_id, quantity FROM cart WHERE uid = $uid");
    if (!$cart_result) {
        throw new Exception("Error fetching cart data for stock update: " . $conn->error);
    }

    // Update product quantities in the inventory
    while ($row = $cart_result->fetch_assoc()) {
        $product_id = intval($row['product_id']);
        $quantity = intval($row['quantity']);

        // Fetch current stock
        $stock_query = "SELECT Quantity FROM tbl_productinfo WHERE Id = $product_id";
        $stock_result = $conn->query($stock_query);
        if ($stock_result && $stock_row = $stock_result->fetch_assoc()) {
            $current_stock = intval($stock_row['Quantity']);
            $new_stock = $current_stock - $quantity;

            // Update stock
            $update_stock_sql = "UPDATE tbl_productinfo SET Quantity = $new_stock WHERE Id = $product_id";
            if (!$conn->query($update_stock_sql)) {
                throw new Exception("Error updating stock: " . $conn->error);
            }
        } else {
            throw new Exception("Error fetching product stock: " . $conn->error);
        }
    }

    // Delete user's cart after processing order
    $delete_cart_sql = "DELETE FROM cart WHERE uid = $uid";
    if (!$conn->query($delete_cart_sql)) {
        throw new Exception("Error deleting cart: " . $conn->error);
    }

    // Display success message
    ?>
    <!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Payment Successful</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f9f9f9;
                    color: #333;
                    text-align: center;
                    padding: 20px;
                }
                .container {
                    max-width: 600px;
                    margin: 50px auto;
                    background: #fff;
                    padding: 20px;
                    border-radius: 8px;
                    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                }
                .success {
                    color: #4CAF50;
                    font-size: 24px;
                    font-weight: bold;
                }
                .details {
                    margin-top: 20px;
                    text-align: left;
                }
                .details h3 {
                    margin-bottom: 10px;
                }
                .button {
                    margin-top: 20px;
                }
                .button a {
                    text-decoration: none;
                    background: #4CAF50;
                    color: #fff;
                    padding: 10px 20px;
                    border-radius: 5px;
                    font-weight: bold;
                }
                .button a:hover {
                    background: #45a049;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <h1 class="success">Payment Successful!</h1>
                <p>Thank you for your purchase.</p>
                <div class="details">
                    <h3>Order Details:</h3>
                    <p>Order ID: <?php echo $order_id; ?></p>
                    <p>Total Products: <?php echo $total_quantity; ?></p>
                    <p>Total Payment: ₹<?php echo number_format($grand_total, 2); ?></p>
                </div>
                <div class="button">
                    <a href="Home.php">Back to Home</a>
                </div>
                <div class="button">
                    <a href="invoice.php">View Bill</a>
                </div>
            </div>
        </body>
    </html>
    <?php
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
$conn->close();

exit;
?>
