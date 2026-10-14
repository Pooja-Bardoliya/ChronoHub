<?php
include('header.php');
include('connect.php');

$product_id = $_GET['id'] ?? 0;

// Fetch product details
$query = "SELECT tbl_product.*, tbl_category.cname AS category_name
          FROM tbl_product
          JOIN tbl_category ON tbl_product.cid = tbl_category.cid
          WHERE tbl_product.pid = $product_id";

$result = mysqli_query($con, $query);
$product = mysqli_fetch_assoc($result);

// Redirect if product not found
if (!$product) {
    header("Location: shop.php");
    exit();
}

// Product variables
$price = (float)$product['price'];
$discount = (float)$product['discount'];
$has_discount = ($discount > 0);
$discount_price = $has_discount ? ($price * (1 - ($discount / 100))) : $price;
$savings_pct = (int)$discount;
$stock = $product['stock'];
$is_bestseller = ($product['bestseller'] == '1' || strtolower($product['bestseller']) == 'yes');
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

    /* ChronoHub Underline Style Navigation Tabs */
    .nav-tabs {
        border-bottom: 1px solid #eaeaea !important;
        gap: 0;
    }
    .nav-tabs .nav-link {
        color: #6c757d !important;
        background: transparent !important;
        border: none !important;
        border-bottom: 2px solid transparent !important;
        border-radius: 0 !important;
        padding: 0.75rem 1.5rem !important;
        font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
        font-size: 0.82rem !important;
        font-weight: 700 !important;
        letter-spacing: 0.08em !important;
        text-transform: uppercase !important;
        transition: all 0.2s ease !important;
        margin-bottom: -1px !important;
    }
    .nav-tabs .nav-link:hover {
        color: #111111 !important;
        border-color: transparent transparent #c5a059 transparent !important;
    }
    .nav-tabs .nav-link.active {
        color: #111111 !important;
        background: transparent !important;
        border: none !important;
        border-bottom: 2px solid #111111 !important;
        box-shadow: none !important;
        outline: none !important;
    }
    .nav-tabs .nav-link:focus,
    .nav-tabs .nav-link:focus-visible {
        box-shadow: none !important;
        outline: none !important;
    }
    
    .product-card {
        background: #ffffff;
        border: 1px solid var(--border-color, #e5e7eb);
        border-radius: 8px;
        overflow: hidden;
        transition: all 0.25s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .product-card:hover {
        border-color: #111111;
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
        transform: translateY(-4px);
    }
    .product-card .img-wrapper {
        position: relative;
        background: #fbfbfb;
        width: 100%;
        height: 220px;
        padding: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    .product-card .img-wrapper img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }
    .btn-add-cart-rel {
        background-color: #ffffff;
        color: #111111;
        border: 1px solid #111111;
        font-family: 'Plus Jakarta Sans', sans-serif !important;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        padding: 0.5rem 1rem;
        border-radius: 4px;
        transition: all 0.25s ease;
        width: 100%;
        margin-top: 0.85rem;
    }
    .btn-add-cart-rel:hover {
        background-color: #111111;
        color: #ffffff;
    }
</style>

<div class="container py-5">
    
    <!-- Main Product Showcase Grid -->
    <div class="row g-5 align-items-start mb-5 pb-lg-3">
        
        <!-- Left Showcase: Image Frame -->
        <div class="col-lg-6">
            <div class="bg-white border rounded-4 shadow-sm p-4 p-md-5 text-center position-relative">
                <div class="d-flex align-items-center justify-content-center py-2" style="min-height: 420px;">
                    <img src="<?php echo htmlspecialchars($product['pic']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="img-fluid rounded-3 object-fit-contain" style="max-height: 440px;" onerror="this.onerror=null; this.src='uploads/p1.png';">
                </div>
            </div>
        </div>

        <!-- Right Column: Product Info & Actions -->
        <div class="col-lg-6">
            <div class="ps-lg-2">
                
                <!-- Top Status & Signature Badge Row -->
                <div class="d-flex align-items-center justify-content-between mb-3 font-nav">
                    <div>
                        <?php if ($stock > 0): ?>
                            <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-1.5 fw-semibold small">In Stock</span>
                        <?php else: ?>
                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-3 py-1.5 fw-semibold small">Out of Stock</span>
                        <?php endif; ?>
                    </div>

                    <?php if ($is_bestseller): ?>
                        <span class="badge bg-dark text-gold border border-warning px-3 py-1.5 rounded-pill fw-bold small text-uppercase">
                            <i class="fa-solid fa-star me-1 text-gold"></i> SIGNATURE
                        </span>
                    <?php endif; ?>
                </div>
                
                <!-- Main Product Title -->
                <h1 class="font-heading fw-bold text-dark fs-3 mb-3"><?php echo htmlspecialchars($product['name']); ?></h1>

                <!-- Metadata Row: Brand, Category & Gender -->
                <div class="row g-3 mb-3 font-nav">
                    <div class="col-4">
                        <span class="text-uppercase text-muted small fw-bold tracking-wider d-block mb-1" style="font-size: 0.7rem;">BRAND</span>
                        <strong class="text-dark fs-6"><?php echo htmlspecialchars(!empty($product['brand']) ? $product['brand'] : 'CHRONOHUB'); ?></strong>
                    </div>
                    <div class="col-4">
                        <span class="text-uppercase text-muted small fw-bold tracking-wider d-block mb-1" style="font-size: 0.7rem;">CATEGORY</span>
                        <strong class="text-dark fs-6"><?php echo htmlspecialchars(!empty($product['category_name']) ? $product['category_name'] : 'Timepiece'); ?></strong>
                    </div>
                    <div class="col-4">
                        <span class="text-uppercase text-muted small fw-bold tracking-wider d-block mb-1" style="font-size: 0.7rem;">GENDER</span>
                        <strong class="text-dark fs-6"><?php echo htmlspecialchars(!empty($product['gender']) ? ucfirst($product['gender']) : 'Unisex'); ?></strong>
                    </div>
                </div>

                <!-- Price Row -->
                <div class="d-flex align-items-center flex-wrap gap-2 mb-4">
                    <?php if ($has_discount): ?>
                        <span class="font-num fs-5 text-muted text-decoration-line-through me-1">₹<?php echo number_format($price, 2); ?></span>
                        <span class="font-num fs-2 fw-bold text-success me-2">₹<?php echo number_format($discount_price, 2); ?></span>
                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2.5 py-1 font-nav small fw-semibold">
                            (<?php echo $savings_pct; ?>% OFF)
                        </span>
                    <?php else: ?>
                        <span class="font-num fs-2 fw-bold text-dark">₹<?php echo number_format($price, 2); ?></span>
                    <?php endif; ?>
                </div>

                <!-- Action Buttons: Add to Cart & Buy Now -->
                <div class="mb-4">
                    <div class="row g-2">
                        <div class="col-6">
                            <a href="add_to_cart.php?pid=<?php echo $product['pid']; ?>" class="btn btn-outline-dark w-100 py-2.5 font-nav text-uppercase tracking-wider fw-bold rounded-3 shadow-2xs d-inline-flex align-items-center justify-content-center text-decoration-none <?php echo ($stock <= 0) ? 'disabled' : ''; ?>">
                                <i class="fa-solid fa-bag-shopping me-2"></i> Add To Cart
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="add_to_cart.php?pid=<?php echo $product['pid']; ?>" class="btn btn-dark w-100 py-2.5 font-nav text-uppercase tracking-wider fw-bold rounded-3 shadow-2xs d-inline-flex align-items-center justify-content-center text-decoration-none <?php echo ($stock <= 0) ? 'disabled' : ''; ?>">
                                <i class="fa-solid fa-bolt me-2"></i> Buy Now
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Detailed Product Information Tabs inside Right Column -->
                <div class="bg-white border rounded-4 shadow-sm p-3 p-md-4 mt-4">
                    <ul class="nav nav-tabs nav-justified border-bottom mb-3 font-nav small fw-bold text-uppercase" id="productDetailTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="desc-tab" data-bs-toggle="tab" data-bs-target="#desc-pane" type="button" role="tab">
                                Overview
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="specs-tab" data-bs-toggle="tab" data-bs-target="#specs-pane" type="button" role="tab">
                                Specs
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="shipping-tab" data-bs-toggle="tab" data-bs-target="#shipping-pane" type="button" role="tab">
                                Delivery
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content font-nav" id="productDetailTabContent">
                        
                        <!-- Tab 1: Description -->
                        <div class="tab-pane fade show active" id="desc-pane" role="tabpanel" tabindex="0">
                            <p class="text-secondary font-nav leading-relaxed mb-0 small" style="line-height: 1.7;">
                                <?php echo nl2br(htmlspecialchars($product['descrip'] ?? 'No description available.')); ?>
                            </p>
                        </div>

                        <!-- Tab 2: Technical Specs Table -->
                        <div class="tab-pane fade" id="specs-pane" role="tabpanel" tabindex="0">
                            <table class="table table-striped table-borderless align-middle small mb-0">
                                <tbody>
                                    <tr>
                                        <th class="text-muted fw-bold py-2 ps-2" style="width: 45%;"><i class="fa-solid fa-gear text-gold me-1.5"></i> Movement</th>
                                        <td class="fw-bold text-dark py-2 pe-2 text-end"><?php echo htmlspecialchars($product['movement'] ?? 'Automatic'); ?></td>
                                    </tr>
                                    <tr>
                                        <th class="text-muted fw-bold py-2 ps-2"><i class="fa-solid fa-circle-dot text-gold me-1.5"></i> Case Diameter</th>
                                        <td class="fw-bold text-dark py-2 pe-2 text-end"><?php echo htmlspecialchars($product['case_size'] ?? '40.5mm'); ?></td>
                                    </tr>
                                    <tr>
                                        <th class="text-muted fw-bold py-2 ps-2"><i class="fa-solid fa-palette text-gold me-1.5"></i> Dial Finish</th>
                                        <td class="fw-bold text-dark py-2 pe-2 text-end"><?php echo htmlspecialchars($product['dial_color'] ?? 'Blue'); ?></td>
                                    </tr>
                                    <tr>
                                        <th class="text-muted fw-bold py-2 ps-2"><i class="fa-solid fa-link text-gold me-1.5"></i> Strap Material</th>
                                        <td class="fw-bold text-dark py-2 pe-2 text-end"><?php echo htmlspecialchars($product['strap_material'] ?? 'Stainless Steel'); ?></td>
                                    </tr>
                                    <?php if (!empty($product['strap_color'])): ?>
                                    <tr>
                                        <th class="text-muted fw-bold py-2 ps-2"><i class="fa-solid fa-droplet text-gold me-1.5"></i> Strap Color</th>
                                        <td class="fw-bold text-dark py-2 pe-2 text-end"><?php echo htmlspecialchars($product['strap_color']); ?></td>
                                    </tr>
                                    <?php endif; ?>
                                    <tr>
                                        <th class="text-muted fw-bold py-2 ps-2"><i class="fa-solid fa-water text-gold me-1.5"></i> Water Resistance</th>
                                        <td class="fw-bold text-dark py-2 pe-2 text-end"><?php echo htmlspecialchars($product['water_resist'] ?? '50m'); ?></td>
                                    </tr>
                                    <tr>
                                        <th class="text-muted fw-bold py-2 ps-2"><i class="fa-solid fa-certificate text-gold me-1.5"></i> Authenticity</th>
                                        <td class="fw-bold text-dark py-2 pe-2 text-end">100% Genuine Certified</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Tab 3: Delivery & Authenticity -->
                        <div class="tab-pane fade" id="shipping-pane" role="tabpanel" tabindex="0">
                            <div class="d-flex flex-column gap-3 text-secondary leading-relaxed font-nav">
                                <div>
                                    <h6 class="fw-bold text-dark mb-1" style="font-size: 0.95rem;">
                                        <i class="fa-solid fa-truck-fast text-gold me-1.5"></i> Insured Express Delivery
                                    </h6>
                                    <p class="mb-0 text-muted" style="font-size: 0.88rem;">All ChronoHub orders are dispatched via insured express courier partners in luxury tamper-proof presentation boxes. Signature required upon delivery.</p>
                                </div>
                                <div class="border-top pt-2">
                                    <h6 class="fw-bold text-dark mb-1" style="font-size: 0.95rem;">
                                        <i class="fa-solid fa-shield-halved text-gold me-1.5"></i> 2-Year International Warranty
                                    </h6>
                                    <p class="mb-0 text-muted" style="font-size: 0.88rem;">Every watch includes a 2-year movement warranty. Certified watchmakers inspect and service mechanical components should any factory defects arise.</p>
                                </div>
                                <div class="border-top pt-2">
                                    <h6 class="fw-bold text-dark mb-1" style="font-size: 0.95rem;">
                                        <i class="fa-solid fa-rotate-left text-gold me-1.5"></i> 30-Day Money Back Guarantee
                                    </h6>
                                    <p class="mb-0 text-muted" style="font-size: 0.88rem;">If you are not completely satisfied with your purchase, return your unworn timepiece within 30 days for a full refund or exchange.</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </div>


</div>

<?php include('footer.php'); ?>
