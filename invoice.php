<?php
session_start();
$uid = $_SESSION['id'];
$Billid = $_SESSION['bid'];
// Start output buffering and session
error_reporting(E_ALL ^ E_NOTICE);
ob_start();


// Define database constants
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'speczone');

// Database connection function
function connect() {
    $connect = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if (mysqli_connect_errno()) {
        die("Failed to connect: " . mysqli_connect_error());
    }
    return $connect;
}

// Establish connection
$con = connect();

// Require the TCPDF library
require("TCPDF-main/tcpdf.php");

// Initialize TCPDF
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Disable header and footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// Add a page to the PDF
$pdf->AddPage();

$pdf->SetFont('helvetica', 'B', 36);
$pdf->Cell(0, 22, 'specZone', 0, 1, 'C', 0, '', false, 'M', 'M');
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(0, 15, 'Pirchadi Road,Bhagal Char Rasta', 0, 1, 'C', 0, '', false, 'M', 'M');
$pdf->Cell(0, 15, 'Surat,Gujarat', 0, 1, 'C', 0, '', false, 'M', 'M');
$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(60, 15, 'Email : speczone888@gmail.com', 0, 0, 'L');
$pdf->Cell(70, 15, 'Mobile : 6353778808', 0, 0, 'C');
$pdf->Cell(60, 15, 'Website : https://speczone.com/', 0, 1, 'R');
$pdf->Line(10, 49, 200, 49);
$pdf->Line(10, 51, 200, 51);

$pdf->SetFont('times', 'BI', 12);
$pdf->Ln(15);
$pdf->Cell(180, 15, 'Date : ' . date("j / n / Y"), 0, 1, 'R', 0, '', 0, false, 'M', 'M');
$pdf->Ln(3);

$sql = "SELECT tbl_user.Name,tbl_user.Email, tbl_user.Address FROM tbl_user JOIN tbl_order ON tbl_user.ID = tbl_order.User_Id JOIN tbl_ordercart ON tbl_order.Id = tbl_ordercart.Order_Id JOIN tbl_bill ON tbl_ordercart.Id = tbl_bill.Ordercart_Id WHERE tbl_bill.Id = '$Billid'";
$result = mysqli_query($con, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    $uname = isset($row['Name']) ? $row['Name'] : 'N/A';
    $Address = isset($row['Address']) ? $row['Address'] : 0;
    $Email = isset($row['Email']) ? $row['Email'] : 'xyz@gmail.com';
    

}


$sql1 = "SELECT tbl_order.Id from tbl_order join tbl_ordercart on tbl_order.ID = tbl_ordercart.Order_Id join tbl_bill on tbl_ordercart.Id = tbl_bill.Ordercart_Id Where tbl_bill.Id = '$Billid'";
$result1 = mysqli_query($con, $sql1);

while ($row = mysqli_fetch_assoc($result1)) {
    $oid = isset($row['Id']) ? $row['Id'] : 'N/A';
}

$pdf->Cell(90, 10, "Name : $uname", 0, 0, 'L', 0, '', 0, false, 'M', 'M');
$pdf->Cell(90, 10, "Address  : $Address", 0, 1, 'L', 0, '', 0, false, 'M', 'M');

$pdf->Ln(3);
$pdf->Cell(90, 10, "Order Id : $oid", 0, 0, 'L', 0, '', 0, false, 'M', 'M');
$pdf->Cell(90, 10, "Email ID : $Email", 0, 1, 'L', 0, '', 0, false, 'M', 'M');

$pdf->SetFont('times', '', 12);
$pdf->Ln(3);

// Build the table
$tbl = <<<EOD
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse: collapse; width: 100%;">
    <tr>
        <th colspan="3" align="center" style="font-size:18px; font-weight:bold; border: 1px solid black;">PRODUCT DETAILS</th>
    </tr>
    <tr>
        <th width="10%" style="text-align:center; font-weight:bold; border: 1px solid black;">Sr No</th>
        <th width="50%" style="text-align:center; font-weight:bold; border: 1px solid black;">Product Name</th>
        <th width="20%" style="text-align:center; font-weight:bold; border: 1px solid black;">Qut</th>
        <th width="20%" style="text-align:center; font-weight:bold; border: 1px solid black;">Product Price</th>
    </tr>
EOD;

$sql2 = "SELECT GST,Grant_Amount,Total_Amount from tbl_bill where Id = '$Billid'";
$result2 = mysqli_query($con, $sql2);

while ($row = mysqli_fetch_assoc($result2)) {
    $Amount = isset($row['Total_Amount']) ? $row['Total_Amount'] : 0;
    $GST = isset($row['GST']) ? $row['GST'] : 0;
    $Grant_Amount = isset($row['Grant_Amount']) ? $row['Grant_Amount'] : 0;
}
// Correct SQL Query for fetching product details
$sql5 = "SELECT cart.product_id, cart.quantity, tbl_productinfo.Product_name, tbl_productinfo.Pirce 
         FROM cart 
         JOIN tbl_productinfo ON cart.product_id = tbl_productinfo.Id 
         WHERE cart.uid = $uid";
$result5 = mysqli_query($con, $sql5);

if (mysqli_num_rows($result5) > 0) {
    $i = 1;
    while ($row = mysqli_fetch_assoc($result5)) {
        $ProductName = $row['Product_name'];
        $Quantity = $row['quantity'];
        $price = $row['Pirce'];

        $tbl .= <<<EOD
        <tr>
            <td style="text-align:center; border: 1px solid black;">{$i}</td>
            <td style="text-align:center; border: 1px solid black;">{$ProductName}</td>
            <td style="text-align:center; border: 1px solid black;">{$Quantity}</td>
            <td style="text-align:center; border: 1px solid black;">{$price}</td>
        </tr>
        EOD;

        $i++;
    }
} else {
    $tbl .= <<<EOD
    <tr>
        <td colspan="4" style="text-align:center; font-weight:bold; border: 1px solid black;">No Products Found</td>
    </tr>
    EOD;
}

// Add total row
$tbl .= <<<EOD
    <tr>
        <td colspan="3" style="text-align:right; font-weight:bold; border: 1px solid black;">Amount :</td>
        <td style="text-align:center; font-weight:bold; border: 1px solid black;">{$Amount}</td>
    </tr>
        <tr>
        <td colspan="3" style="text-align:right; font-weight:bold; border: 1px solid black;">GST :</td>
        <td style="text-align:center; font-weight:bold; border: 1px solid black;">{$GST}</td>
    </tr>
        <tr>
        <td colspan="3" style="text-align:right; font-weight:bold; border: 1px solid black;">Total:</td>
        <td style="text-align:center; font-weight:bold; border: 1px solid black;">{$Grant_Amount}</td>
    </tr>
</table>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');

// Output PDF
$pdf->Output('invoice.pdf', 'I');

?>