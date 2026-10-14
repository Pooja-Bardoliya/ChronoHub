<?php

$type = $_GET['type'];
$id = $_GET['id'];

include 'connect.php';

if ($type == 'minus') {

    // Check current quantity
    $check = "SELECT quantity FROM tbl_cart WHERE cart_id=$id";
    $result = mysqli_query($con, $check);
    $row = mysqli_fetch_assoc($result);

    if ($row['quantity'] == 1) {
        // Delete item when quantity is 1
        $q = "DELETE FROM tbl_cart WHERE cart_id=$id";
    } else {
        // Decrease quantity
        $q = "UPDATE tbl_cart SET quantity=quantity-1 WHERE cart_id=$id";
    }

} else {
    // Increase quantity
    $q = "UPDATE tbl_cart SET quantity=quantity+1 WHERE cart_id=$id";
}

$res = mysqli_query($con, $q);

if ($res) {
    header("location: cart.php");
    exit();
}
?>