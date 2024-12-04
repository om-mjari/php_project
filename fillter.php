<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
</head>
<body>
<?php
// Include database connection
include_once 'db.php';

// Initialize filters
$filters = [];

// Price filter logic
if (!empty($_GET['price'])) {
    $priceRange = $_GET['price'];
    $priceFilter = [];
    foreach ($priceRange as $range) {
        $range = explode('-', $range);
        $minPrice = (int) $range[0];
        $maxPrice = (int) $range[1];
        $priceFilter[] = "Pirce BETWEEN $minPrice AND $maxPrice";
    }
    $filters[] = "(" . implode(" OR ", $priceFilter) . ")";
}

// Gender filter logic
if (!empty($_GET['gender'])) {
    $gender = $_GET['gender'];
    $filters[] = "Gender = '" . mysqli_real_escape_string($conn, $gender) . "'";
}

// Final SQL query with applied filters
$sql = "SELECT * FROM tbl_productinfo";
if (!empty($filters)) {
    $sql .= " WHERE " . implode(" AND ", $filters);
}

// Execute the query
$result = mysqli_query($conn, $sql);
?>
<div class="container">
    <h1 class="mt-4">Product List</h1>
    <form method="get">
        <div>
            <h4>Price</h4>
            <input type="checkbox" name="price[]" value="1000-1500"> 1000-1500
            <input type="checkbox" name="price[]" value="1500-2000"> 1500-2000
        </div>
        <div>
            <h4>Gender</h4>
            <input type="radio" name="gender" value="m"> Male
            <input type="radio" name="gender" value="f"> Female
        </div>
        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
    </form>

    <div class="mt-4">
        <h2>Products</h2>
        <?php if ($result && mysqli_num_rows($result) > 0): ?>
            <div class="row">
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="New/<?php echo $row['Image']; ?>" class="card-img-top" alt="<?php echo $row['Product_name']; ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row['Product_name']; ?></h5>
                                <p class="card-text">Price: <?php echo $row['Pirce']; ?></p>
                                <a href="product-detail.html" class="btn btn-primary">View Details</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p>No products found matching the criteria.</p>
        <?php endif; ?>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
</body>
</html>
