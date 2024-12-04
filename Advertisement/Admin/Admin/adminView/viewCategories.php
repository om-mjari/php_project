<!DOCTYPE html>
<html>
<head>
    <title>Category Items</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

<div>
    <h3>Category Items</h3>
    <table class="table">
        <thead>
            <tr>
                <th class="text-center">S.N.</th>
                <th class="text-center">Category Name</th>
                <th class="text-center" colspan="2">Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
        include_once "../config/dbconnect.php";
        $sql = "SELECT * FROM tbl_category";
        $result = $conn->query($sql);
        $count = 1;
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td class="text-center"><?= $count ?></td>
                    <td class="text-center"><?= $row["Name"] ?></td>
                    <td class="text-center">
                        <button class="btn btn-danger" style="height:40px" onclick="categoryDelete('<?= $row['Id'] ?>')">Delete</button>
                    </td>
                    <td class="text-center">
                        <button class="btn btn-danger" style="height:40px" onclick="categoryUpdate('<?= $row['Id'] ?>', '<?= $row['Name'] ?>')">Edit</button>
                    </td>
                    
                </tr>
                <?php
                $count++;
            }
        }
        ?>
        </tbody>
    </table>

    <!-- Trigger the modal with a button -->
    <button type="button" class="btn btn-secondary" style="height:40px" data-toggle="modal" data-target="#addCategoryModal">
        Add Category
    </button>

    <!-- Add Category Modal -->
    <div class="modal fade" id="addCategoryModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">New Category Item</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form enctype='multipart/form-data' action="./controller/addCatController.php" method="POST">
                        <div class="form-group">
                            <label for="c_name">Category Name:</label>
                            <input type="text" class="form-control" name="c_name" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-secondary" name="upload" style="height:40px">Add Category</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="height:40px">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Category Modal -->
    <div class="modal fade" id="editCategoryModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Category Item</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form enctype='multipart/form-data' action="./controller/updateCategories.php" method="POST">
                        <input type="hidden" name="id" id="editCategoryId">
                        <div class="form-group">
                            <label for="name">Category Name:</label>
                            <input type="text" class="form-control" name="name" id="editCategoryName" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-secondary" name="upload" style="height:40px">Update Category</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="height:40px">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function categoryUpdate(id, name) {
        $('#editCategoryId').val(id);
        $('#editCategoryName').val(name);
        $('#editCategoryModal').modal('show');
    }
</script>

</body>
</html>
