<!DOCTYPE html>
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

// Fetch products based on category if set
$category = isset($_GET['category']) ? $_GET['category'] : '';
$sql = $category ? "SELECT * FROM tbl_productinfo WHERE category = ?" : "SELECT * FROM tbl_productinfo";
$stmt = $conn->prepare($sql);
if ($category) {
    $stmt->bind_param("s", $category);
}
$stmt->execute();
$result = $stmt->get_result();
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>E Store - eCommerce HTML Template</title>
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
            // Function to fetch search results dynamically
            function searchProducts(query) {
                if (query.trim() === "") {
                    document.getElementById("data").innerHTML = "<p>Please enter a search term.</p>";
                    return;
                }
                var xhr = new XMLHttpRequest();
                xhr.open("GET", "search_products.php?q=" + query, true);
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        document.getElementById("data").innerHTML = xhr.responseText;
                    }
                };
                xhr.send();
            }
        </script>
    </head>

    <body>
        <!-- Top bar Start -->
        <div class="top-bar">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <i class="fa fa-envelope"></i>
                        support@email.com
                    </div>
                    <div class="col-sm-6">
                        <i class="fa fa-phone-alt"></i>
                        +012-345-6789
                    </div>
                </div>
            </div>
        </div>
        <!-- Top bar End -->

        <!-- Nav Bar Start -->
        <div class="nav">
            <div class="container-fluid">
                <nav class="navbar navbar-expand-md bg-dark navbar-dark">
                    <a href="#" class="navbar-brand">MENU</a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto">
                            <a href="index.html" class="nav-item nav-link">Home</a>
                            <a href="product-list.html" class="nav-item nav-link active">Products</a>
                            <a href="product-detail.html" class="nav-item nav-link">Product Detail</a>
                            <a href="cart.html" class="nav-item nav-link">Cart</a>
                            <a href="checkout.html" class="nav-item nav-link">Checkout</a>
                            <a href="my-account.html" class="nav-item nav-link">My Account</a>
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">More Pages</a>
                                <div class="dropdown-menu">
                                    <a href="wishlist.html" class="dropdown-item">Wishlist</a>
                                    <a href="login.html" class="dropdown-item">Login & Register</a>
                                    <a href="contact.html" class="dropdown-item">Contact Us</a>
                                </div>
                            </div>
                        </div>
                        <div class="navbar-nav ml-auto">
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">User Account</a>
                                <div class="dropdown-menu">
                                    <a href="#" class="dropdown-item">Login</a>
                                    <a href="#" class="dropdown-item">Register</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        <!-- Nav Bar End -->

        <!-- Bottom Bar Start -->
        <div class="bottom-bar">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-3">
                        <div class="logo">
                            <a href="index.html">
                                <img src="img/logo.png" alt="Logo">
                            </a>
                        </div>
                    </div>
                    <!--<div class="col-md-6">-->
                    <!--                        <div class="search">
                                                <input type="text" id="txtid" onkeyup="getData(this.value)">
                                                <div id="data"></div>
                                                <button><i class="fa fa-search"></i></button>
                                            </div>-->
                    <!--</div>-->
                    <div class="col-md-3">
                        <div class="user">
                            <a href="wishlist.html" class="btn wishlist">
                                <i class="fa fa-heart"></i>
                                <span>(0)</span>
                            </a>
                            <a href="cart.html" class="btn cart">
                                <i class="fa fa-shopping-cart"></i>
                                <span>(0)</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bottom Bar End -->

        <!-- Breadcrumb Start -->
        <div class="breadcrumb-wrap">
            <div class="container-fluid">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Products</a></li>
                    <li class="breadcrumb-item active">Product List</li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumb End -->

        <!-- Product List Start -->
        <div class="product-view">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="product-view-top">
                                    <div class="row">
                                        <div class="container mt-5">
                                            <input 
                                                type="text" 
                                                class="form-control" 
                                                id="searchInput" 
                                                onkeyup="searchProducts(this.value)" 
                                                placeholder="Search for products..."
                                                >
                                            <div id="data" class="mt-4"></div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="product-short">
                                                <div class="dropdown">
                                                    <div class="dropdown-toggle" data-toggle="dropdown">Product short by</div>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a href="#" class="dropdown-item">Newest</a>
                                                        <a href="#" class="dropdown-item">Popular</a>
                                                        <a href="#" class="dropdown-item">Most sale</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="product-price-range">
                                                <div class="dropdown">
                                                    <div class="dropdown-toggle" data-toggle="dropdown">Product price range</div>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a href="#" class="dropdown-item">$0 to $50</a>
                                                        <a href="#" class="dropdown-item">$51 to $100</a>
                                                        <a href="#" class="dropdown-item">$101 to $150</a>
                                                        <a href="#" class="dropdown-item">$151 to $200</a>
                                                        <a href="#" class="dropdown-item">$201 to $250</a>
                                                        <a href="#" class="dropdown-item">$251 to $300</a>
                                                        <a href="#" class="dropdown-item">$301 to $350</a>
                                                        <a href="#" class="dropdown-item">$351 to $400</a>
                                                        <a href="#" class="dropdown-item">$401 to $450</a>
                                                        <a href="#" class="dropdown-item">$451 to $500</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $image = 'Admin/New/' . $row['Image'];
                                    echo '
                        <div class="col-lg-3">
                            <div class="product-item">
                                <div class="product-title">
                                    <a href="product-detail.html">' . $row['Product_name'] . '</a>
                                    <div class="ratting">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                </div>
                                <div class="product-image">
                                    <a href="product-detail.html">
                                        <img src="' . $image . '" alt="' . $row['Product_name'] . '">
                                    </a>
                                    <div class="product-action">
                                        <a href="#"><i class="fa fa-cart-plus"></i></a>
                                        <a href="#"><i class="fa fa-heart"></i></a>
                                        <a href="#"><i class="fa fa-search"></i></a>
                                    </div>
                                </div>
                                <div class="product-price">
                                    <h3>' . $row['Pirce'] . '</h3>
                                    <a href="product-detail.html" class="btn">View Detail</a>
                                </div>
                            </div>
                        </div>';
                                }
                            }
                            ?>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="sidebar">
                            <div class="sidebar-widget">
                                <h4 class="title">Fillters</h4>
                                <ul>
                                    <li>FRAME SHAPE<br><input type="checkbox" name="FRAME">Wayfarer
                                        <input type="checkbox" name="FRAME">Round
                                        <br><input type="checkbox" name="FRAME">Rectangle
                                        <input type="checkbox" name="FRAME">Square
                                        <br><input type="checkbox" name="FRAME">Cat Eye
                                        <input type="checkbox" name="FRAME">Aviator</li>

                                    <li>FRAME COLOR<br><input type="checkbox" name="COLOR">Black
                                        <input type="checkbox" name="COLOR">Blue
                                        <br><input type="checkbox" name="COLOR">Red
                                        <input type="checkbox" name="COLOR">Pink
                                        <br><input type="checkbox" name="COLOR">White
                                        <input type="checkbox" name="COLOR">Golden
                                    </li>

                                    <li>Age<br><input type="checkbox" name="age">0-14
                                        <br><input type="checkbox" name="age">15-64
                                        <br><input type="checkbox" name="age">64 and above
                                    </li>

                                    <li>Gender<br><input type="radio" name="gender">Male
                                        <br><input type="radio" name="gender">Female
                                    </li>

                                    <li>Material<br><input type="checkbox" name="material">TR90
                                        <br><input type="checkbox" name="material">Stainless steel
                                        <br><input type="checkbox" name="material">Acetate
                                        <br><input type="checkbox" name="material">Stainless steel simple
                                    </li>

                                    <li>Price<br><input type="checkbox" name="price">1000 - 1500
                                        <br><input type="checkbox" name="price">1500 - 2000
                                        <br><input type="checkbox" name="price">2000 - 2500
                                        <br><input type="checkbox" name="price">2500 - 3000
                                    </li>

                                    <li>Brands<br><input type="checkbox" name="brand">lenscart
                                        <br><input type="checkbox" name="brand">GUCCI
                                        <br><input type="checkbox" name="brand">Ray.Ban
                                        <br><input type="checkbox" name="brand">Prada
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Product List End -->

        <!-- Footer Start -->
        <div class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="footer-info">
                            <h2>Company</h2>
                            <p>We are a leading e-commerce platform.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="footer-links">
                            <h2>Quick Links</h2>
                            <ul>
                                <li><a href="#">Home</a></li>
                                <li><a href="#">Products</a></li>
                                <li><a href="#">Contact</a></li>
                                <li><a href="#">About Us</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->

        <!-- JavaScript Libraries -->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
        <script src="lib/slick/slick.min.js"></script>
        <script src="js/main.js"></script>
    </body>
</html>