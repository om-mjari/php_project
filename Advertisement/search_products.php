<?php
// Database connection
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'speczone';

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch search query
$query = isset($_GET['q']) ? $conn->real_escape_string($_GET['q']) : '';

if ($query) {
    $sql = "SELECT * FROM tbl_productinfo WHERE Id LIKE '%$query%' OR Product_name LIKE '%$query%'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $image = 'Admin/New/' . htmlspecialchars($row['Image']);
            echo '
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card">
                    <img src="' . $image . '" class="card-img-top" alt="' . htmlspecialchars($row['Product_name']) . '">
                    <div class="card-body">
                        <h5 class="card-title">' . htmlspecialchars($row['Product_name']) . '</h5>
                        <p class="card-text">Price: $' . htmlspecialchars($row['Pirce']) . '</p>
                        <a href="#" class="btn btn-primary">View Details</a>
                    </div>
                </div>
            </div>';
        }
    } else {
        echo '<p>No products found matching your search.</p>';
    }
} else {
    echo '<p>Please enter a search term.</p>';
}
?>