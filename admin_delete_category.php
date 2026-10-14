<?php
$id = $_GET['id'];
include("connect.php");

$query = "DELETE FROM tbl_category WHERE cid=$id";
$res = mysqli_query($con,$query);
if($res>0)
{
    header("location:admin_show_category.php");
}
?>