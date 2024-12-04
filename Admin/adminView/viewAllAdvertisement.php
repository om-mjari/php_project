<div id="ordersBtn">
    <h2>Advertisement Details</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th class="text-center">S.No</th>
                <th class="text-center">Image</th>
                <th class="text-center">Name</th>
                <th class="text-center">Description</th>
                <th class="text-center" colspan="2">Action</th>
            </tr>
        </thead>
        <?php
        include_once "../config/dbconnect.php";

        $sql = "select * from tbl_advertisement";

        $result = $conn->query($sql);

        if ($result) {
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?= $row["Id"] ?></td>
                        <td>
                            <img src="Advertisement/<?php echo $row["Image"]; ?>" alt="<?php echo $row["Name"]; ?>" height="100px">
                        </td>
                        <td><?= $row["Name"] ?></td>
                        <td><?= $row["Description"] ?></td>


                        <td>
                            <button 
                                type="button" 
                                class="btn btn-danger" 
                                style="height:40px" 
                                data-toggle="modal" 
                                data-target="#myModal1" 
                                onclick="setRecordId('<?= $row['Id'] ?>', '<?= $row["Name"] ?>', '<?= $row["Description"] ?>')">
                                Edit
                            </button>

                        </td>

                        <td><button class="btn btn-danger" style="height:40px" onclick="itemDelete('<?php echo $row['Id']; ?>')">Delete</button></td>
                    </tr>
                    <?php
                }
            } else {
                echo "<tr><td colspan='8'>No Advertisement found.</td></tr>";
            }
        } else {
            echo "<tr><td colspan='8'>Error retrieving orders: " . $conn->error . "</td></tr>";
        }
        ?>
    </table>
</div>

<!-- Modal -->
<button type="button" class="btn btn-secondary" style="height:40px" data-toggle="modal" data-target="#myModal">
    Add Advertisement
</button>

<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">New Advertisement</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form enctype='multipart/form-data' onsubmit="addAdvertisement()" method="POST">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control" id="p_name" required>
                    </div>

                    <div class="form-group">
                        <label for="qty">Description:</label>
                        <input type="text" class="form-control" id="p_desc" required>
                    </div>
                    <div class="form-group">
                        <label for="file">Choose Image:</label>
                        <input type="file" class="form-control-file" id="file">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-secondary" id="upload" style="height:40px">Add Advertisement</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" style="height:40px">Close</button>
            </div>
        </div>
    </div>
</div>

<!--model1 for update product-->

<!--model1 for update product-->
<div class="modal fade" id="myModal1" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Update Advertisement</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form enctype='multipart/form-data' action="./controller/updateItemController.php" method="POST">
                    <input type="hidden" name="id" id="recordId" value="">

                    <div class="form-group">
                        <label for="update_p_name">Name:</label>
                        <input type="text" class="form-control" name="p_name" id="update_p_name" required>
                    </div>
                    <div class="form-group">
                        <label for="update_p_desc">Description:</label>
                        <input type="text" class="form-control" name="p_desc" id="update_p_desc" required>
                    </div>

                    <div class="form-group">
                        <label for="update_file">Change Image:</label>
                        <input type="file" class="form-control-file" name="file" id="update_file">
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-secondary" id="upload" style="height:40px">Update Advertisement</button>
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
    function setRecordId(id, name, desc) {
        document.getElementById('recordId').value = id;
        document.getElementById('update_p_name').value = name;
        document.getElementById('update_p_desc').value = desc;
    }
</script>


<!--model 1 close-->