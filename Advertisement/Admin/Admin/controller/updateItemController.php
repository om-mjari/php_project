<?php

include_once "../config/dbconnect.php";

// Get the posted data
$product_id = $_POST['id'];
$p_name = mysqli_real_escape_string($conn, $_POST['p_name']);
$p_desc = mysqli_real_escape_string($conn, $_POST['p_desc']);
$p_price = mysqli_real_escape_string($conn, $_POST['p_price']);
$category = mysqli_real_escape_string($conn, $_POST['category']);
//$color = mysqli_real_escape_string($conn, $_POST['color']);
//$age = mysqli_real_escape_string($conn, $_POST['age']);
//$shape = mysqli_real_escape_string($conn, $_POST['shape']);
//$suit = mysqli_real_escape_string($conn, $_POST['suit']);
//$material = mysqli_real_escape_string($conn, $_POST['material']);
//$brand = mysqli_real_escape_string($conn, $_POST['brand']);
//$gender = mysqli_real_escape_string($conn, $_POST['gender']);
//$quantity = mysqli_real_escape_string($conn, $_POST['p_quantity']);
//$weight = mysqli_real_escape_string($conn, $_POST['p_weight']);
//$size = mysqli_real_escape_string($conn, $_POST['p_size']);

$final_image = "";

// Handle file upload if a new image is provided
if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
    $upload_dir = "../New/";
    $img = $_FILES['file']['name'];
    $tmp = $_FILES['file']['tmp_name'];
    $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
    $valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'webp');

    if (in_array($ext, $valid_extensions)) {
        $final_image = uniqid("img_", true) . "." . $ext;
        $target_file = $upload_dir . $final_image;

        if (!move_uploaded_file($tmp, $target_file)) {
            echo "<script>alert('File upload failed.'); window.location.href='../Admin_db.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Invalid file type. Only JPG, PNG, GIF, and WEBP are allowed.'); window.location.href='../Admin_db.php';</script>";
        exit();
    }
} else {
    // If no new image, retain the existing one
    $query = "SELECT Image FROM tbl_productinfo WHERE Id = ?";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        echo "Error in prepare statement: " . mysqli_error($conn);
        exit();
    }
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $final_image = $row['Image'];
    }
}

// Update the product in the database
$query = "UPDATE tbl_productinfo SET 
    Product_name = '$p_name', 
    Description = '$p_desc', 
    Pirce = $p_price, 
    Category_Id = $category, 
    Image = '$final_image' 
WHERE Id  = $product_id";

$stmt = $conn->prepare($query);

// Check if the prepare statement failed
if (!$stmt) {
    echo "Error in prepare statement: " . mysqli_error($conn);
    exit();
}
if ($stmt->execute()) {
    echo "<script>alert('Product updated successfully.');</script>";
    header("location: ../Admin_db.php");
    exit();
} else {
    echo "<script>alert('Error updating product.');</script>";
}

$stmt->close();
$conn->close();
?>
