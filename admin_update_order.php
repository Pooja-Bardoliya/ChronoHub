<?php
include("admin_header.php");
include("connect.php");

$id = $_GET['id'];

// Fetch order details
$query = "SELECT tbl_order.*, tbl_user.username, tbl_user.email 
          FROM tbl_order 
          LEFT JOIN tbl_user ON tbl_order.userid = tbl_user.user_id 
          WHERE tbl_order.order_id = $id";
$res = mysqli_query($con, $query);
$order = mysqli_fetch_assoc($res);

// Fetch items purchased for this order
$detail_query = "SELECT od.*, p.name, p.pic 
                 FROM tbl_order_detail od
                 INNER JOIN tbl_product p ON od.pid = p.pid
                 WHERE od.order_id = $id";
$detail_res = mysqli_query($con, $detail_query);

if (isset($_POST['btnsubmit'])) {
    $status = $_POST['txtstatus'];
    $total_amount = (float)$_POST['txttotal'];

    $update_query = "UPDATE tbl_order 
                    SET status = '$status', total_amount = '$total_amount' 
                    WHERE order_id = $id";
    $update_res = mysqli_query($con, $update_query);

    if ($update_res) {
        echo "<script>alert('Order #$id updated successfully!'); window.location.href='admin_show_order.php';</script>";
        exit();
    } else {
        echo "<script>alert('Error updating order');</script>";
    }
}
?>

<style>
  .form-page-container {
    max-width: 680px;
    margin: 0.5rem auto 2.5rem auto;
    width: 100%;
  }

  .form-header-area {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.75rem;
  }

  .form-title {
    font-family: 'Playfair Display', Georgia, serif !important;
    font-size: 1.75rem;
    font-weight: 700;
    color: #111827;
    margin-bottom: 0.2rem;
  }

  .form-subtitle {
    font-size: 0.85rem;
    color: #64748b;
  }

  .luxury-form-card {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid #edf2f7;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.04), 0 8px 10px -6px rgba(0, 0, 0, 0.02);
    padding: 2.25rem 2.5rem;
  }

  .card-top-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: #fbf7ee;
    color: #b8860b;
    border: 1px solid #ebd9b8;
    padding: 0.35rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: 0.04em;
    text-transform: uppercase;
    margin-bottom: 1.25rem;
  }

  .custom-form-group {
    margin-bottom: 1.5rem;
  }

  .custom-form-label {
    display: flex;
    align-items: center;
    gap: 0.45rem;
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: 0.05em;
    text-transform: uppercase;
    color: #334155;
    margin-bottom: 0.5rem;
  }

  .custom-form-label i {
    color: #b8860b;
  }

  .custom-form-input, .custom-form-select {
    width: 100%;
    padding: 0.75rem 1rem;
    font-size: 0.9rem;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    background-color: #ffffff;
    color: #0f172a;
    transition: all 0.2s ease;
    font-family: var(--font-body);
  }

  .custom-form-input:focus, .custom-form-select:focus {
    outline: none;
    border-color: #c5a059;
    box-shadow: 0 0 0 3px rgba(197, 160, 89, 0.15);
  }

  .btn-submit-luxury {
    background: #0f1115;
    color: #ffffff;
    border: 1.5px solid #c5a059;
    padding: 0.75rem 1.75rem;
    font-size: 0.82rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    border-radius: 10px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.55rem;
    cursor: pointer;
    transition: all 0.25s ease;
    width: 100%;
    margin-top: 1rem;
  }

  .btn-submit-luxury:hover {
    background: #1a1e26;
    border-color: #d4af37;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(197, 160, 89, 0.25);
  }

  .btn-back-luxury {
    background: #ffffff;
    color: #64748b;
    border: 1px solid #e2e8f0;
    padding: 0.6rem 1.1rem;
    font-size: 0.8rem;
    font-weight: 600;
    border-radius: 10px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.45rem;
    transition: all 0.2s ease;
  }

  .btn-back-luxury:hover {
    background: #f8fafc;
    color: #0f172a;
    border-color: #cbd5e1;
  }

  .order-item-box {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    padding: 0.85rem 1rem;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }
</style>

