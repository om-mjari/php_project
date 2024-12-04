<?php
session_start();

include_once 'db.php';
include_once 'Homehader.php';

// Initialize filter array
$filters = [];
$priceFilter = [];
$genderFilter = '';
$categoryFilter = '';
$ageFilter = [];
$brandFilter = [];
$suitFilter = [];
$shapeFilter = [];
$materialFilter = [];

// Process category filter if present
$categoryId = isset($_GET['category']) && $_GET['category'] !== '' ? mysqli_real_escape_string($conn, $_GET['category']) : null;
$categoryFilter = $categoryId ? "p.Category_Id = '$categoryId'" : "";

// Process price filter if present
if (isset($_GET['price'])) {
    foreach ($_GET['price'] as $range) {
        // Explode price range like '1000-1500' into two parts
        list($min, $max) = explode('-', $range);
        $priceFilter[] = "p.Pirce BETWEEN $min AND $max";
    }
}

// Process gender filter if present
if (isset($_GET['gender'])) {
    $genderFilter = "p.Gender = '" . mysqli_real_escape_string($conn, $_GET['gender']) . "'";
}

// Process age filter if present
if (isset($_GET['age'])) {
    foreach ($_GET['age'] as $ageId) {
        $ageFilter[] = "p.Age_Id = " . mysqli_real_escape_string($conn, $ageId);
    }
}

// Process brand filter if present
if (isset($_GET['brand'])) {
    foreach ($_GET['brand'] as $brandId) {
        $brandFilter[] = "p.Brand_Id = " . mysqli_real_escape_string($conn, $brandId);
    }
}

// Process suit filter if present
if (isset($_GET['suit'])) {
    foreach ($_GET['suit'] as $suitId) {
        $suitFilter[] = "s.Id = " . mysqli_real_escape_string($conn, $suitId);
    }
}

// Process shape filter if present
if (isset($_GET['shape'])) {
    foreach ($_GET['shape'] as $shapeId) {
        $shapeFilter[] = "p.Shape_Id = " . mysqli_real_escape_string($conn, $shapeId);
    }
}

// Process material filter if present
if (isset($_GET['material'])) {
    foreach ($_GET['material'] as $materialId) {
        $materialFilter[] = "m.Id = " . mysqli_real_escape_string($conn, $materialId);
    }
}

// Combine all filters
if (!empty($priceFilter)) {
    $filters[] = "(" . implode(" OR ", $priceFilter) . ")";
}
if ($genderFilter) {
    $filters[] = $genderFilter;
}
if ($categoryFilter) {
    $filters[] = $categoryFilter;
}
if (!empty($ageFilter)) {
    $filters[] = "(" . implode(" OR ", $ageFilter) . ")";
}
if (!empty($brandFilter)) {
    $filters[] = "(" . implode(" OR ", $brandFilter) . ")";
}
if (!empty($suitFilter)) {
    $filters[] = "(" . implode(" OR ", $suitFilter) . ")";
}
if (!empty($shapeFilter)) {
    $filters[] = "(" . implode(" OR ", $shapeFilter) . ")";
}
if (!empty($materialFilter)) {
    $filters[] = "(" . implode(" OR ", $materialFilter) . ")";
}

// Construct SQL query with applied filters
$sql = "SELECT p.*, c.Name as CategoryName FROM tbl_productinfo p 
        LEFT JOIN tbl_category c ON p.Category_Id = c.Id";
if (!empty($filters)) {
    $sql .= " WHERE " . implode(" AND ", $filters);
}

// Execute query
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Products</title>
    <link href="img/favicon.ico" rel="icon">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400|Source+Code+Pro:700,900&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="lib/slick/slick.css" rel="stylesheet">
    <link href="lib/slick/slick-theme.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>

<!-- Breadcrumb -->
<div class="breadcrumb-wrap">
    <div class="container-fluid">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="Home.php">Home</a></li>
            <li class="breadcrumb-item"><a href="ProductList.php">Products</a></li>
        </ul>
    </div>
</div>

