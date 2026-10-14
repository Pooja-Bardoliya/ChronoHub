<?php
include 'header.php';

include "connect.php";

if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit();
}

$userid = $_SESSION['userid'];

$query = "SELECT * FROM tbl_order
          WHERE userid='$userid'
          ORDER BY order_id DESC";

$result = mysqli_query($con, $query);
?>

<style>
    .font-heading {
        font-family: 'Playfair Display', Georgia, serif !important;
    }
    .font-nav, 
    .font-num {
        font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
    }
    .tracking-wider {
        letter-spacing: 0.08em !important;
    }
    .text-gold {
        color: #c5a880 !important;
    }
    .btn-luxury-dark {
        background-color: #111111;
        color: #ffffff;
        border: 1px solid #111111;
        transition: all 0.25s ease;
    }
    .btn-luxury-dark:hover {
        background-color: #333333;
        color: #ffffff;
    }
</style>

<!-- Hero / Header Banner -->
<div class="py-5 bg-light border-bottom mb-5">
    <div class="container text-center">
        <span class="text-uppercase text-gold fw-bold small tracking-wider font-nav">Customer Portfolio</span>
        <h1 class="font-heading display-6 fw-bold text-dark mt-1 mb-2">My Order History</h1>
        <p class="text-muted font-nav mx-auto mb-0" style="max-width: 580px;">
            Review your past purchases, view official order receipts, and track your luxury timepiece deliveries.
        </p>
    </div>
</div>

