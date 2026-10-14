<?php
include 'header.php';
include 'connect.php';

if (!isset($_SESSION['userid'])) {
    echo "<script>
            alert('Please log in to confirm your order.');
            window.location.href='login.php';
          </script>";
    exit();
} else {
    $userid = $_SESSION['userid'];
}

$query = "SELECT 
            tbl_cart.cart_id,
            tbl_cart.quantity,
            tbl_product.pid,
            tbl_product.name,
            tbl_product.brand,
            tbl_product.gender,
            tbl_product.pic,
            tbl_product.price,
            tbl_product.discount
          FROM tbl_cart 
          INNER JOIN tbl_product
          ON tbl_cart.pid = tbl_product.pid
          WHERE tbl_cart.userid='$userid'";

$result = mysqli_query($con, $query);

$items = array();
$total = 0;
$original_total = 0;
$total_discount_savings = 0;

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $price = (float)$row['price'];
        $discount = (float)($row['discount'] ?? 0);
        $has_discount = ($discount > 0);
        $selling_price = $has_discount ? ($price * (1 - ($discount / 100))) : $price;
        $qty = (int)$row['quantity'];

        $row['selling_price'] = $selling_price;
        $row['has_discount'] = $has_discount;
        $row['item_subtotal'] = $selling_price * $qty;
        $row['orig_subtotal'] = $price * $qty;

        $items[] = $row;
        $total += $row['item_subtotal'];
        $original_total += $row['orig_subtotal'];
    }
}
$total_discount_savings = $original_total - $total;
$count_items = count($items);
?>