<!-- Product List Start -->
<div class="product-view">
    <div class="container-fluid">
        <div class="row">
            <!-- Left Column (Filters) -->
            <div class="col-lg-4">
                <div class="sidebar">
                    <div class="sidebar-widget">
                        <h4 class="title">Filters</h4>
                        <form method="GET" action="">
                            <!-- Price Filter -->
                            <div class="price-filter">
                                <label>Price:</label><br>
                                <?php
                                $priceRanges = [
                                    '100-1000', '1000-2000', '2000-3000', '3000-4000',
                                    '4000-5000', '5000-6000', '6000-7500', '7500-8000', '8000-9000'
                                ];
                                foreach ($priceRanges as $range) {
                                    echo '
                                    <input type="checkbox" name="price[]" value="' . $range . '" ' .
                                    (isset($_GET['price']) && in_array($range, $_GET['price']) ? 'checked' : '') .
                                    '> ' . $range . '<br>';
                                }
                                ?>
                            </div><br>

                            <!-- Gender Filter -->
                            <div class="gender-filter">
                                <label>Gender:</label><br>
                                <input type="radio" name="gender" value="Male" <?= isset($_GET['gender']) && $_GET['gender'] == 'Male' ? 'checked' : '' ?>> Male
                                <br>
                                <input type="radio" name="gender" value="Female" <?= isset($_GET['gender']) && $_GET['gender'] == 'Female' ? 'checked' : '' ?>> Female
                            </div><br>

                            <!-- Category Filter -->
                            <div class="category-filter">
                                <label>Category:</label>
                                <select name="category">
                                    <option value="">Select Category</option>
                                    <?php
                                    $categoryQuery = "SELECT Id, Name FROM tbl_category";
                                    $categoryResult = $conn->query($categoryQuery);
                                    if ($categoryResult && $categoryResult->num_rows > 0) {
                                        while ($categoryRow = $categoryResult->fetch_assoc()) {
                                            $selected = isset($_GET['category']) && $_GET['category'] == $categoryRow['Id'] ? 'selected' : '';
                                            echo '<option value="' . $categoryRow['Id'] . '" ' . $selected . '>' . $categoryRow['Name'] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div><br>

                            <!-- Age Filter -->
                            <div class="age-filter">
                                <label>Age:</label><br>
                                <?php
                                $ageQuery = "SELECT Id, Age FROM tbl_age";
                                $ageResult = $conn->query($ageQuery);
                                if ($ageResult && $ageResult->num_rows > 0) {
                                    while ($ageRow = $ageResult->fetch_assoc()) {
                                        $checked = isset($_GET['age']) && in_array($ageRow['Id'], $_GET['age']) ? 'checked' : '';
                                        echo '<input type="checkbox" name="age[]" value="' . $ageRow['Id'] . '" ' . $checked . '> ' . $ageRow['Age'] . '<br>';
                                    }
                                }
                                ?>
                            </div><br>

                            <!-- Brand Filter -->
                            <div class="brand-filter">
                                <label>Brand:</label><br>
                                <?php
                                $brandQuery = "SELECT Id, Name FROM tbl_brand";
                                $brandResult = $conn->query($brandQuery);
                                if ($brandResult && $brandResult->num_rows > 0) {
                                    while ($brandRow = $brandResult->fetch_assoc()) {
                                        $checked = isset($_GET['brand']) && in_array($brandRow['Id'], $_GET['brand']) ? 'checked' : '';
                                        echo '<input type="checkbox" name="brand[]" value="' . $brandRow['Id'] . '" ' . $checked . '> ' . $brandRow['Name'] . '<br>';
                                    }
                                }
                                ?>
                            </div><br>

                            <!-- Shape Filter -->
                            <div class="shape-filter">
                                <label>Shape:</label><br>
                                <?php
                                $shapeQuery = "SELECT Id, Name FROM tbl_shape";
                                $shapeResult = $conn->query($shapeQuery);
                                if ($shapeResult && $shapeResult->num_rows > 0) {
                                    while ($shapeRow = $shapeResult->fetch_assoc()) {
                                        $checked = isset($_GET['shape']) && in_array($shapeRow['Id'], $_GET['shape']) ? 'checked' : '';
                                        echo '<input type="checkbox" name="shape[]" value="' . $shapeRow['Id'] . '" ' . $checked . '> ' . $shapeRow['Name'] . '<br>';
                                    }
                                }
                                ?>
                            </div><br>

                            <button type="submit" class="btn btn-primary">Apply Filters</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Right Column (Product List) -->
            <div class="col-lg-8">
                <div class="row">
                    <?php
                    if ($result && $result->num_rows > 0) {
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
                                            <a href="product-detail.html">
                                                <img src="' . $image . '" alt="' . $row['Product_name'] . '">
                                            </a>
                                            <div class="product-action">';

                            if (isset($_SESSION['id'])) {
                                echo '<a href="cartinsert.php?pid=' . $row['Id'] . '&uid=' . $_SESSION['id'] . '&price=' . $row['Pirce'] . '"><i class="fa fa-cart-plus"></i></a>';
                            } else {
                                echo '<a href="login.php"><i class="fa fa-cart-plus"></i></a>';
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
    </div>
</div>
<!-- Product List End -->

<!-- Footer -->
<?php require 'Footer.php'; ?>

<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
<script src="lib/slick/slick.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>
