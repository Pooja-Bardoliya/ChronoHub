<?php
  include("admin_header.php");
  include("connect.php");

  $query = "SELECT tbl_product.*, tbl_category.cname 
            FROM tbl_product 
            LEFT JOIN tbl_category ON tbl_product.cid = tbl_category.cid";
  $res = mysqli_query($con,$query);
  $count = mysqli_num_rows($res);
  $products = array();
  
  $total_products = $count;
  $total_featured = 0;
  $total_low_stock = 0;
  $total_out_stock = 0;

  while($row = mysqli_fetch_assoc($res))
  {
      $products[] = $row;
      $stk = isset($row['stock']) ? (int)$row['stock'] : 0;
      $is_feat = ($row['bestseller'] == '1' || strtolower($row['bestseller'] ?? '') === 'yes' || $row['bestseller'] === true);
      
      if($is_feat)
      {
          $total_featured++;
      }
      
      if($stk <= 0)
      {
          $total_out_stock++;
      }
      elseif($stk <= 5)
      {
          $total_low_stock++;
      }
  }
?>

<style>
  .product-page-wrapper,
  .luxury-prod-container {
    width: 100% !important;
    max-width: 100% !important;
    margin: 0.5rem 0 2.5rem 0;
  }

  .prod-header-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
    gap: 1rem;
  }

  .prod-page-title {
    font-family: 'Playfair Display', Georgia, serif;
    font-size: 2rem;
    font-weight: 700;
    color: #111827;
    margin-bottom: 0.25rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
  }

  .prod-page-subtitle {
    font-size: 0.85rem;
    color: #64748b;
  }

  /* Inventory Metric Cards Grid */
  .inv-stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.25rem;
    margin-bottom: 1.85rem;
  }

  .inv-stat-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 1.1rem 1.4rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
    transition: all 0.25s ease;
  }

  .inv-stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.05);
  }

  .inv-stat-info {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
  }

  .inv-stat-label {
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    color: #64748b;
  }

  .inv-stat-value {
    font-size: 1.65rem;
    font-weight: 800;
    color: #0f172a;
    line-height: 1.1;
  }

  .inv-stat-icon {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.05rem;
    flex-shrink: 0;
  }

  .inv-icon-products {
    background: #fbf7ee;
    color: #b8860b;
    border: 1px solid #ebd9b8;
  }

  .inv-icon-featured {
    background: #fefce8;
    color: #ca8a04;
    border: 1px solid #fef08a;
  }

  .inv-icon-low {
    background: #fffbeb;
    color: #d97706;
    border: 1px solid #fde68a;
  }

  .inv-icon-out {
    background: #fef2f2;
    color: #ef4444;
    border: 1px solid #fecaca;
  }

  @media (max-width: 1024px) {
    .inv-stats-grid {
      grid-template-columns: repeat(2, 1fr);
    }
  }

  @media (max-width: 576px) {
    .inv-stats-grid {
      grid-template-columns: 1fr;
    }
  }

  .btn-add-product-luxury {
    background: #111827;
    color: #d4af37;
    border: 1px solid #1f2937;
    padding: 0.75rem 1.4rem;
    font-size: 0.82rem;
    font-weight: 700;
    letter-spacing: 0.05em;
    text-transform: uppercase;
    border-radius: 10px;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    text-decoration: none;
    transition: all 0.25s ease;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
  }

  .btn-add-product-luxury:hover {
    background: #000000;
    color: #ffffff;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
  }

  /* Table Container Card */
  .luxury-table-card {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid #edf2f7;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.04), 0 8px 10px -6px rgba(0, 0, 0, 0.02);
    overflow: hidden;
  }

  .luxury-prod-table-responsive {
    overflow-x: auto;
    width: 100%;
  }

  .luxury-prod-table {
    width: 100%;
    border-collapse: collapse;
    text-align: left;
    white-space: nowrap;
  }

  .luxury-prod-table thead {
    background: #fafbfc;
    border-bottom: 1.5px solid #edf2f7;
  }

  .luxury-prod-table th {
    padding: 1rem 1.15rem;
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    color: #64748b;
  }

  .luxury-prod-table tbody tr {
    border-bottom: 1px solid #f1f5f9;
    transition: background-color 0.2s ease;
  }

  .luxury-prod-table tbody tr:hover {
    background-color: #fdfaf3;
  }

  .luxury-prod-table tbody tr:last-child {
    border-bottom: none;
  }

  .luxury-prod-table td {
    padding: 0.95rem 1.15rem;
    vertical-align: middle;
    color: #1e293b;
    font-size: 0.86rem;
  }

  /* Serial Number */
  .sr-no-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 28px;
    height: 28px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-weight: 700;
    font-size: 0.76rem;
    color: #64748b;
  }

  /* Product Image Thumbnail Frame */
  .prod-img-frame {
    width: 48px;
    height: 48px;
    border-radius: 8px;
    overflow: hidden;
    border: 1px solid #e2e8f0;
    background: #f8fafc;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    margin: 0 auto;
  }

  .prod-img-frame img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.25s ease;
  }

  .luxury-prod-table tbody tr:hover .prod-img-frame img {
    transform: scale(1.08);
  }

  /* Combined Product Details Column */
  .prod-info-col {
    display: flex;
    flex-direction: column;
    gap: 0.2rem;
    min-width: 160px;
    max-width: 240px;
  }

  .prod-name-title {
    font-weight: 700;
    color: #0f172a;
    font-size: 0.88rem;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    display: block;
    line-height: 1.3;
  }

  .prod-meta-sub {
    font-size: 0.76rem;
    color: #64748b;
    font-weight: 500;
    line-height: 1.2;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }

  .cell-plain-text {
    font-size: 0.85rem;
    font-weight: 500;
    color: #475569;
    background: transparent !important;
  }

  .cell-brand {
    font-weight: 600;
    color: #1e293b;
  }

  /* Tag Pills for Stock */
  .tag-pill {
    display: inline-block;
    padding: 0.22rem 0.6rem;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 600;
    background: #f1f5f9;
    color: #475569;
    border: 1px solid #e2e8f0;
  }

  .tag-stock {
    background: #f0fdf4;
    color: #15803d;
    border-color: #bbf7d0;
    font-weight: 700;
  }

  .tag-stock-low {
    background: #fef2f2;
    color: #b91c1c;
    border-color: #fecaca;
    font-weight: 700;
  }

  .tag-movement {
    background: #f8fafc;
    color: #334155;
    border-color: #e2e8f0;
    font-weight: 600;
  }

  /* Price & Discount */
  .price-cell {
    display: flex;
    flex-direction: column;
    gap: 0.15rem;
  }

  .price-main {
    font-weight: 800;
    color: #0f172a;
    font-size: 0.92rem;
    font-family: var(--font-sans);
  }

  .price-discount-pill {
    font-size: 0.68rem;
    font-weight: 700;
    color: #dc2626;
    background: #fef2f2;
    border: 1px solid #fecaca;
    padding: 0.1rem 0.4rem;
    border-radius: 4px;
    width: fit-content;
  }

  /* Specs Cell */
  .spec-cell {
    display: flex;
    flex-direction: column;
    gap: 0.1rem;
    font-size: 0.8rem;
  }

  .spec-primary {
    font-weight: 600;
    color: #1e293b;
  }

  .spec-secondary {
    font-size: 0.74rem;
    color: #64748b;
  }

  .spec-pill-water {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    font-size: 0.76rem;
    font-weight: 600;
    color: #0284c7;
    background: #f0f9ff;
    border: 1px solid #e0f2fe;
    padding: 0.2rem 0.55rem;
    border-radius: 6px;
  }

  /* Description Truncated */
  .prod-desc-truncated {
    display: block;
    max-width: 160px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    color: #64748b;
    font-size: 0.8rem;
    cursor: help;
  }

  /* BestSeller Badges */
  .badge-bestseller-yes {
    background: #fef3c7;
    color: #b45309;
    border: 1px solid #fde68a;
    padding: 0.22rem 0.65rem;
    border-radius: 20px;
    font-size: 0.74rem;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
  }

  .badge-bestseller-no {
    background: #f8fafc;
    color: #94a3b8;
    border: 1px solid #e2e8f0;
    padding: 0.22rem 0.65rem;
    border-radius: 20px;
    font-size: 0.74rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
  }

  /* Action Icon Buttons */
  .actions-cell-wrapper {
    display: inline-flex;
    align-items: center;
    justify-content: flex-end;
    gap: 0.45rem;
  }

  .btn-view-luxury {
    width: 34px;
    height: 34px;
    border-radius: 8px;
    background: #f8fafc;
    color: #475569;
    border: 1px solid #e2e8f0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all 0.2s ease;
    font-size: 0.85rem;
  }

  .btn-view-luxury:hover {
    background: #0f172a;
    color: #ffffff;
    border-color: #0f172a;
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(15, 23, 42, 0.15);
  }

  .btn-edit-luxury {
    width: 34px;
    height: 34px;
    border-radius: 8px;
    background: #fefcf6;
    color: #b8860b;
    border: 1px solid #fdecc8;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all 0.25s ease;
    font-size: 0.85rem;
  }

  .btn-edit-luxury:hover {
    background: #b8860b;
    color: #ffffff;
    border-color: #b8860b;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(184, 134, 11, 0.2);
  }

  .btn-delete-luxury {
    width: 34px;
    height: 34px;
    border-radius: 8px;
    background: #fef2f2;
    color: #dc2626;
    border: 1px solid #fecaca;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all 0.25s ease;
    font-size: 0.85rem;
  }

  .btn-delete-luxury:hover {
    background: #dc2626;
    color: #ffffff;
    border-color: #dc2626;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(220, 38, 38, 0.2);
  }

  /* Empty state */
  .empty-product-state {
    text-align: center;
    padding: 3.5rem 1.5rem;
    color: #94a3b8;
  }
  .empty-product-icon {
    font-size: 2.5rem;
    color: #cbd5e1;
    margin-bottom: 0.75rem;
    display: block;
  }