<style>
    /* ---------- CHRONOHUB LUXURY CART PAGE STYLES ---------- */
    .cart-header-banner {
        background: linear-gradient(180deg, #f8f9fa 0%, #ffffff 100%);
        padding: 3.5rem 0 2.5rem 0;
        border-bottom: 1px solid var(--border-color, #e5e7eb);
    }

    .text-gold {
        color: #111111 !important;
    }

    .text-danger, .text-danger i, i.fa-trash-can {
        color: #dc3545 !important;
    }

    .tracking-wider {
        letter-spacing: 0.08em;
    }

    .table-luxury thead th {
        background-color: #f8f9fa !important;
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        color: #475569;
        border-bottom: 1px solid #eaeaea;
    }

    .table-luxury tbody td {
        border-bottom: 1px solid #f1f5f9;
    }

    .btn-luxury-dark {
        background-color: #111111;
        color: #ffffff;
        border: 1px solid #111111;
        transition: all 0.25s ease;
    }
    .btn-luxury-dark:hover {
        background-color: #000000;
        color: #ffffff;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }

    .btn-luxury-outline {
        background-color: transparent;
        color: #111111;
        border: 1px solid #111111;
        transition: all 0.25s ease;
    }
    .btn-luxury-outline:hover {
        background-color: #111111;
        color: #ffffff;
    }

    .cart-qty-pill {
        display: inline-flex;
        align-items: center;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        background: #f8fafc;
        overflow: hidden;
        height: 36px;
    }

    .cart-qty-btn {
        width: 32px;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #111111;
        text-decoration: none;
        transition: background 0.2s ease;
    }

    .cart-qty-btn:hover {
        background: #e2e8f0;
        color: #111111;
    }

    .cart-qty-val {
        min-width: 38px;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        color: #111111;
        font-size: 0.9rem;
    }
</style>

<?php if ($count_items == 0) { ?>
    <!-- Empty Cart State -->
    <div class="container py-5">
        <div class="text-center py-5 bg-white border rounded-4 shadow-sm my-4 px-4">
            <div class="d-inline-flex align-items-center justify-content-center bg-light rounded-circle mb-3" style="width: 70px; height: 70px;">
                <i class="fa-solid fa-bag-shopping fs-3 text-dark"></i>
            </div>
            <h3 class="font-heading fw-bold text-dark mb-2">Your Shopping Bag is Empty</h3>
            <p class="text-muted font-nav mx-auto mb-4" style="max-width: 500px;">
                We couldn't find any timepieces in your shopping bag.<br>Explore our luxury collection and find your perfect watch.
            </p>
            <a href="shop.php" class="btn btn-luxury-dark px-4 py-2 font-nav text-uppercase tracking-wider fw-bold small shadow-sm text-decoration-none d-inline-block">
                <i class="fa-solid fa-store me-2"></i> Explore Timepieces
            </a>
        </div>
    </div>
<?php } else { ?>
    <!-- Hero / Header Banner -->
    <div class="cart-header-banner mb-5">
        <div class="container text-center">
            <span class="text-uppercase text-dark fw-bold small tracking-wider font-nav">ChronoHub Boutique Bag</span>
            <h1 class="font-heading display-6 fw-bold text-dark mt-1 mb-2">Your Shopping Bag</h1>
            <p class="text-muted font-nav mx-auto mb-0" style="max-width: 620px;">
                Review your selected timepieces before proceeding to secure checkout. All orders include complimentary insured delivery and a 2-year warranty.
            </p>
        </div>
    </div>

    <div class="container pb-5">
        <div class="row g-4">
            
            <!-- Items Table (col-lg-8) -->
            <div class="col-lg-8 mb-4">
                <div class="table-responsive bg-white border rounded-3 shadow-sm">
                    <table class="table table-luxury align-middle mb-0">
                        <thead class="bg-light text-uppercase font-nav border-bottom">
                            <tr>
                                <th class="py-3 ps-4 text-dark fw-bold" style="min-width: 260px; font-size: 0.82rem; letter-spacing: 0.06em;">TIMEPIECE</th>
                                <th class="py-3 text-end text-dark fw-bold" style="font-size: 0.82rem; letter-spacing: 0.06em;">PRICE</th>
                                <th class="py-3 text-center text-dark fw-bold" style="width: 140px; font-size: 0.82rem; letter-spacing: 0.06em;">QUANTITY</th>
                                <th class="py-3 text-end text-dark fw-bold" style="font-size: 0.82rem; letter-spacing: 0.06em;">TOTAL</th>
                                <th class="py-3 pe-4 text-center" style="width: 50px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($items as $row): 
                                $brand_name = !empty($row['brand']) ? htmlspecialchars($row['brand']) : 'CHRONOHUB';
                            ?>
                                <tr>
                                    <td class="py-3 ps-4">
                                        <div class="d-flex align-items-center gap-3">
                                            <a href="shop.php" class="flex-shrink-0">
                                                <img src="<?php echo htmlspecialchars($row['pic']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" style="width: 64px; height: 64px; object-fit: contain; background: #f8fafc;" class="rounded-3 border p-1" onerror="this.onerror=null; this.src='uploads/p1.png';">
                                            </a>
                                            <div>
                                                <span class="text-uppercase font-nav tracking-wider small d-block mb-1" style="font-size: 0.78rem; letter-spacing: 0.05em; color: #8899a6;">
                                                    <?php echo $brand_name; ?>
                                                </span>
                                                <a href="shop.php" class="font-nav fw-bold text-dark text-decoration-none fs-6 d-block" style="font-family: 'Plus Jakarta Sans', sans-serif !important; line-height: 1.35;">
                                                    <?php echo htmlspecialchars($row['name']); ?>
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 text-end font-num" style="font-size: 1.05rem;">
                                        <?php if ($row['has_discount']): ?>
                                            <div class="text-muted text-decoration-line-through small" style="font-size: 0.8rem;">₹<?php echo number_format($row['price'], 2); ?></div>
                                            <div class="text-success fw-bold">₹<?php echo number_format($row['selling_price'], 2); ?></div>
                                        <?php else: ?>
                                            <span class="fw-bold text-dark">₹<?php echo number_format($row['price'], 2); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="py-3 text-center" style="width: 140px;">
                                        <div class="cart-qty-pill shadow-sm border bg-light d-inline-flex align-items-center rounded-3" style="height: 36px;">
                                            <a href="update_cart.php?type=minus&id=<?php echo $row['cart_id']; ?>" class="cart-qty-btn text-dark text-decoration-none px-2 d-flex align-items-center justify-content-center" title="Decrease Quantity">
                                                <i class="fa-solid fa-minus" style="font-size: 0.7rem;"></i>
                                            </a>
                                            <span class="cart-qty-val font-num fw-bold text-dark px-2 d-flex align-items-center justify-content-center" style="min-width: 32px; font-size: 0.9rem;"><?php echo (int)$row['quantity']; ?></span>
                                            <a href="update_cart.php?type=plus&id=<?php echo $row['cart_id']; ?>" class="cart-qty-btn text-dark text-decoration-none px-2 d-flex align-items-center justify-content-center" title="Increase Quantity">
                                                <i class="fa-solid fa-plus" style="font-size: 0.7rem;"></i>
                                            </a>
                                        </div>
                                    </td>
                                    <td class="py-3 text-end fw-bold text-dark font-num" style="font-size: 1.05rem;">₹<?php echo number_format($row['item_subtotal'], 2); ?></td>
                                    <td class="py-3 pe-4 text-center">
                                        <a href="remove_cart.php?cart_id=<?php echo $row['cart_id']; ?>" class="text-danger text-decoration-none p-1 fs-5 d-inline-block" title="Remove Timepiece">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Action Buttons Bar (After Item Table) -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <a href="shop.php" class="btn btn-luxury-outline btn-sm px-3 py-2 font-nav text-uppercase fw-semibold tracking-wider text-decoration-none">
                        <i class="fa-solid fa-arrow-left me-1"></i> Continue Shopping
                    </a>
                </div>
            </div>

            <!-- Order Summary Sidebar (col-lg-4) -->
            <div class="col-lg-4 mb-4">
                <div class="p-4 p-md-4 bg-white border rounded-4 shadow-sm">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <i class="fa-solid fa-receipt fs-4 text-dark"></i>
                        <div>
                            <h4 class="font-heading fw-bold text-dark mb-0">Order Summary</h4>
                            <small class="text-muted font-nav">Summary of timepieces in your bag.</small>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted font-nav">Bag Subtotal (<?php echo $count_items; ?> <?php echo ($count_items === 1) ? 'item' : 'items'; ?>)</span>
                        <span class="fw-semibold font-num">₹<?php echo number_format($original_total, 2); ?></span>
                    </div>

                    <?php if ($total_discount_savings > 0): ?>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-success font-nav fw-semibold"><i class="fa-solid fa-tag me-1"></i> Discount Savings</span>
                            <span class="text-success fw-bold font-num">-₹<?php echo number_format($total_discount_savings, 2); ?></span>
                        </div>
                    <?php endif; ?>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted font-nav">Estimated Shipping</span>
                        <span class="text-success fw-bold">FREE</span>
                    </div>

                    <hr class="my-3 opacity-25">

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <span class="fs-5 fw-bold font-heading">Total Amount</span>
                        <span class="fs-4 fw-bold text-dark font-num">₹<?php echo number_format($total, 2); ?></span>
                    </div>

                    <a href="confirm_order.php" class="btn btn-luxury-dark w-100 py-3 text-center d-block font-nav text-uppercase tracking-wider fw-bold small shadow-sm text-decoration-none">
                        Proceed To Checkout <i class="fa-solid fa-arrow-right ms-1"></i>
                    </a>

                    <div class="text-center mt-3 text-muted small" style="font-size: 0.8rem;">
                        <i class="fa-solid fa-lock me-1 text-dark"></i> 256-Bit SSL Encrypted Express Checkout
                    </div>
                </div>
            </div>

        </div>
    </div>
<?php } ?>

<?php
include 'footer.php';
?>