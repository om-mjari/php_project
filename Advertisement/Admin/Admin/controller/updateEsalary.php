<?php
include_once "../config/dbconnect.php";
session_start();
if (isset($_POST['upload1'])) {
    
    $Id = $_POST['id'];  // Fixed: $_POST is case-sensitive
    $salary = $_POST['salary'];

    $updateQuery = "UPDATE tbl_dilivery_person SET Salary = ? WHERE ID = ?";
    $stmt = $conn->prepare($updateQuery);
    if ($stmt) {
        // Bind the parameters: "s" for string, "i" for integer
        $stmt->bind_param("si", $salary, $Id);

        // Execute the statement and check for success
        if ($stmt->execute()) {
            echo "<script>alert('Records updated successfully.'); window.location.href='../Admin_db.php';</script>";
        } else {
            echo "<script>alert('Failed to update records: " . $stmt->error . "'); window.location.href='../Admin_db.php?size=error';</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Preparation failed: " . $conn->error . "'); window.location.href='../Admin_db.php?size=error';</script>";
    }
    $conn->close();
}
?>
