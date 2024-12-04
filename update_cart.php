<?php
require_once 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cart_id = intval($_POST['cart_id']);
    $action = isset($_POST['increase']) ? 'increase' : (isset($_POST['decrease']) ? 'decrease' : null);

    // Fetch the current quantity
    $query = "SELECT quantity FROM cart WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $cart_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $quantity = $row['quantity'];

        if ($action === 'increase') {
            $quantity++;
        } elseif ($action === 'decrease' && $quantity > 1) {
            $quantity--;
        }

        // Update the quantity in the database
        $update_query = "UPDATE cart SET quantity = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param('ii', $quantity, $cart_id);
        $update_stmt->execute();
    }
    header("Location: Cart1.php");
} else {
    header("Location: Cart1.php");
}