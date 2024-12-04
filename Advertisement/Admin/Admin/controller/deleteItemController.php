<?php

include_once "../config/dbconnect.php";

if (isset($_POST['record'])) {
    $p_id = $_POST['record'];
    $query = "DELETE FROM tbl_productinfo WHERE Id='$p_id'";

    $data = mysqli_query($conn, $query);

    if ($data) {
        echo "Product Item Deleted";
    } else {
        echo "Not able to delete";
    }
} else {
    echo "No record ID provided";
}
?>