<div class="form-page-container">
    
    <!-- Form Header -->
    <div class="form-header-area">
        <div>
            <h1 class="form-title">Edit Order #<?= $order['order_id'] ?></h1>
            <p class="form-subtitle">Update order status and financial total details</p>
        </div>
        <a href="admin_show_order.php" class="btn-back-luxury">
            <i class="fa-solid fa-arrow-left"></i> Back to Orders
        </a>
    </div>

    <!-- Luxury Form Card -->
    <div class="luxury-form-card">
        <div class="card-top-badge">
            <i class="fa-solid fa-boxes-packing"></i> Order Details & Status Update
        </div>

        <form method="POST" action="">

            <!-- Customer & Date Info Row -->
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="custom-form-label">
                        <i class="fa-solid fa-user"></i> Customer Name
                    </label>
                    <input type="text" class="custom-form-input bg-light" value="<?= htmlspecialchars(!empty($order['username']) ? $order['username'] : 'Customer #' . $order['userid']) ?>" readonly>
                </div>
                <div class="col-md-6">
                    <label class="custom-form-label">
                        <i class="fa-solid fa-envelope"></i> Customer Email
                    </label>
                    <input type="text" class="custom-form-input bg-light" value="<?= htmlspecialchars(!empty($order['email']) ? $order['email'] : 'N/A') ?>" readonly>
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="custom-form-label">
                        <i class="fa-regular fa-calendar"></i> Order Date
                    </label>
                    <input type="text" class="custom-form-input bg-light" value="<?= date("d-m-Y H:i:s", strtotime($order['order_date'])) ?>" readonly>
                </div>
                <div class="col-md-6">
                    <label class="custom-form-label">
                        <i class="fa-solid fa-indian-rupee-sign"></i> Total Amount (₹)
                    </label>
                    <input type="number" step="0.01" class="custom-form-input" name="txttotal" value="<?= htmlspecialchars($order['total_amount']) ?>" required>
                </div>
            </div>

            <!-- Order Status Selector -->
            <div class="custom-form-group mb-4">
                <label class="custom-form-label">
                    <i class="fa-solid fa-clock-rotate-left"></i> Order Status
                </label>
                <select name="txtstatus" class="custom-form-select" required>
                    <option value="Pending" <?= ($order['status'] == 'Pending') ? 'selected' : '' ?>>Pending</option>
                    <option value="Confirmed" <?= ($order['status'] == 'Confirmed') ? 'selected' : '' ?>>Confirmed</option>
                    <option value="Shipped" <?= ($order['status'] == 'Shipped') ? 'selected' : '' ?>>Shipped</option>
                    <option value="Delivered" <?= ($order['status'] == 'Delivered') ? 'selected' : '' ?>>Delivered</option>
                    <option value="Returned" <?= ($order['status'] == 'Returned') ? 'selected' : '' ?>>Returned</option>
                    <option value="Cancelled" <?= ($order['status'] == 'Cancelled') ? 'selected' : '' ?>>Cancelled</option>
                </select>
            </div>

            <!-- Items Purchased Preview -->
            <div class="custom-form-group mb-4">
                <label class="custom-form-label">
                    <i class="fa-solid fa-bag-shopping"></i> Purchased Items
                </label>
                <?php while($item = mysqli_fetch_assoc($detail_res)): ?>
                    <div class="order-item-box">
                        <div class="d-flex align-items-center gap-3">
                            <img src="<?= htmlspecialchars($item['pic']) ?>" width="40" height="40" style="object-fit: cover; border-radius: 6px;" onerror="this.onerror=null; this.src='uploads/p1.png';">
                            <div>
                                <strong class="d-block text-dark small"><?= htmlspecialchars($item['name']) ?></strong>
                                <small class="text-muted">Quantity: <?= $item['quantity'] ?></small>
                            </div>
                        </div>
                        <strong class="text-dark small">₹<?= number_format($item['price'] * $item['quantity'], 2) ?></strong>
                    </div>
                <?php endwhile; ?>
            </div>

            <button type="submit" name="btnsubmit" class="btn-submit-luxury">
                <i class="fa-solid fa-floppy-disk me-1"></i> Update Order
            </button>
        </form>
    </div>
</div>

<?php
include("admin_footer.php");
?>
