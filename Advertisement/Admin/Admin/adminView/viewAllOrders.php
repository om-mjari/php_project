<div id="ordersBtn">
    <h2>Order Details</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>O.N.</th>
                <th>Customer</th>
                <th>Contact</th>
                <th>Order Date</th>
                <th>Payment Method</th>
                <th>Order Status</th>
                <th>Payment Status</th>
                <th>More Details</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include_once "../config/dbconnect.php";

            $sql = "SELECT 
                        u.Name AS delivered_to, 
                        o.Id AS order_id, 
                        u.`Phone_No.` AS phone_no, 
                        p.Status AS pay_status, 
                        o.Ostatus AS order_status,
                        oc.Date AS order_date,
                        b.Payment_Method AS payment_method
                    FROM 
                        tbl_user u
                        INNER JOIN tbl_order o ON u.ID = o.User_Id
                        INNER JOIN tbl_ordercart oc ON o.Id = oc.Order_ID
                        INNER JOIN tbl_bill b ON oc.Id = b.Ordercart_Id
                        INNER JOIN tbl_payment p ON b.Id = p.Bill_Id;";

            $result = $conn->query($sql);

            if ($result) {
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($row["order_id"]) ?></td>
                            <td><?= htmlspecialchars($row["delivered_to"]) ?></td>
                            <td><?= htmlspecialchars($row["phone_no"]) ?></td>
                            <td><?= htmlspecialchars($row["order_date"]) ?></td>
                            <td><?= htmlspecialchars($row["payment_method"]) ?></td>
                            <td>
                                <button class="btn <?= $row['order_status'] == 0 ? 'btn-danger' : 'btn-success' ?>" 
                                    data-id="<?= $row['order_id'] ?>" 
                                    onclick="ChangeOrderStatus('<?= $row['order_id'] ?>')">
                                    <?= $row['order_status'] == 0 ? 'Pending' : 'Delivered' ?>
                                </button>
                            </td>
                            <td>
                                <button class="btn <?= $row['pay_status'] == 0 ? 'btn-danger' : 'btn-success' ?>" 
                                    data-id="<?= $row['order_id'] ?>" 
                                    onclick="ChangePay('<?= $row['order_id'] ?>')">
                                    <?= $row['pay_status'] == 0 ? 'Unpaid' : 'Paid' ?>
                                </button>
                            </td>
                            <td>
                                <a class="btn btn-primary openPopup" 
                                   data-href="./adminView/viewEachOrder.php?orderID=<?= $row['order_id'] ?>" 
                                   href="javascript:void(0);">
                                   View
                                </a>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "<tr><td colspan='8'>No orders found.</td></tr>";
                }
            } else {
                echo "<tr><td colspan='8'>Error retrieving orders. Please try again later.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Modal -->
<div class="modal fade" id="viewModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Order Details</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="order-view-modal modal-body"></div>
        </div><!-- /Modal content -->
    </div><!-- /Modal dialog -->
</div>

<script>
    $(document).ready(function () {
        $('.openPopup').on('click', function () {
            var dataURL = $(this).attr('data-href');
            $('.order-view-modal').load(dataURL, function () {
                $('#viewModal').modal('show');
            });
        });
    });

    function ChangeOrderStatus(orderId) {
        // Add logic to handle order status update
        alert("Change order status for order ID: " + orderId);
    }

    function ChangePay(orderId) {
        // Add logic to handle payment status update
        alert("Change payment status for order ID: " + orderId);
    }
</script>
