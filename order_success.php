<?php
include 'header.php';
include 'connect.php';

$order_id = $_GET['order_id'] ?? 0;

// Get order
$query = "SELECT * FROM tbl_order WHERE order_id = $order_id";
$result = mysqli_query($con, $query);
$order_info = mysqli_fetch_assoc($result);

// Get order items
$order_items = array();

$query = "SELECT tbl_order_detail.*, tbl_product.name AS product_name, tbl_product.brand, tbl_product.pic
          FROM tbl_order_detail
          INNER JOIN tbl_product ON tbl_order_detail.pid = tbl_product.pid
          WHERE tbl_order_detail.order_id = $order_id";

$result = mysqli_query($con, $query);

while ($row = mysqli_fetch_assoc($result)) {
    $order_items[] = $row;
}
?>

<style>
    @media print {
        body { background: #ffffff !important; }
        .no-print, header, nav, footer, .sticky-top, .main-footer { display: none !important; }
        #printable-receipt { border: none !important; box-shadow: none !important; padding: 0 !important; }
    }
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

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9 col-xl-8">
            
            <!-- Top Confirmation Greeting (Hidden on Print) -->
            <div class="text-center mb-4 no-print">
                <div class="d-inline-flex align-items-center justify-content-center bg-success text-white rounded-circle shadow-sm mb-3" style="width: 70px; height: 70px;">
                    <i class="fa-solid fa-check fs-2"></i>
                </div>
                <span class="text-uppercase text-success fw-bold small tracking-wider font-nav d-block mb-1">Order Confirmed</span>
                <h1 class="font-heading display-6 fw-bold text-dark mb-2">Thank You For Your Order!</h1>
                <p class="text-muted font-nav mx-auto mb-4" style="max-width: 580px;">
                    Your order <strong class="text-dark font-num">#<?php echo $order_id; ?></strong> has been received and is currently being processed by our horology specialists.
                </p>
            </div>

            <!-- OFFICIAL ORDER RECEIPT CARD -->
            <div id="printable-receipt" class="bg-white border rounded-4 p-4 p-md-5 text-start shadow-sm mb-4">
                
                <!-- Company Header & Logo Row -->
                <div class="row align-items-center mb-5 g-3">
                    <div class="col-sm-7">
                        <h4 class="font-heading fw-bold text-dark mb-1">ChronoHub Boutique</h4>
                        <p class="text-muted small font-nav mb-0">
                            101, Luxury Avenue, Vesu<br>
                            Surat, Gujarat 395007
                        </p>
                    </div>
                    <div class="col-sm-5 text-sm-end">
                        <div class="d-inline-block border rounded-4 p-3 bg-light text-center px-4">
                            <a href="home.php" class="brand-logo text-decoration-none d-inline-block mb-1" style="font-size: 1.4rem;">
                                <span class="brand-text">CHR<img src="uploads/watch_o.png" class="watch-o-letter" alt="O" style="height: 1.08em; width: auto; vertical-align: -0.15em; margin: 0 2px 0 1px;">NO<span class="brand-gold">HUB</span></span>
                            </a>
                            <small class="text-muted font-nav d-block" style="font-size: 0.65rem; letter-spacing: 1.5px;">LUXURY TIMEPIECES</small>
                        </div>
                    </div>
                </div>

                <!-- Main Receipt Title -->
                <div class="text-sm-end mb-5">
                    <h1 class="font-heading fw-bold text-dark text-uppercase tracking-wider display-4 mb-0" style="letter-spacing: 3px;">ORDER RECEIPT</h1>
                </div>

                <!-- Billed To & Order Details Row -->
                <div class="row mb-5 g-4">
                    <div class="col-sm-7">
                        <span class="text-uppercase text-secondary font-nav tracking-wider small fw-bold d-block mb-2" style="font-size: 0.75rem;">BILLED TO</span>
                        <h5 class="fw-bold text-dark font-nav mb-1"><?php echo htmlspecialchars($_SESSION['username'] ?? 'Valued Customer'); ?></h5>
                    </div>
                    <div class="col-sm-5 text-sm-end font-nav d-flex flex-column justify-content-end">
                        <div class="mb-1">
                            <span class="fw-bold text-dark me-2">Receipt ID:</span>
                            <span class="font-num fw-bold text-dark">#<?php echo $order_id; ?></span>
                        </div>
                        <div class="mb-1">
                            <span class="fw-bold text-dark me-2">Receipt date:</span>
                            <span class="font-num text-muted"><?php echo !empty($order_info['order_date']) ? date('d-m-Y', strtotime($order_info['order_date'])) : date('d-m-Y'); ?></span>
                        </div>
                        <div>
                            <span class="fw-bold text-dark me-2">Payment:</span>
                            <span class="text-muted">Cash on Delivery</span>
                        </div>
                    </div>
                </div>

                <!-- Line Items Table -->
                <?php if (!empty($order_items)): ?>
                <div class="table-responsive mb-4">
                    <table class="table font-nav align-middle mb-0" style="border-top: 2px solid #212529; border-bottom: 2px solid #212529;">
                        <thead>
                            <tr class="text-dark">
                                <th class="py-3 font-nav fw-bold text-uppercase" style="width: 10%; font-size: 0.8rem;">QTY</th>
                                <th class="py-3 font-nav fw-bold text-uppercase" style="width: 55%; font-size: 0.8rem;">Description</th>
                                <th class="py-3 font-nav fw-bold text-uppercase text-end" style="width: 17.5%; font-size: 0.8rem;">Unit Price</th>
                                <th class="py-3 font-nav fw-bold text-uppercase text-end" style="width: 17.5%; font-size: 0.8rem;">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($order_items as $item): 
                                $item_sub = (float)$item['price'] * (int)$item['quantity'];
                                $brand = !empty($item['brand']) ? $item['brand'] : 'CHRONOHUB';
                            ?>
                                <tr>
                                    <td class="py-3 font-num fw-bold text-dark fs-6"><?php echo $item['quantity']; ?></td>
                                    <td class="py-3">
                                        <div class="fw-bold text-dark fs-6"><?php echo htmlspecialchars($item['product_name']); ?></div>
                                        <small class="text-muted text-uppercase tracking-wider" style="font-size: 0.7rem;"><?php echo htmlspecialchars($brand); ?></small>
                                    </td>
                                    <td class="py-3 text-end font-num text-muted fs-6">₹<?php echo number_format((float)$item['price'], 2); ?></td>
                                    <td class="py-3 text-end font-num fw-bold text-dark fs-6">₹<?php echo number_format($item_sub, 2); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Subtotal, Shipping & Total Box -->
                <div class="row justify-content-end mb-5">
                    <div class="col-sm-6 col-md-5 font-nav">
                        <div class="d-flex justify-content-between py-1">
                            <span class="text-muted">Subtotal</span>
                            <span class="font-num fw-semibold text-dark">₹<?php echo number_format((float)($order_info['total_amount'] ?? 0), 2); ?></span>
                        </div>
                        <div class="d-flex justify-content-between py-1">
                            <span class="text-muted">Shipping</span>
                            <span class="text-success fw-bold">FREE</span>
                        </div>
                        <div class="d-flex justify-content-between py-3 my-2 border-top border-bottom border-dark border-2">
                            <span class="fw-bold text-dark fs-6 text-uppercase">Total Amount</span>
                            <span class="font-num fw-bold text-dark fs-5">₹<?php echo number_format((float)($order_info['total_amount'] ?? 0), 2); ?></span>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Notes & Support Section -->
                <div class="font-nav text-muted small pt-3 border-top">
                    <h6 class="fw-bold text-dark mb-1">Notes</h6>
                    <p class="mb-2">
                        Thank you for your purchase! All timepieces include a 2-year international warranty and boutique certificate of authenticity. Please retain this receipt for warranty or servicing purposes.
                    </p>
                    <p class="mb-0">
                        For questions or concierge support, contact us at <a href="mailto:concierge@chronohub.com" class="text-dark fw-bold">concierge@chronohub.com</a> or <span class="font-num fw-bold text-dark">+91 80000 55555</span>.
                    </p>
                </div>

            </div>

            <!-- Action Buttons (Hidden on Print) -->
            <div class="d-flex flex-wrap justify-content-center gap-3 no-print mb-4">
                <button onclick="window.print();" class="btn btn-outline-dark py-2 px-4 font-nav text-uppercase tracking-wider fw-bold small rounded-3">
                    <i class="fa-solid fa-print me-2"></i> Print Receipt
                </button>
                <a href="shop.php" class="btn btn-luxury-dark py-2 px-4 font-nav text-uppercase tracking-wider fw-bold small shadow-sm rounded-3">
                    <i class="fa-solid fa-bag-shopping me-2"></i> Continue Shopping
                </a>
            </div>

        </div>
    </div>
</div>

<?php
include 'footer.php';
?>