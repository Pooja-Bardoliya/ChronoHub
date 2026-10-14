<?php
include("connect.php");
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    // Delete items in tbl_order_detail first
    mysqli_query($con, "DELETE FROM tbl_order_detail WHERE order_id = $id");
    // Delete main order row in tbl_order
    $res = mysqli_query($con, "DELETE FROM tbl_order WHERE order_id = $id");
}

header("location:admin_show_order.php");
exit();
?>
