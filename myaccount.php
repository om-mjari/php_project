<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Account Details</title>
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

// Check if the user is logged in
        if (!isset($_SESSION['id'])) {
            // Redirect to login if not logged in
            header("Location: login.php");
            exit;
        }

// Access session variables
        $user_id = $_SESSION['id'];
        $user_email = $_SESSION['email'];
        $user_name = $_SESSION['name'];
        $user_role = $_SESSION['role'];
        include 'db.php';

// Fetch user details from tbl_user
        $qq = "SELECT tbl_user.ID, tbl_user.Name, tbl_user.Email, tbl_user.`Phone_No.`, tbl_user.Date_of_Birth, 
                     tbl_user.Password, tbl_user.Address, tbl_user.City_id, tbl_user.Pincode, tbl_city.Name AS CityName 
              FROM tbl_user 
              LEFT JOIN tbl_city ON tbl_user.City_id = tbl_city.ID 
              WHERE tbl_user.ID = '$user_id'";
        $res = mysqli_query($conn, $qq);

        if (!$res) {
            // If the query fails, show the error message
            die("Query failed: " . mysqli_error($conn));
        }

        while ($result = mysqli_fetch_assoc($res)) {
            $id = $result['ID'];
            $Name = $result['Name'];
            $Email = $result['Email'];
            $Phone_No = $result['Phone_No.'];
            $Date_of_Birth = $result['Date_of_Birth'];
            $Password = $result['Password'];
            $Address = $result['Address'];
            $Cityid = $result['City_id'];
            $Pincode = $result['Pincode'];
        }

// Fetch city name from tbl_city
        if (isset($Cityid)) {
            $qq1 = "SELECT * FROM tbl_city WHERE ID = '$Cityid';";
            $res1 = mysqli_query($conn, $qq1);

            if (!$res1) {
                // If the query fails, show the error message
                die("Query failed: " . mysqli_error($conn));
            }

            while ($result = mysqli_fetch_assoc($res1)) {
                $City = $result['Name'];
            }
        }

// Fetch orders from the database

        $qq2 = "
SELECT 
    b.Total_Amount AS Total_Amount, 
    b.Date AS Date, 
    o.status AS status, 
    p.Product_name AS Product_name
