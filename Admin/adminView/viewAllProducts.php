<div>
    <h2>Product Items</h2>
    <table class="table">
        <thead>
            <tr>
                <th class="text-center">S.N.</th>
                <th class="text-center">Product Image</th>
                <th class="text-center">Product Name</th>
                <th class="text-center">Product Description</th>
                <th class="text-center">Category Name</th>
                <th class="text-center">Unit Price</th>
                <th class="text-center" colspan="2">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include_once "../config/dbconnect.php";

            $sql = "SELECT tbl_productinfo.Id, tbl_productinfo.Image, tbl_productinfo.Product_name, tbl_productinfo.Description, tbl_category.Id as CategoryId, tbl_category.Name, tbl_productinfo.Pirce 
        FROM tbl_productinfo 
        INNER JOIN tbl_category ON tbl_productinfo.Category_Id = tbl_category.Id";

            $result = mysqli_query($conn, $sql);

            if ($result) {
                $count = 1;
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?php echo $count; ?></td>
                            <td>
                                <img src="New/<?php echo $row["Image"]; ?>" alt="<?php echo $row["Product_name"]; ?>" height="100px">
                            </td>
                            <td><?php echo $row["Product_name"]; ?></td>
                            <td><?php echo $row["Description"]; ?></td>
                            <td><?php echo $row["Name"]; ?></td>
                            <td><?php echo $row["Pirce"]; ?></td>
                            <!--<td><button class="btn btn-primary" style="height:40px" onclick="itemEditForm('<?php echo $row['Id']; ?>')">Edit</button></td>-->
                            <td>
                                <button 
                                    type="button" 
                                    class="btn btn-danger" 
                                    style="height:40px" 
                                    data-toggle="modal" 
                                    data-target="#myModal1" 
                                    onclick="setRecordId('<?= $row['Id'] ?>', '<?= $row["Product_name"] ?>', '<?= $row["Description"] ?>', '<?= $row["CategoryId"] ?>', '<?= $row["Pirce"] ?>')">
                                    Edit
                                </button>

                            </td>

                            <td><button class="btn btn-danger" style="height:40px" onclick="itemDelete('<?php echo $row['Id']; ?>')">Delete</button></td>
                        </tr>
                        <?php
                        $count++;
                    }
                } else {
                    echo "<tr><td colspan='8' class='text-center'>No products found</td></tr>";
                }
            } else {
                echo "<tr><td colspan='8' class='text-center'>Error: " . $conn->error . "</td></tr>";
            }
            ?>
