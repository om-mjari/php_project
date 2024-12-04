<?php
session_start();
include 'db.php';
include 'Homehader.php';

// Fetch featured products
$query = "SELECT * FROM tbl_productinfo LIMIT 4";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>specZone-index</title>
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
        <script>
            window.embeddedChatbotConfig = {
                chatbotId: "Nbdo4BvEYbwU7VRXrshlL",
                domain: "www.chatbase.co"
            }
        </script>
        <script
            src="https://www.chatbase.co/embed.min.js"
            chatbotId="Nbdo4BvEYbwU7VRXrshlL"
            domain="www.chatbase.co"
            defer>
        </script>
    </head>

    <body>
        <?php require_once 'Homehader.php'; ?>
        <!-- Main Slider Start -->
        <!-- Brand Start -->
        <!-- Feature Start-->
        <!-- Category Start-->
        <?php require_once 'fristcategory.php'; ?>
        <!-- Category End-->    
        <!-- Feature End-->      
        <!-- Brand End -->  
        <!-- Main Slider End -->         

        <!-- Latest Product Start -->
        <!-- Featured Product Start -->
        <div class="featured-product product">
            <div class="container-fluid">
                <div class="section-header">
                    <h1>Featured Product</h1>
                </div>
                <div class="row align-items-center product-slider product-slider-4">
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $image = 'Admin/New/' . $row['Image'];
                            echo '
                        <div class="col-lg-3">
                            <div class="product-item">
                                <div class="product-title">
                                    <a href="#">' . $row['Product_name'] . '</a>
                                    <div class="ratting">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                </div>
                                <div class="product-image">
                                    <a href="Product_detail.php">
                                        <img src="' . $image . '" alt="' . $row['Product_name'] . '">
                                    </a>
                                    <div class="product-action">';
                            if (isset($_SESSION['id'])) {
                                echo '
                                        <a href="cartinsert.php?pid=' . $row['Id'] . '&uid=' . $_SESSION['id'] . '&price=' . $row['Pirce'] . '">
                                            <i class="fa fa-cart-plus"></i>
                                        </a>
                                    ';
                            } else {
                                echo '
                                        <a href="login.php"><i class="fa fa-cart-plus"></i></a>
                                    ';
                            }
                            echo '<a href="wishlistinsert.php?pid=' . $row['Id'] . '"><i class="fa fa-heart"></i></a>
                                            </div>
                                        </div>
                                        <div class="product-description">
                                            <p>' . $row['Description'] . '</p>
                                        </div>
                                        <div class="product-price">
                                            <h3><span>₹</span>' . $row['Pirce'] . '</h3>
                                            <form method="post" action="cart1.php">
                                                <input type="hidden" name="product_id" value="' . $row['Id'] . '">
                                                <input type="hidden" name="price" value="' . $row['Pirce'] . '">
                                                <a href="Product_details.php?pid=' . $row['Id'] . '" class="btn">
                                            <i class="fa fa-shopping-cart"></i> view Details
                                        </a>
                                            </form>
                                        </div>
                                    </div>
                                </div>';
                        }
                    } else {
                        echo '<p>No products available</p>';
                    }
                    ?>
                </div>
            </div>
        </div>
        <!-- Latest Product End -->




        <?php require 'Footer.php'; ?>
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
