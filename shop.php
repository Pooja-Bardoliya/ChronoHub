<?php
include('header.php');
include("connect.php");

$id = $_GET['id'] ?? '';
$sort = $_GET['sort'] ?? 'best_selling';
$view = $_GET['view'] ?? 'grid';

// Sort products using SQL
$order = "ORDER BY pid DESC";

if ($sort == 'price_low') {
    $order = "ORDER BY price ASC";
}
elseif ($sort == 'price_high') {
    $order = "ORDER BY price DESC";
}
elseif ($sort == 'name_asc') {
    $order = "ORDER BY name ASC";
}
elseif ($sort == 'name_desc') {
    $order = "ORDER BY name DESC";
}

// Fetch products
if ($id != '') {
    $query = "SELECT * FROM tbl_product WHERE cid = " . intval($id) . " " . $order;
} else {
    $query = "SELECT * FROM tbl_product " . $order;
}

$result = mysqli_query($con, $query);
$products = array();
while ($row = mysqli_fetch_assoc($result)) {
    $products[] = $row;
}

// Fetch active categories from database for left sidebar filter
$cat_query = "SELECT * FROM `tbl_category`";
$cat_res = mysqli_query($con, $cat_query);
$categories_list = array();
while ($crow = mysqli_fetch_assoc($cat_res)) {
    $categories_list[] = $crow;
}
?>

