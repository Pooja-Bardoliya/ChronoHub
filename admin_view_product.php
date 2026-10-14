<?php
include("admin_header.php");
include("connect.php");

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$query = "SELECT tbl_product.*, tbl_category.cname 
          FROM tbl_product 
          LEFT JOIN tbl_category ON tbl_product.cid = tbl_category.cid 
          WHERE tbl_product.pid = $id";
$res = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($res);

if(!$row)
{
    echo "<script>window.location.href='admin_show_product.php'</script>";
    exit;
}

$price = (float)$row['price'];
$discount = (float)($row['discount'] ?? 0);
$discount_price = ($discount > 0) ? ($price * (1 - ($discount / 100))) : $price;
$stock = (int)($row['stock'] ?? 0);
$is_bestseller = ($row['bestseller'] == '1' || strtolower($row['bestseller'] ?? '') === 'yes' || $row['bestseller'] === true);
?>

<style>
  .overview-page-wrapper {
    width: 100% !important;
    max-width: 100% !important;
    margin: 0.5rem 0 3rem 0;
    font-family: 'Outfit', 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
  }

  /* Breadcrumb / Section tag */
  .overview-top-label {
    font-size: 0.76rem;
    font-weight: 700;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: #b8860b;
    margin-bottom: 0.4rem;
    display: inline-block;
  }

  /* Header Row */
  .overview-header-row {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 1.8rem;
    flex-wrap: wrap;
    gap: 1.25rem;
  }

  .overview-title {
    font-family: 'Playfair Display', Georgia, serif !important;
    font-size: 2rem;
    font-weight: 700;
    color: #0f172a;
    margin: 0 0 0.35rem 0;
    letter-spacing: -0.01em;
  }

  .overview-subtitle {
    font-size: 0.88rem;
    color: #64748b;
    margin: 0;
    font-weight: 400;
  }

  .btn-back-products {
    background: #111827;
    color: #ffffff;
    padding: 0.65rem 1.3rem;
    border-radius: 8px;
    font-size: 0.78rem;
    font-weight: 700;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.55rem;
    transition: all 0.25s ease;
    box-shadow: 0 4px 12px rgba(17, 24, 39, 0.15);
  }

  .btn-back-products:hover {
    background: #000000;
    color: #ffffff;
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(17, 24, 39, 0.25);
  }

  /* Stat Widgets Row */
  .overview-metrics-row {
    display: flex;
    gap: 1.25rem;
    margin-bottom: 1.8rem;
    flex-wrap: wrap;
  }

  .metric-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 1rem 1.4rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    min-width: 190px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
  }

  .metric-info {
    display: flex;
    flex-direction: column;
    gap: 0.2rem;
  }

  .metric-label {
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    color: #64748b;
  }

  .metric-value {
    font-size: 1.35rem;
    font-weight: 800;
    color: #0f172a;
  }

  .metric-icon-circle {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
  }

  .metric-icon-orders {
    background: #fef3c7;
    color: #b45309;
  }

  .metric-icon-revenue {
    background: #ecfdf5;
    color: #059669;
  }

  /* Main Luxury Card */
  .overview-main-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 2.2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
    display: grid;
    grid-template-columns: 360px 1fr;
    gap: 2.8rem;
  }

  /* Left Column: Image & Actions */
  .overview-media-col {
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
  }

  .overview-image-box {
    width: 100%;
    height: 420px;
    background: #f8fafc;
    border: 1px solid #f1f5f9;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1.5rem;
    overflow: hidden;
    position: relative;
    box-shadow: inset 0 2px 6px rgba(0, 0, 0, 0.02);
  }

  .overview-image-box img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    transition: transform 0.35s ease;
  }

  .overview-image-box:hover img {
    transform: scale(1.04);
  }

  .overview-action-buttons {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.85rem;
  }

  .btn-detail-edit {
    background: #f8fafc;
    color: #1e293b;
    border: 1px solid #cbd5e1;
    padding: 0.65rem 1rem;
    border-radius: 8px;
    font-size: 0.82rem;
    font-weight: 700;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.45rem;
    transition: all 0.2s ease;
  }

  .btn-detail-edit:hover {
    background: #e2e8f0;
    color: #0f172a;
    border-color: #94a3b8;
  }

  .btn-detail-delete {
    background: #ef4444;
    color: #ffffff;
    border: 1px solid #dc2626;
    padding: 0.65rem 1rem;
    border-radius: 8px;
    font-size: 0.82rem;
    font-weight: 700;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.45rem;
    transition: all 0.2s ease;
    box-shadow: 0 2px 6px rgba(239, 68, 68, 0.2);
  }

  .btn-detail-delete:hover {
    background: #dc2626;
    color: #ffffff;
  }

  /* Right Column: Information */
  .overview-info-col {
    display: flex;
    flex-direction: column;
  }

  /* Badges Row */
  .overview-badges-row {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    margin-bottom: 0.85rem;
  }

  .badge-stock-pill {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.25rem 0.75rem;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 700;
  }

  .badge-stock-pill.in-stock {
    background: #ecfdf5;
    color: #059669;
    border: 1px solid #a7f3d0;
  }

  .badge-stock-pill.low-stock {
    background: #fffbeb;
    color: #b45309;
    border: 1px solid #fde68a;
  }

  .badge-stock-pill.out-stock {
    background: #fef2f2;
    color: #dc2626;
    border: 1px solid #fecaca;
  }

  .badge-signature-pill {
    background: #111827;
    color: #fbbf24;
    padding: 0.25rem 0.75rem;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 800;
    letter-spacing: 0.05em;
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
  }

  /* Product Title */
  .detail-product-name {
    font-family: 'Cinzel', 'Playfair Display', Georgia, serif;
    font-size: 1.85rem;
    font-weight: 700;
    color: #0f172a;
    line-height: 1.25;
    margin: 0 0 1.5rem 0;
  }

  /* Quick Meta Matrix */
  .overview-meta-matrix {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
    padding-bottom: 1.35rem;
    border-bottom: 1px solid #f1f5f9;
    margin-bottom: 1.35rem;
  }

  .meta-box-label {
    font-size: 0.72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #64748b;
    margin-bottom: 0.25rem;
  }

  .meta-box-val {
    font-size: 0.95rem;
    font-weight: 700;
    color: #0f172a;
  }

  /* Pricing Row */
  .overview-price-display {
    display: flex;
    align-items: baseline;
    gap: 0.85rem;
    margin-bottom: 1.6rem;
  }

  .detail-price-old {
    font-size: 1.15rem;
    color: #94a3b8;
    text-decoration: line-through;
    font-weight: 500;
  }

  .detail-price-active {
    font-size: 2rem;
    font-weight: 800;
    color: #059669;
    letter-spacing: -0.02em;
  }

  .detail-discount-tag {
    font-size: 0.82rem;
    font-weight: 700;
    color: #059669;
    background: #ecfdf5;
    border: 1px solid #a7f3d0;
    padding: 0.2rem 0.55rem;
    border-radius: 6px;
  }

  /* Product Info Description */
  .overview-section-heading {
    font-size: 0.82rem;
    font-weight: 800;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: #334155;
    margin: 0 0 0.55rem 0;
  }

  .overview-desc-paragraph {
    font-size: 0.88rem;
    color: #64748b;
    line-height: 1.65;
    margin: 0 0 1.6rem 0;
  }

  /* Technical Details Bullets */
  .overview-bullets-list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 0.55rem;
  }

  .overview-bullets-list li {
    font-size: 0.88rem;
    color: #475569;
    display: flex;
    align-items: center;
    gap: 0.55rem;
  }

  .overview-bullets-list li::before {
    content: "•";
    color: #d4af37;
    font-weight: 800;
    font-size: 1.1rem;
  }

  .overview-bullets-list li strong {
    color: #1e293b;
    font-weight: 600;
  }

  @media (max-width: 992px) {
    .overview-main-card {
      grid-template-columns: 1fr;
      gap: 2rem;
    }
    .overview-image-box {
      height: 320px;
    }
    .overview-meta-matrix {
      grid-template-columns: repeat(2, 1fr);
    }
  }
