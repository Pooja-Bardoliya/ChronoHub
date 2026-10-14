<?php
session_start();
include "connect.php";

$userid = $_SESSION['userid'];
$cart_id = $_GET['cart_id'];

$query = "DELETE FROM tbl_cart
          WHERE cart_id='$cart_id'
          AND userid='$userid'";

mysqli_query($con, $query);

header("Location: cart.php");
exit();

?>