<style>
    /* ---------- PAGE HEADER BANNER ---------- */
    .shop-header-banner {
      background: linear-gradient(180deg, #f8f9fa 0%, #ffffff 100%);
      padding: 3.5rem 0 2.5rem 0;
      border-bottom: 1px solid var(--border-color, #e5e7eb);
    }

    /* ---------- PRODUCT CARDS ---------- */
    .product-card {
      background: #ffffff;
      border: 1px solid var(--border-color, #e5e7eb);
      border-radius: 8px;
      overflow: hidden;
      transition: all 0.25s ease;
      position: relative;
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
      height: 250px;
      padding: 0.5rem;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
    }

    .product-card .img-wrapper a {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 100%;
      height: 100%;
    }

    .product-card .img-wrapper img {
      max-width: 100%;
      max-height: 100%;
      width: auto;
      height: auto;
      object-fit: contain;
      transition: transform 0.25s ease;
    }

    .product-card:hover .img-wrapper img {
      transform: scale(1.05);
    }

    .product-card .badge-discount {
      position: absolute;
      top: 12px;
      left: 12px;
      background: #111111;
      color: #ffffff;
      font-size: 0.72rem;
      font-weight: 700;
      padding: 0.25rem 0.65rem;
      border-radius: 2px;
      letter-spacing: 0.05em;
      z-index: 2;
    }

    .product-card .card-body {
      padding: 1.25rem;
      display: flex;
      flex-direction: column;
      flex-grow: 1;
    }

    .product-brand {
      font-family: var(--font-nav, 'Outfit', sans-serif);
      font-size: 0.75rem;
      text-transform: uppercase;
      letter-spacing: 0.1em;
      color: var(--text-muted, #6c757d);
      margin-bottom: 0.25rem;
    }

    .product-name {
      font-family: var(--font-body, 'Plus Jakarta Sans', sans-serif);
      font-size: 0.98rem;
      font-weight: 600;
      line-height: 1.35;
      margin-bottom: 0.65rem;
      color: #111111;
    }

    .product-price-wrapper {
      margin-top: auto;
      display: flex;
      align-items: baseline;
      gap: 0.6rem;
    }

    .price-current {
      font-size: 1.15rem;
      font-weight: 700;
      color: #111111;
    }

    .price-old {
      font-size: 0.88rem;
      color: var(--text-muted, #6c757d);
      text-decoration: line-through;
    }

    .btn-add-cart {
      background-color: #ffffff;
      color: #111111;
      border: 1px solid #111111;
      font-family: var(--font-nav, 'Outfit', sans-serif);
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

    .btn-add-cart:hover {
      background-color: #111111;
      color: #ffffff;
    }

    /* Left Sidebar Filter & Checkbox Styling */
    .shop-filter-sidebar {
      border: 1px solid #eaeaea;
    }

    .shop-filter-sidebar .font-heading {
      font-family: 'Playfair Display', serif !important;
    }

    .form-check-input:checked {
      background-color: #111111 !important;
      border-color: #111111 !important;
    }

    .form-check-input:focus {
      border-color: #111111 !important;
      box-shadow: 0 0 0 0.2rem rgba(17, 17, 17, 0.15) !important;
    }

    .text-gold {
      color: #c5a059 !important;
    }
</style>

<!-- Page Header Banner -->
<div class="shop-header-banner mb-5">
    <div class="container text-center">
        <h1 class="mb-1 fs-2 font-heading fw-bold">Explore Luxury Timepieces</h1>
        <p class="text-muted small mb-0">Discover precision Swiss movements, classic dress watches, and luxury automatics.</p>
    </div>
</div>

<!-- Main Catalog Layout Container -->
<div class="container pb-5">
    <div class="row gx-lg-5 gy-4">
        
        <!-- Left Sidebar Filter Panel (Category Only) -->
        <div class="col-lg-3">
            <div class="bg-white rounded-3 p-4 shadow-sm shop-filter-sidebar mb-4">
                
                <!-- Filter Top Header -->
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h5 class="font-heading fw-bold mb-0 text-dark" style="font-size: 1.1rem;">
                        <i class="fa-solid fa-sliders text-gold me-2"></i> Filter Catalog
                    </h5>
                    <?php if (isset($id) && $id !== ''): ?>
                        <a href="shop.php" class="text-danger text-decoration-none" title="Clear Filter" aria-label="Clear Filter">
                            <i class="fa-solid fa-rotate-left fs-6"></i>
                        </a>
                    <?php endif; ?>
                </div>

                <!-- Section: Categories with Checkboxes -->
                <div class="py-2">
                    <div class="d-flex align-items-center justify-content-between cursor-pointer py-1" data-bs-toggle="collapse" data-bs-target="#filterCategories" role="button" aria-expanded="true">
                        <h6 class="font-heading fw-bold text-dark mb-0" style="font-size: 1.02rem;">Categories</h6>
                        <i class="fa-solid fa-chevron-down small text-muted font-chevron"></i>
                    </div>
                    <div class="collapse show mt-2" id="filterCategories">
                        <div class="d-flex flex-column gap-2 pt-1">
                            <div class="form-check d-flex align-items-center justify-content-between m-0">
                                <div class="d-flex align-items-center">
                                    <input class="form-check-input me-2" type="checkbox" id="cat_all" <?php echo (!isset($id) || $id === '') ? 'checked' : ''; ?> onchange="location.href='shop.php'">
                                    <label class="form-check-label small text-secondary cursor-pointer font-nav mb-0" for="cat_all" style="font-size: 0.86rem; <?php echo (!isset($id) || $id === '') ? 'color: #c5a059 !important; font-weight: 600;' : ''; ?>">All Categories</label>
                                </div>
                            </div>
                            <?php 
                            if (!empty($categories_list)) {
                                foreach ($categories_list as $cat) {
                                    $c_id = $cat['cid'];
                                    $c_name = htmlspecialchars($cat['cname']);
                                    $is_active = (isset($id) && $id == $c_id);

                                    $cat_url = $is_active ? 'shop.php' : 'shop.php?id=' . $c_id;
                            ?>
                                <div class="form-check d-flex align-items-center justify-content-between m-0">
                                    <div class="d-flex align-items-center">
                                        <input class="form-check-input me-2" type="checkbox" id="cat_<?php echo $c_id; ?>" <?php echo $is_active ? 'checked' : ''; ?> onchange="location.href='<?php echo $cat_url; ?>'">
                                        <label class="form-check-label small text-secondary cursor-pointer font-nav mb-0" for="cat_<?php echo $c_id; ?>" style="font-size: 0.86rem; <?php echo $is_active ? 'color: #c5a059 !important; font-weight: 600;' : ''; ?>">
                                            <?php echo $c_name; ?>
                                        </label>
                                    </div>
                                </div>
                            <?php 
                                }
                            } 
                            ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Right Main Catalog Column -->
        <div class="col-lg-9">
            
            <!-- Catalog Toolbar: Sort Options, Timepieces Count & View Switcher -->
            <div class="p-3 bg-white rounded-3 mb-4 d-flex flex-wrap align-items-center justify-content-end gap-3 shadow-sm" style="border: 1px solid #eaeaea;">
                
                <!-- Sort By Dropdown -->
                <div class="d-flex align-items-center gap-2">
                    <span class="small font-nav fw-bold text-uppercase text-muted">Sort By:</span>
                    <form action="shop.php" method="GET" class="m-0">
                        <?php if (isset($id) && $id !== ''): ?>
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                        <?php endif; ?>
                        <?php if (isset($_GET['view'])): ?>
                            <input type="hidden" name="view" value="<?php echo htmlspecialchars($_GET['view']); ?>">
                        <?php endif; ?>
                        
                        <select name="sort" class="form-select form-select-sm border text-dark rounded-2" onchange="this.form.submit()" style="font-size: 0.84rem; cursor: pointer;">
                            <option value="best_selling" <?php echo ($sort == 'best_selling') ? 'selected' : ''; ?>>Best Selling</option>
                            <option value="price_low" <?php echo ($sort == 'price_low') ? 'selected' : ''; ?>>Price: Low to High</option>
                            <option value="price_high" <?php echo ($sort == 'price_high') ? 'selected' : ''; ?>>Price: High to Low</option>
                            <option value="name_asc" <?php echo ($sort == 'name_asc') ? 'selected' : ''; ?>>Name: A to Z</option>
                            <option value="name_desc" <?php echo ($sort == 'name_desc') ? 'selected' : ''; ?>>Name: Z to A</option>
                        </select>
                    </form>
                </div>

                <!-- Timepieces Count Badge -->
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-light text-dark border px-3 py-2 font-nav fw-semibold rounded-2" style="font-size: 0.84rem;">
                        <i class="fa-solid fa-clock text-gold me-1"></i> <?php echo count($products); ?> Timepieces Available
                    </span>
                </div>

            </div>

            <?php if (!empty($products)) { ?>

                <!-- Product Cards Grid View -->
                <div id="catalog-grid-view" class="row g-4">
                    <?php foreach ($products as $p):
                        $price = (float)$p['price'];
                        $discount = (float)($p['discount'] ?? 0);
                        $discount_price = ($discount > 0) ? ($price * (1 - ($discount / 100))) : $price;
                        $has_discount = ($discount > 0);
                    ?>
                        <div class="col-xl-4 col-md-6 col-12">
                            <div class="product-card">
                                
                                <div class="img-wrapper">
                                    <?php if ($has_discount): ?>
                                        <span class="badge-discount">-<?php echo (int)$discount; ?>% OFF</span>
                                    <?php endif; ?>

                                    <a href="product-details.php?id=<?php echo $p['pid']; ?>" class="d-flex align-items-center justify-content-center w-100 h-100">
                                        <img src="<?php echo htmlspecialchars($p['pic']); ?>" alt="<?php echo htmlspecialchars($p['name']); ?>" class="img-fluid" loading="lazy" decoding="async" onerror="this.onerror=null; this.src='uploads/p1.png';">
                                    </a>
                                </div>

                                <div class="card-body">
                                    <div class="product-brand"><?php echo htmlspecialchars(!empty($p['brand']) ? $p['brand'] : 'CHRONOHUB'); ?></div>
                                    <h3 class="product-name">
                                        <a href="product-details.php?id=<?php echo $p['pid']; ?>" class="text-dark text-decoration-none">
                                            <?php echo htmlspecialchars($p['name']); ?>
                                        </a>
                                    </h3>

                                    <div class="product-price-wrapper">
                                        <?php if ($has_discount): ?>
                                            <span class="price-current">₹<?php echo number_format($discount_price, 2); ?></span>
                                            <span class="price-old">₹<?php echo number_format($price, 2); ?></span>
                                        <?php else: ?>
                                            <span class="price-current">₹<?php echo number_format($price, 2); ?></span>
                                        <?php endif; ?>
                                    </div>

                                    <a href="add_to_cart.php?pid=<?php echo $p['pid']; ?>" class="btn btn-add-cart text-center text-decoration-none d-block">
                                        <i class="fa-solid fa-bag-shopping me-1"></i> ADD TO CART
                                    </a>
                                </div>

                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            <?php } else { ?>
                <div class="text-center py-5 bg-white rounded-3 shadow-sm border p-5">
                    <i class="fa-solid fa-box-open fs-1 text-muted mb-3 d-block"></i>
                    <h4 class="font-heading fw-bold text-dark mb-2">No Timepieces Found</h4>
                    <p class="text-muted small mb-4">We couldn't find any products matching your current filter selection.</p>
                    <a href="shop.php" class="btn btn-luxury-dark px-4 py-2 fw-bold font-nav">View All Products</a>
                </div>
            <?php } ?>

        </div>

    </div>
</div>

<?php
include('footer.php');
?>