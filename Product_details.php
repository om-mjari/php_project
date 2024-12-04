<?php
session_start();

include 'db.php';

$id = isset($_GET['pid']) ? intval($_GET['pid']) : 0;
$que = "SELECT 
    m.Name AS Material_Name
FROM 
    tbl_productinfo p
JOIN 
    tbl_material m
ON 
    p.Matirial_Id = m.Id
WHERE 
    p.Id = $id";
$re = mysqli_query($conn, $que);
if ($id > 0) {
    // Fetch product details
    $sql = "SELECT * FROM tbl_productinfo WHERE Id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

//    $material_name = "Unknown"; // Default value in case no material is found
//
//    if ($re->num_rows > 0) {
//        $row = $re->fetch_assoc();
//        $material_name = $row['Name']; // Get the material name
//    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Product Details</title>
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
    </head>

    <body>
      <?php 
      include 'Homehader.php';
      ?>        <!-- Bottom Bar End --> 
        
        <!-- Breadcrumb Start -->
        <div class="breadcrumb-wrap">
            <div class="container-fluid">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="Home.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="ProductList.php">Products</a></li>
                    <li class="breadcrumb-item active">Product Detail</li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumb End -->
        
        <!-- Product Detail Start -->
        <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $image = 'Admin/New/' . $row['Image'];
                    echo '
            <div class="product-detail">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="product-detail-top">
                                <div class="row align-items-center">
                                    <div class="col-md-5">
                                        <div class="product-slider-single normal-slider">
                                            <img src="' . $image . '" alt="' . $row['Product_name'] . '">
                                        </div>
                                   <div class="product-slider-single-nav normal-slider">
                                        <div class="slider-nav-img"><img src="" alt="Product Image"></div>
                                        <div class="slider-nav-img"><img src="Admin/New/3.jpg" alt="Product Image"></div>
                                        <div class="slider-nav-img"><img src="Admin/New/3.jpg" alt="Product Image"></div>
                                        <div class="slider-nav-img"><img src="Admin/New/3.jpg" alt="Product Image"></div>
                                        <div class="slider-nav-img"><img src="Admin/New/3.jpg" alt="Product Image"></div>
                                        <div class="slider-nav-img"><img src="Admin/New/3.jpg" alt="Product Image"></div>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                        <div class="product-content">
                                            <div class="title"><h2>' . $row['Product_name'] . '</h2></div>
                                            <div class="ratting">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </div>
                                            <div class="price">
                                                <h4>Price: </h4>
                                                <p>₹' . $row['Pirce'] . ' <span>₹' . ($row['Pirce'] + 50) . '</span></p>
                                            </div>
                                            <div class="weight">
                                                <h4>Wight: </h4>
                                                <p>' . $row['Weight'] . ' </p>
                                            </div>
                                            <div class="size">
                                                <h4>Size: </h4>
                                                <p>' . $row['Size'] . ' </p>
                                            </div>

                                            <div class="quantity">
                                                <h4>Quantity:</h4>
                                                <div class="qty">
                                                    <button class="btn-minus"><i class="fa fa-minus"></i></button>
                                                    <input type="text" value="1">
                                                    <button class="btn-plus"><i class="fa fa-plus"></i></button>
                                                </div>
                                            </div>
                                            <div class="action">
                                                <a class="btn" href="cartinsert.php?pid=' . $row['Id'] . '&uid=' . $_SESSION['id'] . '&price=' . $row['Pirce'] . '"><i class="fa fa-shopping-cart"></i>Add to Cart</a>
                                                <a class="btn" href="wishlistinsert.php?pid=' . $row['Id'] . '"><i class="fa fa-heart"></i>Add to Wishlist</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
               
                        <div class="row product-detail-bottom">
                            <div class="col-lg-12">
                                <ul class="nav nav-pills nav-justified">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="pill" href="#description">Description</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="pill" href="#specification">Specification</a>
                                    </li>
                                </ul>

                                <div class="tab-content">
                                    <div id="description" class="container tab-pane active">
                                        <h4>Product description</h4>
                                        <p>
                                            '.$row['Description'].'
                                        </p>
                                    </div>
                                    <div id="specification" class="container tab-pane fade">
                                        <h4>Product specification</h4>
                                        <ul>
                                            <li>Lorem ipsum dolor sit amet</li>
                                            <li>Lorem ipsum dolor sit amet</li>
                                            <li>Lorem ipsum dolor sit amet</li>
                                            <li>Lorem ipsum dolor sit amet</li>
                                            <li>Lorem ipsum dolor sit amet</li>
                                        </ul>
                                    </div>
                                    <div id="reviews" class="container tab-pane fade">
                                        <div class="reviews-submitted">
                                            <div class="reviewer">Phasellus Gravida - <span>01 Jan 2020</span></div>
                                            <div class="ratting">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </div>
                                            <p>
                                                Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.
                                            </p>
                                        </div>
                                        <div class="reviews-submit">
                                            <h4>Give your Review:</h4>
                                            <div class="ratting">
                                                <i class="far fa-star"></i>
                                                <i class="far fa-star"></i>
                                                <i class="far fa-star"></i>
                                                <i class="far fa-star"></i>
                                                <i class="far fa-star"></i>
                                            </div>
                                            <div class="row form">
                                                <div class="col-sm-6">
                                                    <input type="text" placeholder="Name">
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="email" placeholder="Email">
                                                </div>
                                                <div class="col-sm-12">
                                                    <textarea placeholder="Review"></textarea>
                                                </div>
                                                <div class="col-sm-12">
                                                    <button>Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>';
                     }
            } else {
                echo '<p>Product not found.</p>';
            }
        } else {
            echo '<p>Invalid product ID.</p>';
        }

        $conn->close();
        ?>
                    <!-- Side Bar Start -->
                  
                    <!-- Side Bar End -->
                </div>
            </div>
        </div>
        <!-- Product Detail End -->
        
        <!-- Brand Start -->
        <div class="brand">
            <div class="container-fluid">
                <div class="brand-slider">
                    <div class="brand-item"><img src="img/brand-1.png" alt=""></div>
                    <div class="brand-item"><img src="img/brand-2.png" alt=""></div>
                    <div class="brand-item"><img src="img/brand-3.png" alt=""></div>
                    <div class="brand-item"><img src="img/brand-4.png" alt=""></div>
                    <div class="brand-item"><img src="img/brand-5.png" alt=""></div>
                    <div class="brand-item"><img src="img/brand-6.png" alt=""></div>
                </div>
            </div>
        </div>
        <!-- Brand End -->
        
   <?php include 'Footer.php';?>
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
