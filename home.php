<?php
include("header.php");
include("connect.php");
$query = "SELECT * FROM `tbl_product` LIMIT 0,4";
$products = array();
$res = mysqli_query($con, $query);
while ($row = mysqli_fetch_assoc($res)) {
    $products[] = $row;
}
$query = "SELECT * FROM `tbl_category` ORDER BY cid ASC";
$cats = array();
$res = mysqli_query($con, $query);
while ($row = mysqli_fetch_assoc($res)) {
    $cats[] = $row;
}
?>

<style>
    /* ---------- ANIMATIONS ---------- */
    @keyframes floatSoft {
      0% { transform: translateY(0px) rotate(0deg); }
      50% { transform: translateY(-12px) rotate(1deg); }
      100% { transform: translateY(0px) rotate(0deg); }
    }

    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes subtleGlow {
      0% { box-shadow: 0 0 0 0 rgba(198, 168, 124, 0.4); }
      70% { box-shadow: 0 0 0 14px rgba(198, 168, 124, 0); }
      100% { box-shadow: 0 0 0 0 rgba(198, 168, 124, 0); }
    }

    /* ---------- HERO BANNER ---------- */
    .hero-banner {
      background: linear-gradient(180deg, #f8f9fa 0%, #ffffff 100%);
      padding: 4.5rem 0 3.5rem 0;
      border-bottom: none !important;
    }

    .hero-subtitle {
      font-family: var(--font-nav, 'Outfit', sans-serif);
      font-size: 0.85rem;
      text-transform: uppercase;
      letter-spacing: 0.25em;
      color: var(--accent-gold, #c5a059);
      font-weight: 600;
    }

    .hero-title {
      font-size: 4.2rem;
      font-weight: 700;
      color: var(--badge-deep, #3a3a30);
      line-height: 1.1;
      margin-bottom: 1.5rem;
    }

    .hero-title span {
      background: linear-gradient(135deg, var(--badge-gold, #c6a87c), var(--badge-darkgold, #a8895c));
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
      position: relative;
    }

    .hero-sub {
      font-size: 1.2rem;
      color: var(--badge-olive, #6b6b5a);
      max-width: 500px;
      margin-bottom: 2rem;
      font-weight: 400;
      line-height: 1.7;
    }

    /* ---------- LUXURY BUTTONS ---------- */
    .btn-luxury-dark {
      background-color: #111111;
      color: #ffffff;
      font-family: var(--font-nav, 'Outfit', sans-serif);
      font-size: 0.85rem;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.08em;
      padding: 0.75rem 1.75rem;
      border-radius: 4px;
      border: 1px solid #111111;
      transition: all 0.25s ease;
    }

    .btn-luxury-dark:hover {
      background-color: #333333;
      border-color: #333333;
      color: #ffffff;
    }

    .btn-luxury-outline {
      background-color: transparent;
      color: #111111;
      font-family: var(--font-nav, 'Outfit', sans-serif);
      font-size: 0.85rem;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.08em;
      padding: 0.75rem 1.75rem;
      border-radius: 4px;
      border: 1px solid #111111;
      transition: all 0.25s ease;
    }

    .btn-luxury-outline:hover {
      background-color: #111111;
      color: #ffffff;
    }

    /* ---------- CATEGORY SLIDER & HOVER ---------- */
    .category-slider-wrapper {
      overflow: hidden;
      width: 100%;
    }

    .category-slider-track {
      display: flex;
      gap: 20px;
      transition: transform 0.5s ease;
    }

    .category-slider-item {
      flex: 0 0 calc(25% - 15px);
      max-width: calc(25% - 15px);
    }

    .cat-nav-btn {
      width: 38px;
      height: 38px;
      border-radius: 50%;
      border: 1px solid var(--border-color, #e5e7eb);
      background: #ffffff;
      color: #111111;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 0.9rem;
      cursor: pointer;
      transition: all 0.2s ease;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
    }

    .cat-nav-btn:hover {
      background: #111111;
      color: #ffffff;
      border-color: #111111;
      transform: scale(1.05);
    }

    .cat-nav-btn:active {
      transform: scale(0.95);
    }

    .category-item-link .cat-img {
      transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1), filter 0.35s ease;
      display: inline-block;
    }

    .category-item-link:hover .cat-img {
      transform: translateY(-8px) scale(1.08);
      filter: drop-shadow(0 10px 15px rgba(0, 0, 0, 0.12));
    }

    @media (max-width: 992px) {
      .category-slider-item {
        flex: 0 0 calc(33.333% - 14px);
        max-width: calc(33.333% - 14px);
      }
    }

    @media (max-width: 768px) {
      .category-slider-item {
        flex: 0 0 calc(50% - 10px);
        max-width: calc(50% - 10px);
      }
    }

    @media (max-width: 576px) {
      .category-slider-item {
        flex: 0 0 100%;
        max-width: 100%;
      }
      .hero-title {
        font-size: 2.8rem;
      }
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

    /* ---------- FEATURE & TRUST BOXES ---------- */
    .feature-box {
      text-align: center;
      padding: 1.25rem 0.5rem;
      border-right: none !important;
    }

    .feature-icon {
      font-size: 2rem;
      color: #c5a059;
      margin-bottom: 0.65rem;
    }

    .feature-box h6 {
      font-family: 'Playfair Display', serif !important;
      font-size: 0.95rem;
      font-weight: 700;
      letter-spacing: 0.05em;
      color: #111111;
      margin-bottom: 0;
      text-transform: uppercase;
      line-height: 1.3;
    }
</style>

<!-- 1. Hero Banner -->
<section class="hero-banner mb-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <span class="hero-subtitle mb-2 d-block"><i class="fa-solid fa-gem me-1 text-gold"></i> Heritage & Precision</span>
                <h1 class="hero-title fw-bold">Masterpieces of Timekeeping</h1>
                <p class="text-secondary lead mb-4">
                    Explore our curated collection of Swiss mechanical automatics, classic dress watches, and precision chronographs.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="shop.php" class="btn btn-luxury-dark">Shop Now <i class="fa-solid fa-arrow-right ms-2"></i></a>
                    <a href="about.php" class="btn btn-luxury-outline">About Us</a>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <img src="uploads/home1.jpg" alt="ChronoHub Luxury Watch" class="img-fluid rounded-3 shadow-lg" style="max-height: 420px; object-fit: cover;" onerror="this.onerror=null; this.src='uploads/about1.jpg';">
            </div>
        </div>
    </div>
</section>

<!-- 2. Watch Categories Showcase -->
<section class="py-5 bg-light my-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <span class="text-uppercase text-muted small fw-bold tracking-wider">Browse Collections</span>
                <h2 class="mb-0 fs-3 font-heading fw-bold">Watch Categories</h2>
            </div>
            <a href="shop.php" class="text-dark fw-bold text-uppercase small text-decoration-underline">View All <i class="fa-solid fa-arrow-right ms-1"></i></a>
        </div>

        <div class="category-slider-wrapper">
            <div class="category-slider-track d-flex gap-4 py-2" id="categorySliderTrack">
                <?php foreach ($cats as $c): ?>
                    <div class="category-slider-item text-center">
                        <a href="shop.php" class="text-decoration-none d-block py-2 category-item-link">
                            <div class="mb-3 d-flex align-items-center justify-content-center" style="height: 140px;">
                                <img src="<?= htmlspecialchars($c['cpic']) ?>" alt="<?= htmlspecialchars($c['cname']) ?>" class="img-fluid cat-img" loading="lazy" style="max-height: 140px; max-width: 100%; object-fit: contain;" onerror="this.onerror=null; this.src='uploads/c1.jpg';">
                            </div>
                            <div class="category-title fw-bold text-dark mb-0" style="letter-spacing: 0.08em; font-size: 0.85rem; text-transform: uppercase;"><?= htmlspecialchars($c['cname']) ?></div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="d-flex justify-content-center align-items-center gap-3 mt-4">
            <button id="cat-prev-btn" class="cat-nav-btn" aria-label="Previous Category" title="Previous">
                <i class="fa-solid fa-chevron-left"></i>
            </button>
            <button id="cat-next-btn" class="cat-nav-btn" aria-label="Next Category" title="Next">
                <i class="fa-solid fa-chevron-right"></i>
            </button>
        </div>
    </div>
</section>

<!-- 3. Featured Products Grid -->
<section class="py-5 my-4">
    <div class="container">
        <div class="text-center mb-5">
            <span class="text-uppercase text-muted small fw-bold tracking-wider">Top Timepieces</span>
            <h2 class="fs-2 font-heading fw-bold">Featured Products</h2>
        </div>

        <div class="row g-4">
            <?php 
            if (!empty($products)) {
                foreach ($products as $p) {
                    $price = (float)$p['price'];
                    $discount = (float)($p['discount'] ?? 0);
                    $discount_price = ($discount > 0) ? ($price * (1 - ($discount / 100))) : $price;
                    $has_discount = ($discount > 0);
            ?>
                <div class="col-lg-3 col-md-6">
                    <div class="product-card">
                        
                        <div class="img-wrapper">
                            <?php if ($has_discount) { ?>
                                <span class="badge-discount">-<?php echo (int)$discount; ?>% OFF</span>
                            <?php } ?>

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
                                <?php if ($has_discount) { ?>
                                    <span class="price-current">₹<?php echo number_format($discount_price, 2); ?></span>
                                    <span class="price-old">₹<?php echo number_format($price, 2); ?></span>
                                <?php } else { ?>
                                    <span class="price-current">₹<?php echo number_format($price, 2); ?></span>
                                <?php } ?>
                            </div>

                            <a href="add_to_cart.php?pid=<?php echo $p['pid']; ?>" class="btn btn-add-cart text-center text-decoration-none d-block">
                                <i class="fa-solid fa-bag-shopping me-1"></i> ADD TO CART
                            </a>
                        </div>

                    </div>
                </div>
            <?php 
                }
            } else {
            ?>
                <div class="col-12 text-center py-5">
                    <p class="text-muted">No products available at the moment.</p>
                </div>
            <?php } ?>
        </div>

        <div class="text-center mt-5">
            <a href="shop.php" class="btn btn-luxury-dark px-5">View All Products</a>
        </div>
    </div>
</section>

<!-- 4. Luxury Craftsmanship & Editorial Heritage Showcase -->
<section class="py-5 bg-white my-5">
    <div class="container py-4">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="pe-lg-4">
                    <span class="badge text-uppercase tracking-widest mb-3 px-3 py-2 fw-bold" style="background: #fdfaf3; color: #a8843f; border: 1px solid #e8d9b5;">
                        <i class="fa-solid fa-crown me-2"></i> Uncompromising Elegance
                    </span>
                    <h2 class="font-heading display-5 fw-bold mb-4 text-dark" style="letter-spacing: -0.5px;">
                        The Art of Swiss <br><span style="color: #c5a059; font-style: italic;">Horology & Craft</span>
                    </h2>
                    <p class="lead mb-4 text-muted" style="font-size: 1.05rem; line-height: 1.8;">
                        Every timepiece at ChronoHub is an enduring symbol of prestige. Designed with sapphire crystal glass, hand-finished rotors, and precision mechanical movements built to last generations.
                    </p>
                    
                    <div class="row g-4 mb-4">
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px; background: #ffffff; border: 1px solid #c5a059; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                                    <i class="fa-solid fa-microscope fs-5" style="color: #c5a059;"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 text-dark font-heading fw-bold">Swiss Precision</h6>
                                    <small class="text-muted">Certified COSC Movements</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px; background: #ffffff; border: 1px solid #c5a059; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                                    <i class="fa-solid fa-gem fs-5" style="color: #c5a059;"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 text-dark font-heading fw-bold">Sapphire Glass</h6>
                                    <small class="text-muted">Scratch-Resistant Crystal</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-3 pt-2">
                        <a href="about.php" class="btn btn-luxury-dark px-4 py-3 fw-bold">
                            Discover Our Heritage <i class="fa-solid fa-arrow-right ms-2"></i>
                        </a>
                        <a href="contact.php" class="btn btn-luxury-outline px-4 py-3 fw-bold">
                            Visit Surat Boutique
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="rounded-4 overflow-hidden shadow-lg border bg-white">
                    <img src="uploads/home2.jpg" alt="Swiss Watch Horology & Craftsmanship" class="w-100 d-block object-fit-cover" style="aspect-ratio: 1 / 1;" onerror="this.onerror=null; this.src='uploads/about2.jpg';">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 5. Trust Badges -->
<section class="py-5 bg-light mt-4">
    <div class="container">
        <div class="row g-0">
            <div class="col-md-3 col-6">
                <div class="feature-box">
                    <div class="feature-icon text-gold"><i class="fa-solid fa-shield-heart"></i></div>
                    <h6 class="font-heading mb-1 text-uppercase">100% Authentic</h6>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="feature-box">
                    <div class="feature-icon text-gold"><i class="fa-solid fa-award"></i></div>
                    <h6 class="font-heading mb-1 text-uppercase">2-Year Warranty</h6>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="feature-box">
                    <div class="feature-icon text-gold"><i class="fa-solid fa-plane-departure"></i></div>
                    <h6 class="font-heading mb-1 text-uppercase">Express Shipping</h6>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="feature-box">
                    <div class="feature-icon text-gold"><i class="fa-solid fa-arrow-rotate-left"></i></div>
                    <h6 class="font-heading mb-1 text-uppercase">30-Day Returns</h6>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener("DOMContentLoaded", function() {
    function setupCarousel(trackId, prevId, nextId, itemClass) {
        const track = document.getElementById(trackId);
        const prev = document.getElementById(prevId);
        const next = document.getElementById(nextId);
        if (!track || !prev || !next) return;

        const cards = track.querySelectorAll('.' + itemClass);
        if (cards.length === 0) return;

        let current = 0;
        
        function getVisible() {
            if (window.innerWidth < 576) return 1;
            if (window.innerWidth < 768) return 2;
            if (window.innerWidth < 992) return 3;
            return 4;
        }

        function slide() {
            const visible = getVisible();
            const maxIndex = Math.max(0, cards.length - visible);
            if (current > maxIndex) current = maxIndex;
            if (current < 0) current = 0;

            let step = 0;
            if (cards.length > 1) {
                step = cards[1].offsetLeft - cards[0].offsetLeft;
            } else if (cards.length === 1) {
                step = cards[0].offsetWidth;
            }

            track.style.transform = `translateX(-${current * step}px)`;

            prev.style.opacity = (current === 0) ? "0.3" : "1";
            prev.style.cursor = (current === 0) ? "default" : "pointer";
            
            next.style.opacity = (current >= maxIndex) ? "0.3" : "1";
            next.style.cursor = (current >= maxIndex) ? "default" : "pointer";
        }

        next.onclick = function() {
            const visible = getVisible();
            const maxIndex = Math.max(0, cards.length - visible);
            if (current < maxIndex) {
                current++;
                slide();
            }
        };

        prev.onclick = function() {
            if (current > 0) {
                current--;
                slide();
            }
        };

        slide();
        window.addEventListener("resize", slide);
    }

    setupCarousel("categorySliderTrack", "cat-prev-btn", "cat-next-btn", "category-slider-item");
});
</script>

<?php
include("footer.php");
?>