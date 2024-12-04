<?php
require_once 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cart_id = intval($_POST['cart_id']);
    
    $query = "DELETE FROM cart WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $cart_id);

    if ($stmt->execute()) {
        header("Location: Cart1.php?message=ItemRemoved");
    } else {
        header("Location: Cart1.php?message=Error");
    }
} else {
    header("Location: Cart1.php");
}