</style>

<div class="overview-page-wrapper">

    <!-- Top Label -->
    <span class="overview-top-label"><i class="fa-solid fa-gem"></i> Product Details</span>

    <!-- Header Row -->
    <div class="overview-header-row">
        <div>
            <h1 class="overview-title">Product Overview</h1>
            <p class="overview-subtitle">Review complete product information, pricing, inventory status, and specifications in one place</p>
        </div>
        <a href="admin_show_product.php" class="btn-back-products">
            <i class="fa-solid fa-arrow-left"></i> Back to Products
        </a>
    </div>

    <!-- Quick Metrics Row -->
    <div class="overview-metrics-row">
        <div class="metric-card">
            <div class="metric-info">
                <span class="metric-label">Stock Status</span>
                <span class="metric-value"><?= $stock ?> Units</span>
            </div>
            <div class="metric-icon-circle metric-icon-orders">
                <i class="fa-solid fa-boxes-stacked"></i>
            </div>
        </div>

        <div class="metric-card">
            <div class="metric-info">
                <span class="metric-label">Catalog Price</span>
                <span class="metric-value">₹<?= number_format($price) ?></span>
            </div>
            <div class="metric-icon-circle metric-icon-revenue">
                <i class="fa-solid fa-indian-rupee-sign"></i>
            </div>
        </div>
    </div>

    <!-- Main Overview Card -->
    <div class="overview-main-card">

        <!-- Left Column: Image Showcase & Actions -->
        <div class="overview-media-col">
            <div class="overview-image-box">
                <img src="<?= htmlspecialchars($row['pic']) ?>" alt="<?= htmlspecialchars($row['name']) ?>">
            </div>
            <div class="overview-action-buttons">
                <a href="admin_update_product.php?id=<?= $id ?>" class="btn-detail-edit">
                    <i class="fa-solid fa-pen-to-square"></i> Edit
                </a>
                <a href="admin_delete_product.php?id=<?= $id ?>" class="btn-detail-delete" onclick="return confirm('Are you sure you want to delete this product?');">
                    <i class="fa-solid fa-trash-can"></i> Delete
                </a>
            </div>
        </div>

        <!-- Right Column: Product Information -->
        <div class="overview-info-col">
            
            <!-- Badges Row -->
            <div class="overview-badges-row">
                <?php if ($stock > 5): ?>
                    <span class="badge-stock-pill in-stock">
                        <i class="fa-solid fa-circle-check"></i> In Stock
                    </span>
                <?php elseif ($stock > 0): ?>
                    <span class="badge-stock-pill low-stock">
                        <i class="fa-solid fa-triangle-exclamation"></i> Low Stock (<?= $stock ?> left)
                    </span>
                <?php else: ?>
                    <span class="badge-stock-pill out-stock">
                        <i class="fa-solid fa-circle-xmark"></i> Out of Stock
                    </span>
                <?php endif; ?>

                <?php if ($is_bestseller): ?>
                    <span class="badge-signature-pill">
                        <i class="fa-solid fa-star"></i> SIGNATURE
                    </span>
                <?php endif; ?>
            </div>

            <!-- Product Title -->
            <h2 class="detail-product-name"><?= htmlspecialchars($row['name']) ?></h2>

            <!-- 4-Column Meta Grid -->
            <div class="overview-meta-matrix">
                <div>
                    <div class="meta-box-label">Brand</div>
                    <div class="meta-box-val"><?= htmlspecialchars($row['brand']) ?></div>
                </div>
                <div>
                    <div class="meta-box-label">Category</div>
                    <div class="meta-box-val"><?= !empty($row['cname']) ? htmlspecialchars($row['cname']) : 'Luxury' ?></div>
                </div>
                <div>
                    <div class="meta-box-label">Stock</div>
                    <div class="meta-box-val"><?= $stock ?></div>
                </div>
                <div>
                    <div class="meta-box-label">Gender</div>
                    <div class="meta-box-val"><?= htmlspecialchars($row['gender']) ?></div>
                </div>
            </div>

            <!-- Price Row -->
            <div class="overview-price-display">
                <?php if ($discount > 0): ?>
                    <span class="detail-price-old">₹<?= number_format($price) ?></span>
                    <span class="detail-price-active">₹<?= number_format($discount_price) ?></span>
                    <span class="detail-discount-tag">(<?= htmlspecialchars($row['discount']) ?>% OFF)</span>
                <?php else: ?>
                    <span class="detail-price-active">₹<?= number_format($price) ?></span>
                <?php endif; ?>
            </div>

            <!-- Description -->
            <h3 class="overview-section-heading">Product Info :</h3>
            <p class="overview-desc-paragraph">
                <?= !empty($row['descrip']) ? nl2br(htmlspecialchars($row['descrip'])) : 'No detailed description provided for this luxury timepiece.' ?>
            </p>

            <!-- Technical Details List -->
            <h3 class="overview-section-heading">Details :</h3>
            <ul class="overview-bullets-list">
                <?php if (!empty($row['movement'])): ?>
                    <li><strong>Movement:</strong> <?= htmlspecialchars($row['movement']) ?></li>
                <?php endif; ?>

                <?php if (!empty($row['case_size'])): ?>
                    <li><strong>Case Diameter:</strong> <?= htmlspecialchars($row['case_size']) ?></li>
                <?php endif; ?>

                <?php if (!empty($row['dial_color'])): ?>
                    <li><strong>Dial Color:</strong> <?= htmlspecialchars($row['dial_color']) ?></li>
                <?php endif; ?>

                <?php 
                    $strap_mat = $row['strap_material'] ?? $row['strap_type'] ?? '';
                    if (!empty($strap_mat)): 
                ?>
                    <li><strong>Strap Material:</strong> <?= htmlspecialchars($strap_mat) ?></li>
                <?php endif; ?>

                <?php if (!empty($row['strap_color'])): ?>
                    <li><strong>Strap Color:</strong> <?= htmlspecialchars($row['strap_color']) ?></li>
                <?php endif; ?>

                <?php if (!empty($row['water_resist'])): ?>
                    <li><strong>Water Resistance:</strong> <?= htmlspecialchars($row['water_resist']) ?></li>
                <?php endif; ?>

                <?php if (!empty($row['gender'])): ?>
                    <li><strong>Gender:</strong> <?= htmlspecialchars($row['gender']) ?></li>
                <?php endif; ?>
            </ul>

        </div>

    </div>

</div>

<?php
include("admin_footer.php");
?>
