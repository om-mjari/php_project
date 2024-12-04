<div class="container">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>S.N.</th>
                <th>Product Image</th>
                <th>Product Name</th>
                <th>Size</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Payable Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include_once "../config/dbconnect.php";
            $ID = intval($_GET['orderID']); // Ensuring $ID is an integer for security

            // Updated SQL query
            $sql = "SELECT 
    p.Image AS product_image,
    p.Product_name AS product_name,
    p.Pirce AS price,
    p.Size AS size,
    oc.Quantity AS quantity,
    b.Grant_Amount AS payable_amount
FROM 
    tbl_productinfo p
JOIN 
    tbl_ordercart oc ON p.Id = oc.Product_Id
JOIN 
    tbl_bill b ON oc.Id = b.Ordercart_Id
WHERE 
    b.Ordercart_Id = $ID";

            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                $count = 1;
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?= $count ?></td>
                        <td>
                            <img src="New/<?= htmlspecialchars($row["product_image"]) ?>" 
                                 alt="<?= htmlspecialchars($row["product_name"]) ?>" 
                                 height="100px">
                        </td>
                        <td><?= htmlspecialchars($row["product_name"]) ?></td>
                        <td><?= htmlspecialchars($row["size"]) ?></td>
                        <td><?= htmlspecialchars($row["quantity"]) ?></td>
                        <td><?= htmlspecialchars($row["price"]) ?></td>
                        <td><?= htmlspecialchars($row["payable_amount"]) ?></td>
                    </tr>
                    <?php
                    $count++;
                }
            } else {
                echo "<tr><td colspan='7'>No products found or query error.</td></tr>";
                if (!$result) {
                    echo "<tr><td colspan='7'>Error: " . htmlspecialchars($conn->error) . "</td></tr>";
                }
            }
            ?>
        </tbody>
    </table>
</div>
