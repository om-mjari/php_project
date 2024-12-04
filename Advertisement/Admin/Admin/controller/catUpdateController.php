<!DOCTYPE html>
<html>
<head>
    <title>Webpage</title>
</head>
<body>

<!-- Edit Button -->
<button type="button" class="btn btn-danger" style="height:40px" onclick="categoryUpdate(<?= $row['Id'] ?>)">Edit</button>

<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Employee Record</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <form enctype='multipart/form-data' action="./controller/updateCategories.php" method="POST">
                    <input type="hidden" name="id" id="recordId" value="">
                    <div class="form-group">
                        <label for="name">Category Name:</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-secondary" name="upload" style="height:40px">Update Employee</button>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" style="height:40px">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    // JavaScript function to open the modal with the record ID
    function categoryUpdate(id) {
        $('#recordId').val(id); // Set hidden field in form
        $('#myModal').modal('show'); // Show modal
    }
</script>

</body>
</html>

<?php
include_once "../config/dbconnect.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $Id = $_POST['id'];
    $Name = $_POST['name'];
    
    $query = "UPDATE tbl_category SET Name='$Name' WHERE Id='$Id'";
    $data = mysqli_query($conn, $query);

    if ($data) {
        echo "Category Item Updated";
    } else {
        echo "Not able to update";
    }
}
?>
