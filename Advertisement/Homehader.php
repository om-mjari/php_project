<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Header Example</title>
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

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

</head>
<body>
    <!-- Top bar Start -->
    <div class="top-bar">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <i class="fa fa-envelope"></i> speczone2024@gmail.com
                </div>
                <div class="col-sm-6">
                    <i class="fa fa-phone-alt"></i> +91 6355072347
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
                        <a href="Home.php" class="nav-item nav-link active">Home</a>
                        <a href="productList.php" class="nav-item nav-link">Products</a>
                        <a href="vt/vit.html" class="nav-item nav-link">Virtual Try-On</a>
                        <a href="aboutus.php" class="nav-item nav-link">About Us</a>
                        <a href="contact1.php" class="nav-item nav-link">Contact Us</a>
                    </div>
                    <div class="navbar-nav ml-auto">
                        <a href="myaccount.php" class="dropdown-item">My Account</a>
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
                        <a href="Home.php"><img src="img/logo.png" alt="Logo"></a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="search">
                        <input type="text" id="search" name="search" placeholder="Search" onkeyup="searchProducts()">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="user">
                        <a href="wishlist1.php" class="btn wishlist">
                            <i class="fa fa-heart"></i>
                            <span>(0)</span>
                        </a>
                        <a href="cart1.php" class="btn cart">
                            <i class="fa fa-shopping-cart"></i>
                            <span>(0)</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bottom Bar End -->

    <!-- Search Results -->
    <div class="container" id="searchResults">
        <!-- Search results will be displayed here -->
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

    <!-- Template Javascript -->
    <script>
        function searchProducts() {
            var query = $("#search").val(); // Get the search query

            // Check if the query is not empty
            if (query.length > 0) {
                $.ajax({
                    url: 'search.php', // The PHP file that will return the search results
                    type: 'GET',
                    data: { search: query }, // Send the query via GET
                    success: function(response) {
                        // On success, update the search results container with the response
                        $('#searchResults').html(response);
                    }
                });
            } else {
                // Clear the search results if the input is empty
                $('#searchResults').html('');
            }
        }
    </script>
</body>
</html>