<?php

include_once "../config/dbconnect.php";
$id = $_POST['record'];


 $q = "select User_ID from tbl_dilivery_person where ID='$id'";
  $res = mysqli_query($conn, $q);
  while ($row = mysqli_fetch_row($res)) {
  $uid = $row[0];
  } 
$query = "Delete from tbl_dilivery_person where ID = '$id'";
$data = mysqli_query($conn, $query);

if ($data) {
    $query1="DELETE FROM tbl_User where ID='$uid'";
    $data1=mysqli_query($conn,$query1);
    echo"Employee Deleted";
} else {
    echo"Not able to delete";
}
?>