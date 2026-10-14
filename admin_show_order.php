<?php
include("admin_header.php");
include("connect.php");

$query = "SELECT tbl_order.*, tbl_user.username, tbl_user.email 
          FROM tbl_order 
          LEFT JOIN tbl_user ON tbl_order.userid = tbl_user.user_id 
          ORDER BY tbl_order.order_id DESC";
$res = mysqli_query($con, $query);
$count = mysqli_num_rows($res);
?>

<style>
  .orders-page-wrapper {
    width: 100% !important;
    max-width: 100% !important;
    margin: 0.5rem 0 2.5rem 0;
  }

  .orders-header-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.75rem;
    flex-wrap: wrap;
    gap: 1rem;
  }

  .orders-page-title {
    font-family: 'Playfair Display', Georgia, serif !important;
    font-size: 1.85rem;
    font-weight: 700;
    color: #111827;
    margin-bottom: 0.2rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
  }

  .orders-count-badge {
    background: #fbf7ee;
    color: #b8860b;
    border: 1px solid #ebd9b8;
    font-size: 0.75rem;
    font-family: var(--font-sans);
    font-weight: 700;
    padding: 0.25rem 0.65rem;
    border-radius: 20px;
    letter-spacing: 0.04em;
    vertical-align: middle;
  }

  .orders-page-subtitle {
    font-size: 0.85rem;
    color: #64748b;
  }

  /* Luxury Table Card */
  .luxury-table-card {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid #edf2f7;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.04), 0 8px 10px -6px rgba(0, 0, 0, 0.02);
    overflow: hidden;
  }

  .luxury-orders-table {
    width: 100%;
    border-collapse: collapse;
    text-align: left;
  }

  .luxury-orders-table thead {
    background: #fafbfc;
    border-bottom: 1.5px solid #edf2f7;
  }

  .luxury-orders-table th {
    padding: 1rem 1.25rem;
    font-size: 0.74rem;
    font-weight: 700;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    color: #64748b;
  }

  .luxury-orders-table tbody tr {
    border-bottom: 1px solid #f1f5f9;
    transition: background-color 0.2s ease;
  }

  .luxury-orders-table tbody tr:hover {
    background-color: #fdfaf3;
  }

  .luxury-orders-table tbody tr:last-child {
    border-bottom: none;
  }

  .luxury-orders-table td {
    padding: 1.15rem 1.25rem;
    vertical-align: middle;
    color: #1e293b;
    font-size: 0.9rem;
  }

  .order-id-tag {
    font-weight: 700;
    color: #0f172a;
    font-family: var(--font-nav, sans-serif);
  }

  .customer-name {
    font-weight: 700;
    color: #0f172a;
    font-size: 0.92rem;
    display: block;
    line-height: 1.25;
  }

  .customer-email {
    font-size: 0.8rem;
    color: #64748b;
    display: block;
    margin-top: 2px;
  }

  .order-item-row {
    display: flex;
    align-items: center;
    gap: 0.65rem;
    margin-bottom: 0.45rem;
  }
  .order-item-row:last-child {
    margin-bottom: 0;
  }

  .order-item-thumb {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    object-fit: cover;
    background: #f8fafc;
    flex-shrink: 0;
  }

  .order-item-title {
    font-weight: 600;
    font-size: 0.88rem;
    color: #1e293b;
  }

  .order-item-meta {
    font-size: 0.78rem;
    color: #64748b;
  }

  /* Action Buttons */
  .btn-edit-luxury {
    background: linear-gradient(135deg, #ffffff 0%, #fffdf5 100%);
    color: #b8860b;
    border: 1px solid #ebd9b8;
    padding: 0.46rem 0.75rem;
    border-radius: 8px;
    font-size: 0.85rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all 0.25s ease;
    box-shadow: 0 2px 5px rgba(212, 175, 55, 0.12);
  }

  .btn-edit-luxury i {
    color: #b8860b;
    transition: transform 0.25s ease, color 0.25s ease;
  }

  .btn-edit-luxury:hover {
    background: linear-gradient(135deg, #d4af37 0%, #c59b27 100%);
    color: #ffffff;
    border-color: #a67c00;
    box-shadow: 0 4px 14px rgba(184, 134, 11, 0.35);
    transform: translateY(-2px);
  }

  .btn-edit-luxury:hover i {
    color: #ffffff;
    transform: scale(1.15) rotate(-6deg);
  }

  .btn-delete-luxury {
    background: linear-gradient(135deg, #fffafa 0%, #fee2e2 100%);
    color: #dc2626;
    border: 1px solid #fecaca;
    padding: 0.46rem 0.75rem;
    border-radius: 8px;
    font-size: 0.85rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all 0.25s ease;
    box-shadow: 0 2px 5px rgba(220, 38, 38, 0.08);
  }

  .btn-delete-luxury i {
    color: #dc2626;
    transition: transform 0.25s ease, color 0.25s ease;
  }

  .btn-delete-luxury:hover {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: #ffffff;
    border-color: #dc2626;
    box-shadow: 0 4px 14px rgba(220, 38, 38, 0.35);
    transform: translateY(-2px);
  }

  .btn-delete-luxury:hover i {
    color: #ffffff;
    transform: scale(1.15) rotate(6deg);
  }

  .actions-cell-wrapper {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
  }
</style>

<div class="orders-page-wrapper">
    
    <!-- Page Header Row -->
    <div class="orders-header-row">
        <div>
            <h1 class="orders-page-title">
                List of Orders <span class="orders-count-badge"><?= $count ?> Total</span>
            </h1>
            <div class="orders-page-subtitle">View and inspect customer timepiece orders, status, and transaction totals</div>
        </div>
    </div>

    <!-- Luxury Table Card -->
    <div class="luxury-table-card">
        <?php if ($count > 0): ?>
            <div class="table-responsive">
                <table class="luxury-orders-table">
                    <thead>
                        <tr>
                            <th style="width: 90px; white-space: nowrap;">ORDER ID</th>
                            <th style="width: 170px;">CUSTOMER</th>
                            <th style="width: 110px; white-space: nowrap;">DATE</th>
                            <th>ITEMS PURCHASED</th>
                            <th style="width: 130px; white-space: nowrap;">TOTAL AMOUNT</th>
                            <th style="width: 110px; white-space: nowrap;" class="text-center">STATUS</th>
                            <th style="width: 100px; text-align: right;" class="pe-3">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        while($order = mysqli_fetch_assoc($res)): 
                            $order_id = $order['order_id'];
                            $detail_query = "SELECT od.*, p.name, p.pic 
                                             FROM tbl_order_detail od
                                             INNER JOIN tbl_product p ON od.pid = p.pid
                                             WHERE od.order_id='$order_id'";
                            $detail_res = mysqli_query($con, $detail_query);
                        ?>
                            <tr>
                                <td style="white-space: nowrap;">
                                    <span class="order-id-tag">#<?= $order['order_id'] ?></span>
                                </td>
                                <td>
                                    <span class="customer-name"><?= htmlspecialchars(!empty($order['username']) ? $order['username'] : 'Customer #' . $order['userid']) ?></span>
                                    <span class="customer-email"><?= htmlspecialchars(!empty($order['email']) ? $order['email'] : 'N/A') ?></span>
                                </td>
                                <td style="white-space: nowrap;">
                                    <span style="font-size: 0.85rem; color: #475569; font-weight: 500;">
                                        <?= date("d-m-Y", strtotime($order['order_date'])) ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="py-1">
                                        <?php while($item = mysqli_fetch_assoc($detail_res)): ?>
                                            <div class="order-item-row">
                                                <img src="<?= htmlspecialchars($item['pic']) ?>" class="order-item-thumb" onerror="this.onerror=null; this.src='uploads/p1.png';">
                                                <div>
                                                    <span class="order-item-title d-block"><?= htmlspecialchars($item['name']) ?></span>
                                                    <span class="order-item-meta">Qty: <?= $item['quantity'] ?> &times; &#8377;<?= number_format($item['price'], 2) ?></span>
                                                </div>
                                            </div>
                                        <?php endwhile; ?>
                                    </div>
                                </td>
                                <td style="white-space: nowrap;">
                                    <strong style="font-size: 0.95rem; color: #059669; font-weight: 700;">
                                        &#8377;<?= number_format($order['total_amount'], 2) ?>
                                    </strong>
                                </td>
                                <td class="text-center" style="white-space: nowrap;">
                                    <?php
                                    $st = $order['status'] ?? 'Pending';
                                    $status_styles = [
                                        'Processing' => 'background-color: #e0f2fe; color: #0284c7;',
                                        'Shipped'    => 'background-color: #f3e8ff; color: #7e22ce;',
                                        'Completed'  => 'background-color: #dcfce7; color: #15803d;',
                                        'Delivered'  => 'background-color: #dcfce7; color: #15803d;',
                                        'Cancelled'  => 'background-color: #fee2e2; color: #b91c1c;',
                                        'Pending'    => 'background-color: #fef3c7; color: #b45309;',
                                        'Confirmed'  => 'background-color: #e0f2fe; color: #0284c7;',
                                    ];
                                    $badge_style = $status_styles[$st] ?? 'background-color: #e0f2fe; color: #0284c7;';
                                    ?>
                                    <span class="badge rounded-pill font-nav px-3 py-1.5 fw-semibold" style="<?= $badge_style ?> font-size: 0.8rem;">
                                        <?= htmlspecialchars(ucfirst(strtolower($st))) ?>
                                    </span>
                                </td>
                                <td style="text-align: right; white-space: nowrap;" class="pe-3">
                                    <div class="actions-cell-wrapper">
                                        <a href="admin_update_order.php?id=<?= $order['order_id'] ?>" class="btn-edit-luxury" title="Edit Order">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <a href="admin_delete_order.php?id=<?= $order['order_id'] ?>" class="btn-delete-luxury" onclick="return confirm('Are you sure you want to delete Order #<?= $order['order_id'] ?>?');" title="Delete Order">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="fa-solid fa-box-open text-muted mb-3" style="font-size: 2.5rem;"></i>
                <h5 class="fw-bold text-dark mb-1">No Orders Found</h5>
                <p class="text-muted small">No customer orders have been recorded yet.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
include("admin_footer.php");
?>