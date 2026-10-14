<?php
include "header.php";

include "connect.php";

if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit();
}

$userid = $_SESSION['userid'];

// Get cart products
$query = "SELECT 
            c.cart_id,
            c.pid,
            c.quantity,
            p.price,
            p.discount
          FROM tbl_cart c
          INNER JOIN tbl_product p
          ON c.pid = p.pid
          WHERE c.userid='$userid'";

$result = mysqli_query($con, $query);

if (mysqli_num_rows($result) == 0) {
    echo "Your cart is empty.";
    exit();
}

// Calculate total
$total = 0;
$cart_items = [];

while ($row = mysqli_fetch_assoc($result)) {
    $price = (float)$row['price'];
    $discount = (float)($row['discount'] ?? 0);
    $selling_price = ($discount > 0) ? ($price * (1 - ($discount / 100))) : $price;
    $qty = (int)$row['quantity'];
    $subtotal = $selling_price * $qty;

    $row['selling_price'] = $selling_price;
    $total += $subtotal;
    $cart_items[] = $row;
}

// Insert order
$order_query = "INSERT INTO tbl_order
                (userid, total_amount, status)
                VALUES
                ('$userid', '$total', 'Pending')";

if (mysqli_query($con, $order_query)) {

    // Get generated order_id
    $order_id = mysqli_insert_id($con);

    // Insert order details & deduct stock
    foreach ($cart_items as $item) {
        $pid = $item['pid'];
        $quantity = (int)$item['quantity'];
        $item_price = $item['selling_price'];

        $detail_query = "INSERT INTO tbl_order_detail
                         (order_id, pid, quantity, price)
                         VALUES
                         ('$order_id',
                          '$pid',
                          '$quantity',
                          '$item_price')";

        mysqli_query($con, $detail_query);

        $qry_deduct_stock = "UPDATE tbl_product SET stock = stock - $quantity WHERE pid = $pid";
        mysqli_query($con, $qry_deduct_stock);
    }

    // Delete cart after successful order
    $delete_cart = "DELETE FROM tbl_cart
                    WHERE userid='$userid'";

    mysqli_query($con, $delete_cart);
    
    // Redirect to order success page
    echo "<script>window.location.href='order_success.php?order_id=$order_id'</script>";
    exit();

} else {

    echo "Something went wrong while placing the order.";
}

include "footer.php";

?>