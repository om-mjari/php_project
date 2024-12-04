<?php

include_once "../config/dbconnect.php";

$order_id = $_POST['record'];

// Fetch the Delivery_Status and order_status
$sql = "SELECT td.Delivery_Status, tor.order_status
        FROM tbl_order tor
        JOIN tbl_ordercart toc ON tor.Order_Id = toc.Order_Id
        JOIN tbl_bill tb ON toc.Ordercart_Id = tb.Ordercart_Id
        JOIN tbl_delivery td ON tb.Bill_Id = td.Bill_Id
        WHERE tor.Order_Id = '$order_id'";

$result = $conn->query($sql);

if ($result && $row = $result->fetch_assoc()) {
    // Toggle order_status
    $new_status = ($row["order_status"] == 0) ? 1 : 0;
    
    $update = $conn->query("UPDATE tbl_order SET order_status='$new_status' WHERE Order_Id='$order_id'");
    
    if ($update) {
        echo "success";
    } else {
        echo "error";
    }
} else {
    echo "Order not found or query failed";
}

?>