</style>

<div class="luxury-prod-container">

    <!-- Header Row -->
    <div class="prod-header-row">
        <div>
            <h1 class="prod-page-title">
                Products Inventory
            </h1>
            <p class="prod-page-subtitle">Manage your luxury watch collection, monitor stock availability, update pricing, and organize products with precision.</p>
        </div>
        <a href="admin_add_product.php" class="btn-add-product-luxury">
            <i class="fa-solid fa-plus"></i> Add Product
        </a>
    </div>

    <!-- 4 Stats Metric Cards Grid -->
    <div class="inv-stats-grid">
        <div class="inv-stat-card">
            <div class="inv-stat-info">
                <span class="inv-stat-label">Products</span>
                <span class="inv-stat-value"><?= $total_products ?></span>
            </div>
            <div class="inv-stat-icon inv-icon-products">
                <i class="fa-solid fa-box"></i>
            </div>
        </div>

        <div class="inv-stat-card">
            <div class="inv-stat-info">
                <span class="inv-stat-label">Featured</span>
                <span class="inv-stat-value"><?= $total_featured ?></span>
            </div>
            <div class="inv-stat-icon inv-icon-featured">
                <i class="fa-solid fa-star"></i>
            </div>
        </div>

        <div class="inv-stat-card">
            <div class="inv-stat-info">
                <span class="inv-stat-label">Low Stock</span>
                <span class="inv-stat-value"><?= $total_low_stock ?></span>
            </div>
            <div class="inv-stat-icon inv-icon-low">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
        </div>

        <div class="inv-stat-card">
            <div class="inv-stat-info">
                <span class="inv-stat-label">Out of Stock</span>
                <span class="inv-stat-value"><?= $total_out_stock ?></span>
            </div>
            <div class="inv-stat-icon inv-icon-out">
                <i class="fa-solid fa-circle-xmark"></i>
            </div>
        </div>
    </div>

    <!-- Luxury Table Card -->
    <div class="luxury-table-card">
        <div class="luxury-prod-table-responsive">
            <table class="luxury-prod-table">
                <thead>
                    <tr>
                        <th style="text-align: center; width: 55px;">Sr No</th>
                        <th style="text-align: center; width: 65px;">Image</th>
                        <th>Product Details</th>
                        <th>Brand</th>
                        <th>Category</th>
                        <th>Gender</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Bestseller</th>
                        <th style="text-align: right; padding-right: 1.5rem;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($count == 0): ?>
                    <tr>
                        <td colspan="10" class="empty-product-state">
                            <i class="fa-solid fa-box-open empty-product-icon"></i>
                            <p style="font-weight: 600; font-size: 1rem; color: #475569; margin-bottom: 0.25rem;">No products found</p>
                            <p style="font-size: 0.82rem;">Click "+ Add Product" to create your first luxury timepiece.</p>
                        </td>
                    </tr>
                    <?php else: ?>
                    <?php
                      $i = 1;
                      foreach ($products as $p):
                    ?>
                    <tr>
                        <!-- 1. Serial Number -->
                        <td style="text-align: center;">
                            <span class="sr-no-badge"><?= $i++ ?></span>
                        </td>

                        <!-- 2. Product Image Thumbnail -->
                        <td style="text-align: center; width: 65px;">
                            <div class="prod-img-frame">
                                <img src="<?= htmlspecialchars($p['pic']) ?>" alt="<?= htmlspecialchars($p['name']) ?>">
                            </div>
                        </td>

                        <!-- 3. Product Details (Name + Movement • Case Size) -->
                        <td>
                            <div class="prod-info-col">
                                <span class="prod-name-title" title="<?= htmlspecialchars($p['name']) ?>">
                                    <?= htmlspecialchars($p['name']) ?>
                                </span>
                                <span class="prod-meta-sub">
                                    <?= !empty($p['movement']) ? htmlspecialchars($p['movement']) : 'Quartz' ?><?= !empty($p['case_size']) ? ' • ' . htmlspecialchars($p['case_size']) : '' ?>
                                </span>
                            </div>
                        </td>

                        <!-- 4. Brand -->
                        <td class="cell-plain-text cell-brand">
                            <?= htmlspecialchars($p['brand']) ?>
                        </td>

                        <!-- 5. Category -->
                        <td class="cell-plain-text">
                            <?= !empty($p['cname']) ? htmlspecialchars($p['cname']) : 'Uncategorized' ?>
                        </td>

                        <!-- 6. Gender -->
                        <td class="cell-plain-text">
                            <?= htmlspecialchars($p['gender']) ?>
                        </td>

                        <!-- 7. Price & Discount -->
                        <td>
                            <div class="price-cell">
                                <span class="price-main">₹<?= number_format((float)$p['price']) ?></span>
                                <?php if (!empty($p['discount']) && (float)$p['discount'] > 0): ?>
                                    <?php $disc_p = (float)$p['price'] * (1 - ((float)$p['discount'] / 100)); ?>
                                    <span class="price-discount-pill"><?= htmlspecialchars($p['discount']) ?>% OFF</span>
                                    <small style="color: #059669; font-weight: 600; font-size: 0.75rem;">(₹<?= number_format($disc_p) ?>)</small>
                                <?php endif; ?>
                            </div>
                        </td>

                        <!-- 8. Stock Quantity -->
                        <td>
                            <?php 
                                $stk = isset($p['stock']) ? (int)$p['stock'] : 0;
                                if ($stk <= 5 && $stk > 0): 
                            ?>
                                <span class="tag-pill tag-stock-low"><?= $stk ?> Units</span>
                            <?php elseif ($stk > 5): ?>
                                <span class="tag-pill tag-stock"><?= $stk ?> Units</span>
                            <?php else: ?>
                                <span class="tag-pill tag-stock-low">Out of Stock</span>
                            <?php endif; ?>
                        </td>

                        <!-- 9. BestSeller -->
                        <td>
                            <?php if ($p['bestseller'] == '1' || strtolower($p['bestseller'] ?? '') === 'yes' || $p['bestseller'] === true): ?>
                                <span class="badge-bestseller-yes"><i class="fa-solid fa-star"></i> Signature</span>
                            <?php else: ?>
                                <span class="badge-bestseller-no">Standard</span>
                            <?php endif; ?>
                        </td>

                        <!-- 10. Actions (View, Edit, Delete) -->
                        <td style="text-align: right; padding-right: 1.5rem;">
                            <div class="actions-cell-wrapper">
                                <a href="admin_view_product.php?id=<?= $p['pid'] ?>" class="btn-view-luxury" title="View Product Overview">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="admin_update_product.php?id=<?= $p['pid'] ?>" class="btn-edit-luxury" title="Edit Product">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <a href="admin_delete_product.php?id=<?= $p['pid'] ?>" class="btn-delete-luxury" title="Delete Product" onclick="return confirm('Are you sure you want to delete this product?');">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<?php
include("admin_footer.php");
?>