<div class="container pb-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-9">

            <?php if (mysqli_num_rows($result) > 0) { ?>
                
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h4 class="font-heading fw-bold text-dark mb-0">Purchased Timepieces</h4>
                    <span class="badge bg-white text-dark font-nav border px-3 py-2 rounded-pill font-num shadow-sm">
                        Total Orders: <?php echo mysqli_num_rows($result); ?>
                    </span>
                </div>

                <?php 
                while ($order = mysqli_fetch_assoc($result)) {
                    $status = $order['status'] ?? 'Pending';
                    $status_styles = [
                        'Processing' => 'background-color: #e0f2fe; color: #0284c7;',
                        'Shipped'    => 'background-color: #f3e8ff; color: #7e22ce;',
                        'Completed'  => 'background-color: #dcfce7; color: #15803d;',
                        'Delivered'  => 'background-color: #dcfce7; color: #15803d;',
                        'Cancelled'  => 'background-color: #fee2e2; color: #b91c1c;',
                        'Pending'    => 'background-color: #fef3c7; color: #b45309;',
                        'Confirmed'  => 'background-color: #e0f2fe; color: #0284c7;',
                    ];
                    $badge_style = $status_styles[$status] ?? 'background-color: #e0f2fe; color: #0284c7;';
                ?>
                    <!-- LUXURY ORDER CARD -->
                    <div class="bg-white border rounded-4 shadow-sm mb-4 overflow-hidden position-relative">
                        
                        <!-- Top Header Bar -->
                        <div class="p-3 p-md-4 border-bottom bg-white">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                                <div>
                                    <h5 class="font-heading fw-bold text-dark font-num mb-1">#ORDER-<?php echo htmlspecialchars($order['order_id']); ?></h5>
                                    <small class="text-muted font-nav">
                                        <i class="fa-regular fa-calendar me-1 text-gold"></i>Placed on <?php echo date("d F Y", strtotime($order['order_date'])); ?>
                                    </small>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge rounded-pill font-nav px-3 py-2 fw-semibold" style="<?php echo $badge_style; ?> font-size: 0.8rem;">
                                        <?php echo htmlspecialchars(ucfirst(strtolower($status))); ?>
                                    </span>
                                    <a href="order_success.php?order_id=<?php echo urlencode($order['order_id']); ?>" class="btn btn-outline-dark py-2 px-3 rounded-3" title="View Receipt" aria-label="View Receipt">
                                        <i class="fa-solid fa-receipt fs-6"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Card Body: Timepieces List -->
                        <div class="p-3 p-md-4">
                            <?php
                            $order_id = $order['order_id'];

                            $detail_query = "SELECT 
                                                od.*,
                                                p.name,
                                                p.pic
                                             FROM tbl_order_detail od
                                             INNER JOIN tbl_product p
                                             ON od.pid = p.pid
                                             WHERE od.order_id='$order_id'";

                            $detail_result = mysqli_query($con, $detail_query);

                            if ($detail_result && mysqli_num_rows($detail_result) > 0) {
                                $items_count = mysqli_num_rows($detail_result);
                                $curr_idx = 0;
                            ?>
                                <div class="d-flex flex-column gap-3">
                                    <?php 
                                    while ($product = mysqli_fetch_assoc($detail_result)) {
                                        $curr_idx++;
                                        $img_src = !empty($product['pic']) ? $product['pic'] : 'uploads/placeholder.jpg';
                                        $border_class = ($curr_idx < $items_count) ? 'pb-3 border-bottom' : '';
                                    ?>
                                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 <?php echo $border_class; ?>">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="bg-light p-1 rounded-3 border d-flex align-items-center justify-content-center" style="width: 65px; height: 65px;">
                                                    <img src="<?php echo htmlspecialchars($img_src); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="rounded-2 object-fit-cover w-100 h-100">
                                                </div>
                                                <div>
                                                    <h6 class="font-heading fw-bold text-dark mb-1 fs-6"><?php echo htmlspecialchars($product['name']); ?></h6>
                                                    <div>
                                                        <span class="badge bg-light text-secondary border text-uppercase" style="font-size: 0.65rem; letter-spacing: 0.5px;">Luxury Timepiece</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-end font-nav">
                                                <span class="font-num fw-bold text-dark fs-6 d-block">₹<?php echo number_format($product['price'], 2); ?></span>
                                                <small class="text-muted font-num">Qty: <strong><?php echo (int)$product['quantity']; ?></strong></small>
                                            </div>
                                        </div>
                                    <?php 
                                    } 
                                    ?>
                                </div>
                            <?php 
                            } 
                            ?>
                        </div>

                        <!-- Card Footer -->
                        <div class="bg-light border-top p-3 px-md-4 font-nav d-flex flex-wrap align-items-center justify-content-between gap-2">
                            <div>
                                <span class="text-muted small d-block" style="font-size: 0.75rem;">Payment Method</span>
                                <span class="fw-bold text-dark small"><i class="fa-solid fa-credit-card me-1 text-gold"></i>Cash on Delivery</span>
                            </div>
                            <div class="text-end">
                                <span class="text-muted small d-block" style="font-size: 0.75rem;">Total Amount Paid</span>
                                <span class="font-num fw-bold text-dark fs-5">₹<?php echo number_format($order['total_amount'], 2); ?></span>
                            </div>
                        </div>

                    </div>
                <?php } ?>

            <?php } else { ?>
                <!-- EMPTY ORDER HISTORY STATE -->
                <div class="bg-white border rounded-4 p-5 text-center shadow-sm my-4">
                    <div class="d-inline-flex align-items-center justify-content-center bg-light text-gold rounded-circle p-4 mb-3 border">
                        <i class="fa-solid fa-box-open fs-1"></i>
                    </div>
                    <h3 class="font-heading fw-bold text-dark mb-2">No Orders Placed Yet</h3>
                    <p class="text-muted font-nav mx-auto mb-4" style="max-width: 460px;">
                        You have not placed any timepiece orders yet. Explore our luxury collection to find your next horological masterpiece.
                    </p>
                    <a href="home.php" class="btn btn-luxury-dark py-2 px-4 font-nav text-uppercase tracking-wider fw-bold small rounded-3">
                        <i class="fa-solid fa-bag-shopping me-2"></i> Explore Collection
                    </a>
                </div>
            <?php } ?>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js">
</script>

<?php
include 'footer.php';
?>