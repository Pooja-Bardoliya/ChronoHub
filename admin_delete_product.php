<?php
    $id = $_GET['id'];
    include("connect.php");

    $query = "DELETE FROM tbl_product WHERE pid=$id";
    $res = mysqli_query($con,$query);
    if($res>0)
    {
        header("location:admin_show_product.php");
    }

?>