<!--        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>-->

            </body>
    </table>

    <!-- Trigger the modal with a button -->
    <button type="button" class="btn btn-secondary" style="height:40px" data-toggle="modal" data-target="#myModal">
        Add Product
    </button>

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content -->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">New Product Item</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="productForm" enctype="multipart/form-data" action="./controller/addItemController.php" method="POST">
                        <div class="form-group">
                            <label for="name">Product Name:</label>
                            <input type="text" class="form-control" id="p_name" name="p_name" required>
                        </div>
                        <div class="form-group">
                            <label>Category:</label>
                            <select id="category" name="category" class="form-control" required>
                                <option disabled selected>Select category</option>
                                <?php
                                $categorySql = "SELECT * FROM tbl_category";
                                $categoryResult = $conn->query($categorySql);

                                if ($categoryResult && $categoryResult->num_rows > 0) {
                                    while ($row = $categoryResult->fetch_assoc()) {
                                        echo "<option value='" . $row['Id'] . "'>" . $row['Name'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Color:</label>
                            <select id="color" name="color" class="form-control">
                                <option disabled selected>Select Color</option>
                                <?php
                                $colorSql = "SELECT * FROM tbl_color";
                                $colorResult = $conn->query($colorSql);

                                if ($colorResult && $colorResult->num_rows > 0) {
                                    while ($ro = $colorResult->fetch_assoc()) {
                                        echo "<option value='" . $ro['Id'] . "'>" . $ro['Name'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Brand:</label>
                            <select id="brand" name="brand" class="form-control">
                                <option disabled selected>Select Brand</option>
                                <?php
                                $brandSql = "SELECT * FROM tbl_brand";
                                $brandResult = $conn->query($brandSql);

                                if ($brandResult && $brandResult->num_rows > 0) {
                                    while ($row2 = $brandResult->fetch_assoc()) {
                                        echo "<option value='" . $row2['Id'] . "'>" . $row2['Name'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Material:</label>
                            <select id="material" name="material" class="form-control">
                                <option disabled selected>Select Material</option>
                                <?php
                                $materialSql = "SELECT * FROM tbl_material";
                                $materialResult = $conn->query($materialSql);

                                if ($materialResult && $materialResult->num_rows > 0) {
                                    while ($row3 = $materialResult->fetch_assoc()) {
                                        echo "<option value='" . $row3['Id'] . "'>" . $row3['Name'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Age:</label>
                            <select id="age" name="age" class="form-control">
                                <option disabled selected>Select Age</option>
                                <?php
                                $ageSql = "SELECT * FROM tbl_age";
                                $ageResult = $conn->query($ageSql);

                                if ($ageResult && $ageResult->num_rows > 0) {
                                    while ($row4 = $ageResult->fetch_assoc()) {
                                        echo "<option value='" . $row4['Id'] . "'>" . $row4['Age'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Shape:</label>
                            <select id="shape" name="shape" class="form-control">
                                <option disabled selected>Select Shape</option>
                                <?php
                                $shapeSql = "SELECT * FROM tbl_shape";
                                $shapeResult = $conn->query($shapeSql);

                                if ($shapeResult && $shapeResult->num_rows > 0) {
                                    while ($row5 = $shapeResult->fetch_assoc()) {
                                        echo "<option value='" . $row5['Id'] . "'>" . $row5['Name'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Suit:</label>
                            <select id="suit" name="suit" class="form-control">
                                <option disabled selected>Select Suit</option>
                                <?php
                                $suitSql = "SELECT * FROM tbl_suit";
                                $suitResult = $conn->query($suitSql);

                                if ($suitResult && $suitResult->num_rows > 0) {
                                    while ($row6 = $suitResult->fetch_assoc()) {
                                        echo "<option value='" . $row6['Id'] . "'>" . $row6['Name'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>gender:</label>
                            <select id="gender" name="gender" class="form-control">
                                <option disabled selected>Select Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="quantity">Quantity:</label>
                            <input type="number" name="p_quantity" class="form-control" id="p_quantity" required>
                        </div>
                        <div class="form-group">
                            <label for="weight">Weight:</label>
                            <input type="number" name="p_weight" class="form-control" id="p_weight" required>
                        </div>
                        <div class="form-group">
                            <label for="size">Size:</label>
                            <input type="number"  name="p_size" class="form-control" id="p_size" required>
                        </div>
                        <div class="form-group">
                            <label for="price">Price:</label>
                            <input type="number" name="p_price" class="form-control" id="p_price" required>
                        </div>
                        <div class="form-group">
                            <label for="p_desc">Description:</label>
                            <input type="text" class="form-control" name="p_desc" id="p_desc" required>
                        </div>
                        <div class="form-group">
                            <label for="file">Choose Image:</label>
                            <input type="file" class="form-control-file" name="file" id="file" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-secondary" name="upload" style="height:40px">Add Item</button>
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
            <!-- Modal content -->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update Product Item</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <!-- Update Product Form -->
                    <form enctype="multipart/form-data" action="./controller/updateItemController.php" method="POST">
                        <input type="hidden" name="id" id="recordId" value="">

                        <!-- Product Name -->
                        <div class="form-group">
                            <label for="update_p_name">Product Name:</label>
                            <input type="text" class="form-control" name="p_name" id="update_p_name" required>
                        </div>

                        <!-- Category -->
                        <div class="form-group">
                            <label>Category:</label>
                            <select id="update_category" name="category" class="form-control">
                                <option disabled selected>Select Category</option>
                                <?php
                                $categorySql = "SELECT * FROM tbl_category";
                                $categoryResult = $conn->query($categorySql);
                                if ($categoryResult && $categoryResult->num_rows > 0) {
                                    while ($row = $categoryResult->fetch_assoc()) {
                                        echo "<option value='" . $row['Id'] . "'>" . $row['Name'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <!--                        <div class="form-group">
                                                    <label>Color:</label>
                                                    <select id="update_color" name="color" class="form-control">
                                                        <option disabled selected>Select Color</option>
                        <?php
                        $colorSql = "SELECT * FROM tbl_color";
                        $colorResult = $conn->query($colorSql);
                        if ($colorResult && $colorResult->num_rows > 0) {
                            while ($row = $colorResult->fetch_assoc()) {
                                echo "<option value='" . $row['Id'] . "'>" . $row['Name'] . "</option>";
                            }
                        }
                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Brand:</label>
                                                    <select id="update_brand" name="brand" class="form-control">
                                                        <option disabled selected>Select Brand</option>
                        <?php
                        $brandSql = "SELECT * FROM tbl_brand";
                        $brandResult = $conn->query($brandSql);

                        if ($brandResult && $brandResult->num_rows > 0) {
                            while ($row2 = $brandResult->fetch_assoc()) {
                                echo "<option value='" . $row2['Id'] . "'>" . $row2['Name'] . "</option>";
                            }
                        }
                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Material:</label>
                                                    <select id="update_material" name="material" class="form-control">
                                                        <option disabled selected>Select Material</option>
                        <?php
                        $materialSql = "SELECT * FROM tbl_material";
                        $materialResult = $conn->query($materialSql);

                        if ($materialResult && $materialResult->num_rows > 0) {
                            while ($row3 = $materialResult->fetch_assoc()) {
                                echo "<option value='" . $row3['Id'] . "'>" . $row3['Name'] . "</option>";
                            }
                        }
                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Age:</label>
                                                    <select id="update_age" name="age" class="form-control">
                                                        <option disabled selected>Select Age</option>
                        <?php
                        $ageSql = "SELECT * FROM tbl_age";
                        $ageResult = $conn->query($ageSql);

                        if ($ageResult && $ageResult->num_rows > 0) {
                            while ($row4 = $ageResult->fetch_assoc()) {
                                echo "<option value='" . $row4['Id'] . "'>" . $row4['Age'] . "</option>";
                            }
                        }
                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Shape:</label>
                                                    <select id="update_shape" name="shape" class="form-control">
                                                        <option disabled selected>Select Shape</option>
                        <?php
                        $shapeSql = "SELECT * FROM tbl_shape";
                        $shapeResult = $conn->query($shapeSql);

                        if ($shapeResult && $shapeResult->num_rows > 0) {
                            while ($row5 = $shapeResult->fetch_assoc()) {
                                echo "<option value='" . $row5['Id'] . "'>" . $row5['Name'] . "</option>";
                            }
                        }
                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Suit:</label>
                                                    <select id="update_suit" name="suit" class="form-control">
                                                        <option disabled selected>Select Suit</option>
                        <?php
                        $suitSql = "SELECT * FROM tbl_suit";
                        $suitResult = $conn->query($suitSql);

                        if ($suitResult && $suitResult->num_rows > 0) {
                            while ($row6 = $suitResult->fetch_assoc()) {
                                echo "<option value='" . $row6['Id'] . "'>" . $row6['Name'] . "</option>";
                            }
                        }
                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>gender:</label>
                                                    <select id="update_gender" name="gender" class="form-control">
                                                        <option disabled selected>Select Gender</option>
                                                        <option value="male">Male</option>
                                                        <option value="female">Female</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="quantity">Quantity:</label>
                                                    <input type="number" class="form-control" name="p_quantity" id="update_quantity" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="weight">Weight:</label>
                                                    <input type="number" class="form-control" name="p_weight" id="update_weight" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="size">Size:</label>
                                                    <input type="number" class="form-control" name="p_size" id="update_size" required>
                                                </div>-->
                        <div class="form-group">
                            <label for="update_p_price">Price:</label>
                            <input type="number" class="form-control" name="p_price" id="update_p_price" required>
                        </div>
                        <div class="form-group">
                            <label for="update_p_desc">Description:</label>
                            <input type="text" class="form-control" name="p_desc" id="update_p_desc" required>
                        </div>

                        <!-- File Upload -->
                        <div class="form-group">
                            <label for="update_file">Change Image:</label>
                            <input type="file" class="form-control-file" name="file" id="update_file">
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-secondary" style="height:40px">Update Item</button>
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
        // JavaScript to set record data and trigger modal
        function setRecordId(id, name, desc, categoryId, price, color, material, brand, gender, quantity, weight, size) {
            // Populate modal fields with the selected product's data
            document.getElementById('recordId').value = id;
            document.getElementById('update_p_name').value = name;
            document.getElementById('update_p_desc').value = desc;
            document.getElementById('update_category').value = categoryId;
            document.getElementById('update_p_price').value = price;
//            document.getElementById('update_color').value = color;
//            document.getElementById('update_material').value = material;
//            document.getElementById('update_brand').value = brand;
//            document.getElementById('update_gender').value = gender;
//            document.getElementById('update_quantity').value = quantity;
//            document.getElementById('update_weight').value = weight;
//            document.getElementById('update_size').value = size;
//
//            // Show the modal
//            $('#myModal1').modal('show');
        }

    </script>


    <!--model 1 close-->
</div>