FROM tbl_bill AS b
JOIN tbl_ordercart AS oc ON b.Ordercart_Id = oc.Id
JOIN tbl_order AS o ON oc.Order_Id = o.Id
JOIN tbl_productinfo AS p ON oc.Product_Id = p.Id
WHERE o.User_Id = $user_id";

        $orders_res = mysqli_query($conn, $qq2);

        if (!$orders_res) {
            die("Query failed: " . mysqli_error($conn));
        }


        if (isset($_POST['update_account'])) {
            $user_id = $_SESSION['id'];
            $name = mysqli_real_escape_string($conn, $_POST['name']);
            $phone_no = mysqli_real_escape_string($conn, $_POST['phone_no']);
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $address = mysqli_real_escape_string($conn, $_POST['address']);
            $city_id = mysqli_real_escape_string($conn, $_POST['city_id']);
            $pincode = mysqli_real_escape_string($conn, $_POST['pincode']);

            // Update query
            $update_query = "UPDATE tbl_user SET 
                     Name = '$name', 
                     Phone_No. = '$phone_no', 
                     Email = '$email', 
                     Address = '$address', 
                     City_id = '$city_id', 
                     Pincode = '$pincode'
                     WHERE ID = '$user_id'";

            if (mysqli_query($conn, $update_query)) {
                // If update is successful, redirect to the account page with a success message
                header("Location: myaccount.php?status=success");
                exit;
            } else {
                // If update fails, show an error
                echo "Error updating account: " . mysqli_error($conn);
            }
        }
        ?>


    </head>

    <body>
        <!-- Top bar Start -->
        <?php require_once 'Homehader.php'; ?>
        <!-- Bottom Bar End --> 

        <!-- Breadcrumb Start -->
        <div class="breadcrumb-wrap">
            <div class="container-fluid">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="Home.php">Home</a></li>
                    <li class="breadcrumb-item active">My Account</li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumb End -->

        <!-- My Account Start -->
        <div class="my-account">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3">
                        <div class="nav flex-column nav-pills" role="tablist" aria-orientation="vertical">
                            <a class="nav-link active" id="orders-nav" data-toggle="pill" href="#orders-tab" role="tab"><i class="fa fa-shopping-bag"></i>Orders</a>
                            <a class="nav-link" id="address-nav" data-toggle="pill" href="#address-tab" role="tab"><i class="fa fa-map-marker-alt"></i>Address</a>
                            <a class="nav-link" id="account-nav" data-toggle="pill" href="#account-tab" role="tab"><i class="fa fa-user"></i>Account Details</a>
                            <a class="nav-link" href="index1.php"><i class="fa fa-sign-out-alt"></i>Logout</a>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="tab-content">
                            <!-- Orders Tab -->
                            <div class="tab-pane fade show active" id="orders-tab" role="tabpanel" aria-labelledby="orders-nav">
                                <h4>Your Orders</h4>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>No</th>
                                                <th>Product</th>
                                                <th>Date</th>
                                                <th>Price</th>
                                                <th>Status</th>
                                               
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $order_count = 1;
                                            while ($order = mysqli_fetch_assoc($orders_res)) {
                                                echo "<tr>
        <td>" . $order_count++ . "</td>
        <td>" . $order['Product_name'] . "</td>
        <td>" . $order['Date'] . "</td>
        <td>₹" . $order['Total_Amount'] . "</td>
        <td>" . $order['status'] . "</td>
        
    </tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Address Tab -->
                            <div class="tab-pane fade" id="address-tab" role="tabpanel" aria-labelledby="address-nav">
                                <h4>Address</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5>Shipping Address</h5>
                                        <p><?php echo $Address . ", " . $City . ", " . $Pincode; ?></p>
                                        <p>Mobile: <?php echo $Phone_No; ?></p>
                                        <button class="btn">Edit Address</button>
                                    </div>
                                </div>
                            </div>
                            <!-- Account Details Tab -->
                            <div class="tab-pane fade" id="account-tab" role="tabpanel" aria-labelledby="account-nav">
                                <h4>Account Details</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input class="form-control" type="text" value="<?php echo $Name; ?>" placeholder="First Name" disabled>
                                    </div>
                                    <div class="col-md-6">
                                        <input class="form-control" type="text" value="<?php echo $Phone_No; ?>" placeholder="Mobile" disabled>
                                    </div>
                                    <div class="col-md-6">
                                        <input class="form-control" type="text" value="<?php echo $Email; ?>" placeholder="Email" disabled>
                                    </div>
                                    <div class="col-md-12">
                                        <input class="form-control" type="text" value="<?php echo $Address; ?>" placeholder="Address" disabled>
                                    </div>
                                    <div class="col-md-12">
                                        <select class="form-control" disabled>
                                            <option value="<?php echo $Cityid; ?>"><?php echo $City; ?></option>
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <input class="form-control" type="text" value="<?php echo $Pincode; ?>" placeholder="Pincode" disabled>
                                    </div>
                                    <div class="col-md-12">
                                        <!-- Button to open the modal -->
                                        <button class="btn" data-toggle="modal" data-target="#updateModal">Update Account</button>
                                    </div>
                                </div>

                                <!-- Modal for Account Update -->
                                <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="updateModalLabel">Update Account Details</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="update_account.php" method="POST">
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <input class="form-control" type="text" name="name" value="<?php echo $Name; ?>" placeholder="Name" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input class="form-control" type="text" name="phone_no" value="<?php echo $Phone_No; ?>" placeholder="Mobile" required>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <input class="form-control" type="email" name="email" value="<?php echo $Email; ?>" placeholder="Email" required>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <textarea class="form-control" name="address" placeholder="Address" required><?php echo $Address; ?></textarea>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <select class="form-control" name="city_id" required>
                                                                <?php
                                                                // Fetch cities from the database
                                                                $city_query = "SELECT * FROM tbl_city";
                                                                $city_res = mysqli_query($conn, $city_query);
                                                                while ($city = mysqli_fetch_assoc($city_res)) {
                                                                    echo "<option value='" . $city['ID'] . "' " . ($city['ID'] == $Cityid ? 'selected' : '') . ">" . $city['Name'] . "</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <input class="form-control" type="text" name="pincode" value="<?php echo $Pincode; ?>" placeholder="Pincode" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" name="update_account" class="btn btn-primary">Save Changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                            if (isset($_SESSION['error'])) {
                                echo "<div class='alert alert-danger'>" . $_SESSION['error'] . "</div>";
                                unset($_SESSION['error']);
                            }

                            if (isset($_SESSION['success'])) {
                                echo "<div class='alert alert-success'>" . $_SESSION['success'] . "</div>";
                                unset($_SESSION['success']);
                            }
                            ?>


                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- My Account End -->

        <!-- Footer Start -->
        <?php require_once 'Footer.php'; ?>
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