<?php
session_start();
include_once 'db.php';

// Initialize the search query and results array
$searchQuery = '';
$searchResults = [];

// Check if the search query is provided via GET
if (isset($_GET['search'])) {
    $searchQuery = mysqli_real_escape_string($conn, $_GET['search']);

    // Fetch products based on the search query
    $sql = "SELECT p.*, c.Name as CategoryName FROM tbl_productinfo p 
            LEFT JOIN tbl_category c ON p.Category_Id = c.Id 
            WHERE p.Product_name LIKE '%$searchQuery%' OR p.Description LIKE '%$searchQuery%'";

    $result = $conn->query($sql);

    // Fetch results if any
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $searchResults[] = $row;
        }
    } else {
        // No results found
        $searchResults = [];
    }
}

// Generate HTML output for the results
if (!empty($searchResults)) {
    foreach ($searchResults as $product) {
        ?>
        <div class="col-lg-3">
            <div class="product-item">
                <div class="product-title">
                    <a href="#"><?= htmlspecialchars($product['Product_name']); ?></a>
                    <div class="ratting">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                    </div>
                </div>
                <div class="product-image">
                    <a href="product-detail.php?id=<?= $product['Id']; ?>">
                        <img src="Admin/New/<?= $product['Image']; ?>" alt="<?= htmlspecialchars($product['Product_name']); ?>">
                    </a>
                    <div class="product-action">
                        <a href="cartinsert.php?id=<?= $product['Id']; ?>&uid=<?= $_SESSION['id']; ?>&price=<?= $product['Pirce']; ?>"><i class="fa fa-cart-plus"></i></a>
                        <a href="wishlistinsert.php?id=<?= $product['Id']; ?>"><i class="fa fa-heart"></i></a>
                    </div>
                </div>
                <div class="product-description">
                    <p><?= htmlspecialchars($product['Description']); ?></p>
                </div>
                <div class="product-price">
                    <h3><span>₹</span><?= $product['Pirce']; ?></h3>
                </div>
            </div>
        </div>
        <?php
    }
} else {
    echo "<p>No products found for your search.</p>";
}
?>
