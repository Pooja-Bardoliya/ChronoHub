<?php

session_start();
include "connect.php";

if (!isset($_SESSION['userid'])) {
    echo "<script>
            alert('Please log in to confirm your order.');
            window.location.href='login.php';
          </script>";
    exit();
} else {
    $userid = $_SESSION['userid'];
}
//$userid = $_SESSION['userid'];
$pid = $_GET['pid'];

// Check if product already exists in user's cart
$query = "SELECT * FROM tbl_cart
          WHERE userid='$userid'
          AND pid='$pid'";

$result = mysqli_query($con, $query);

if (mysqli_num_rows($result) > 0) {

    // Increase quantity
    $query = "UPDATE tbl_cart
              SET quantity = quantity + 1
              WHERE userid='$userid'
              AND pid='$pid'";

} else {

    // Add product
    $query = "INSERT INTO tbl_cart(userid, pid, quantity)
              VALUES('$userid', '$pid', 1)";
}

mysqli_query($con, $query);

header("Location: cart.php");
exit();

?>