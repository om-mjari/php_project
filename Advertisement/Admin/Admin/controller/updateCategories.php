<?php
include_once "../config/dbconnect.php";

if (isset($_POST['upload'])) {
    $Id = $_POST['id'];
    $Name = $_POST['name'];

    $updateQuery = "UPDATE tbl_category SET Name = ? WHERE Id = ?";
    $stmt = $conn->prepare($updateQuery);
    if ($stmt) {
        // Bind the parameters: "s" for string, "i" for integer
        $stmt->bind_param("si", $Name, $Id);

        // Execute the statement and check for success
        if ($stmt->execute()) {
            echo "<script>alert('Records updated successfully.'); window.location.href='../Admin_db.php?';</script>";
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
