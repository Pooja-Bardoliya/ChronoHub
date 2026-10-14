<?php
    include('admin_header.php');
    include('connect.php');
    $query = "SELECT * FROM tbl_user";
    $res_user = mysqli_query($con,$query);
    $count_user = mysqli_num_rows($res_user);

    $query = "SELECT * FROM tbl_category";
    $res_category = mysqli_query($con,$query);
    $count_category = mysqli_num_rows($res_category);

    $query = "SELECT * FROM tbl_product";
    $res_product = mysqli_query($con,$query);
    $count_product = mysqli_num_rows($res_product);

    $query = "SELECT * FROM tbl_order";
    $res_order = mysqli_query($con,$query);
    $count_order = mysqli_num_rows($res_order);
    $total_orders = $count_order;

    $query = "SELECT SUM(total_amount) as total_rev FROM tbl_order";
    $res_revenue = mysqli_query($con,$query);
    $row_revenue = $res_revenue ? mysqli_fetch_assoc($res_revenue) : null;
    $total_revenue = (float)($row_revenue['total_rev'] ?? 0);

    // Time-based greeting helper
    $hour = (int)date('H');
    if ($hour < 12) {
        $greeting_prefix = "GOOD MORNING,";
    } elseif ($hour < 17) {
        $greeting_prefix = "GOOD AFTERNOON,";
    } else {
        $greeting_prefix = "GOOD EVENING,";
    }

    if (!function_exists('format_price')) {
        function format_price($amount) {
            return '₹' . number_format((float)$amount, 2);
        }
    }

    // Today's Revenue Query
    $current_revenue = 0;
    $qry_cur_rev = "SELECT SUM(total_amount) as rev FROM tbl_order WHERE DATE(order_date) = CURDATE();";
    $res_curr = mysqli_query($con, $qry_cur_rev);
    if ($res_curr && $row_curr = mysqli_fetch_assoc($res_curr)) {
        $current_revenue = (float)($row_curr['rev'] ?? 0);
    }
    
    // Today Summary Stats
    $today_order_count = 0;
    $today_revenue_val = 0;
    $qry_today = "SELECT COUNT(*) as cnt, SUM(total_amount) as rev FROM tbl_order WHERE DATE(order_date) = CURDATE()";
    $res_tc = mysqli_query($con, $qry_today);
    if ($res_tc && $row_tc = mysqli_fetch_assoc($res_tc)) {
        $today_order_count = (int)($row_tc['cnt'] ?? 0);
        $today_revenue_val = (float)($row_tc['rev'] ?? 0);
    }

    // 1. Today's Chart Data
    date_default_timezone_set('Asia/Kolkata');

    $today_slots = [
        ['label' => '00:00', 'start' => '00:00:00', 'end' => '00:59:59'],
        ['label' => '03:00', 'start' => '01:00:00', 'end' => '02:59:59'],
        ['label' => '05:00', 'start' => '03:00:00', 'end' => '04:59:59'],
        ['label' => '07:00', 'start' => '05:00:00', 'end' => '06:59:59'],
        ['label' => '09:00', 'start' => '07:00:00', 'end' => '08:59:59'],
        ['label' => '11:00', 'start' => '09:00:00', 'end' => '10:59:59'],
        ['label' => '13:00', 'start' => '11:00:00', 'end' => '12:59:59'],
        ['label' => '15:00', 'start' => '13:00:00', 'end' => '14:59:59'],
        ['label' => '17:00', 'start' => '15:00:00', 'end' => '16:59:59'],
        ['label' => '19:00', 'start' => '17:00:00', 'end' => '18:59:59'],
        ['label' => '21:00', 'start' => '19:00:00', 'end' => '20:59:59'],
        ['label' => '23:00', 'start' => '21:00:00', 'end' => '22:59:59'],
        ['label' => '24:00', 'start' => '23:00:00', 'end' => '23:59:59']
    ];

    $today_labels = [];
    $today_rev_points = [];
    $today_ord_points = [];

    foreach ($today_slots as $ts) {
        $today_labels[] = $ts['label'];

        $qry = "SELECT COUNT(*) AS orders, SUM(total_amount) AS revenue 
                FROM tbl_order 
                WHERE DATE(order_date) = CURDATE() 
                  AND TIME(order_date) BETWEEN '{$ts['start']}' AND '{$ts['end']}'";

        $result = mysqli_query($con, $qry);
        if ($result && $row = mysqli_fetch_assoc($result)) {
            $today_ord_points[] = (int)($row['orders'] ?? 0);
            $today_rev_points[] = round((float)($row['revenue'] ?? 0), 2);
        } else {
            $today_ord_points[] = 0;
            $today_rev_points[] = 0;
        }
    }

    // Monthly Chart Points
    $this_month_orders = 0;
    $this_month_rev_val = 0;
    $qry_month = "SELECT COUNT(*) as cnt, SUM(total_amount) as rev FROM tbl_order WHERE YEAR(order_date) = YEAR(CURRENT_DATE()) AND MONTH(order_date) = MONTH(CURRENT_DATE())";
    $res_tm_stats = mysqli_query($con, $qry_month);
    if ($res_tm_stats && $row_tm_stats = mysqli_fetch_assoc($res_tm_stats)) {
        $this_month_orders = (int)($row_tm_stats['cnt'] ?? 0);
        $this_month_rev_val = (float)($row_tm_stats['rev'] ?? 0);
    }

    $month_name = date('M');
    $days_in_month = (int)date('t');

    $date_slots = [
        ['label' => "$month_name 1",  'start' => 1,  'end' => 1],
        ['label' => "$month_name 5",  'start' => 2,  'end' => 5],
        ['label' => "$month_name 10", 'start' => 6,  'end' => 10],
        ['label' => "$month_name 15", 'start' => 11, 'end' => 15],
        ['label' => "$month_name 20", 'start' => 16, 'end' => 20],
        ['label' => "$month_name 25", 'start' => 21, 'end' => 25],
        ['label' => "$month_name $days_in_month", 'start' => 26, 'end' => $days_in_month]
    ];

    $monthly_labels = [];
    $monthly_rev_points = [];
    $monthly_ord_points = [];
    $current_day = (int)date('j');

    foreach ($date_slots as $ds) {
        $monthly_labels[] = $ds['label'];
        if ($ds['start'] > $current_day) {
            $monthly_rev_points[] = 0;
            $monthly_ord_points[] = 0;
            continue;
        }

        $sql = "SELECT SUM(total_amount) as rev, COUNT(*) as cnt FROM tbl_order 
                WHERE YEAR(order_date) = YEAR(CURRENT_DATE()) 
                  AND MONTH(order_date) = MONTH(CURRENT_DATE()) 
                  AND DAY(order_date) BETWEEN {$ds['start']} AND {$ds['end']}";
        
        $res = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($res);
        $monthly_rev_points[] = round((float)($row['rev'] ?? 0), 2);
        $monthly_ord_points[] = (int)($row['cnt'] ?? 0);
    }

    // Annual Chart Points
    $annual_rev_points = array_fill(0, 12, 0);
    $annual_ord_points = array_fill(0, 12, 0);
    $current_month = (int)date('n');

    $qry_annual = "SELECT MONTH(order_date) as m, SUM(total_amount) as rev, COUNT(*) as cnt FROM tbl_order WHERE YEAR(order_date) = YEAR(CURRENT_DATE()) GROUP BY MONTH(order_date)";
    $res_annual = mysqli_query($con, $qry_annual);
    if ($res_annual) {
        while ($row = mysqli_fetch_assoc($res_annual)) {
            $m = (int)$row['m'];
            if ($m <= $current_month) {
                $annual_rev_points[$m - 1] = round((float)($row['rev'] ?? 0), 2);
                $annual_ord_points[$m - 1] = (int)($row['cnt'] ?? 0);
            }
        }
    }
?>

<style>
  /* ========================================================
     WATCHHUB LUXURY ADMIN - LIGHT & ELEGANT 5 STAT CARDS GRID
     ======================================================== */
  .stat-grid-5 {
    display: grid;
    grid-template-columns: repeat(5, minmax(0, 1fr));
    gap: 1.25rem;
    width: 100%;
    margin-top: 0.5rem;
  }

  @media (max-width: 1300px) {
    .stat-grid-5 {
      grid-template-columns: repeat(3, 1fr);
    }
  }

  @media (max-width: 860px) {
    .stat-grid-5 {
      grid-template-columns: repeat(2, 1fr);
    }
  }

  @media (max-width: 540px) {
    .stat-grid-5 {
      grid-template-columns: 1fr;
    }
  }

  /* Ultra-Attractive Light Modern Luxury Card */
  .attractive-stat-card {
    position: relative;
    border-radius: 12px !important;
    padding: 1.45rem 1.35rem 1.25rem 1.35rem;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    min-height: 162px;
    overflow: hidden;
    background: #ffffff;
    border: none !important;
    box-shadow: 0 4px 20px -4px rgba(15, 23, 42, 0.04), 0 1px 3px rgba(15, 23, 42, 0.02);
    transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
    z-index: 1;
  }

  /* Distinct Light Ambient Gradients & Glows per Card */
  .card-theme-revenue {
    background: linear-gradient(160deg, #ffffff 0%, #ffffff 65%, #fffdf5 100%);
    border: none !important;
  }
  .card-theme-revenue:hover {
    transform: translateY(-5px);
    box-shadow: 0 16px 30px -6px rgba(245, 158, 11, 0.12), 0 4px 10px rgba(15, 23, 42, 0.02);
  }

  .card-theme-orders {
    background: linear-gradient(160deg, #ffffff 0%, #ffffff 65%, #f6fdf9 100%);
    border: none !important;
  }
  .card-theme-orders:hover {
    transform: translateY(-5px);
    box-shadow: 0 16px 30px -6px rgba(16, 185, 129, 0.12), 0 4px 10px rgba(15, 23, 42, 0.02);
  }

  .card-theme-customers {
    background: linear-gradient(160deg, #ffffff 0%, #ffffff 65%, #fffbf5 100%);
    border: none !important;
  }
  .card-theme-customers:hover {
    transform: translateY(-5px);
    box-shadow: 0 16px 30px -6px rgba(249, 115, 22, 0.12), 0 4px 10px rgba(15, 23, 42, 0.02);
  }

  .card-theme-products {
    background: linear-gradient(160deg, #ffffff 0%, #ffffff 65%, #faf8ff 100%);
    border: none !important;
  }
  .card-theme-products:hover {
    transform: translateY(-5px);
    box-shadow: 0 16px 30px -6px rgba(139, 92, 246, 0.12), 0 4px 10px rgba(15, 23, 42, 0.02);
  }

  .card-theme-categories {
    background: linear-gradient(160deg, #ffffff 0%, #ffffff 65%, #f4f8ff 100%);
    border: none !important;
  }
  .card-theme-categories:hover {
    transform: translateY(-5px);
    box-shadow: 0 16px 30px -6px rgba(59, 130, 246, 0.12), 0 4px 10px rgba(15, 23, 42, 0.02);
  }

  /* Decorative Ambient Watermark in Background - Soft & Subtle */
  .card-watermark-icon {
    position: absolute;
    right: -10px;
    bottom: -12px;
    font-size: 5rem;
    opacity: 0.04;
    pointer-events: none;
    transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    transform: rotate(-12deg);
    z-index: 0;
  }

  .attractive-stat-card:hover .card-watermark-icon {
    opacity: 0.08;
    transform: scale(1.15) rotate(0deg) translate(-6px, -6px);
  }

  /* Card Content Layer */
  .card-inner-content {
    position: relative;
    z-index: 2;
    display: flex;
    flex-direction: column;
    height: 100%;
    justify-content: space-between;
  }

  /* Card Header */
  .stat-card-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 0.75rem;
  }

  .stat-card-title-group {
    display: flex;
    flex-direction: column;
    gap: 0.3rem;
  }

  .stat-card-label {
    font-size: 0.72rem;
    font-weight: 800;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: #64748b;
    margin: 0;
  }

  /* Trend / Status Pills - Light, Clean, High Contrast */
  .stat-trend-pill {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: 0.68rem;
    font-weight: 700;
    padding: 2px 8px;
    border-radius: 20px;
    width: fit-content;
    line-height: 1.3;
  }

  .pill-revenue { background: #fef3c7; color: #b45309; }
  .pill-orders { background: #dcfce7; color: #047857; }
  .pill-customers { background: #ffedd5; color: #c2410c; }
  .pill-products { background: #f3e8ff; color: #6d28d9; }
  .pill-categories { background: #e0f2fe; color: #0369a1; }

  /* Light Modern Icon Badges (Clean Pastel Backgrounds with Crisp Accent Icons) */
  .stat-glow-badge {
    width: 44px;
    height: 44px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    flex-shrink: 0;
  }

  .badge-glow-gold {
    background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
    border: 1px solid rgba(245, 158, 11, 0.22);
    color: #d97706;
    box-shadow: 0 4px 12px -2px rgba(245, 158, 11, 0.15);
  }

  .badge-glow-green {
    background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
    border: 1px solid rgba(16, 185, 129, 0.22);
    color: #059669;
    box-shadow: 0 4px 12px -2px rgba(16, 185, 129, 0.15);
  }

  .badge-glow-amber {
    background: linear-gradient(135deg, #fff7ed 0%, #ffedd5 100%);
    border: 1px solid rgba(249, 115, 22, 0.22);
    color: #ea580c;
    box-shadow: 0 4px 12px -2px rgba(249, 115, 22, 0.15);
  }

  .badge-glow-purple {
    background: linear-gradient(135deg, #faf5ff 0%, #f3e8ff 100%);
    border: 1px solid rgba(139, 92, 246, 0.22);
    color: #7c3aed;
    box-shadow: 0 4px 12px -2px rgba(139, 92, 246, 0.15);
  }

  .badge-glow-blue {
    background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
    border: 1px solid rgba(59, 130, 246, 0.22);
    color: #0284c7;
    box-shadow: 0 4px 12px -2px rgba(59, 130, 246, 0.15);
  }

  .attractive-stat-card:hover .stat-glow-badge {
    transform: scale(1.1) rotate(4deg);
  }

  /* Stat Number Value */
  .stat-card-value {
    font-size: 2.1rem;
    font-weight: 800;
    color: #0f172a;
    letter-spacing: -0.02em;
    line-height: 1.1;
    margin: 0.35rem 0 0.55rem 0;
    font-family: 'Plus Jakarta Sans', 'Outfit', system-ui, -apple-system, sans-serif !important;
  }

  /* Card Bottom Subtext & Clean Dividers */
  .stat-card-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 0.76rem;
    margin-top: auto;
    padding-top: 0.65rem;
    border-top: 1px dashed rgba(203, 213, 225, 0.6);
  }

  .growth-text {
    color: #64748b;
    font-weight: 600;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    display: flex;
    align-items: center;
    gap: 0.45rem;
  }

  .pulse-dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    display: inline-block;
    flex-shrink: 0;
  }

  .pulse-gold { background-color: #f59e0b; box-shadow: 0 0 8px rgba(245, 158, 11, 0.45); }
  .pulse-green { background-color: #10b981; box-shadow: 0 0 8px rgba(16, 185, 129, 0.45); }
  .pulse-amber { background-color: #f97316; box-shadow: 0 0 8px rgba(249, 115, 22, 0.45); }
  .pulse-purple { background-color: #8b5cf6; box-shadow: 0 0 8px rgba(139, 92, 246, 0.45); }
  .pulse-blue { background-color: #3b82f6; box-shadow: 0 0 8px rgba(59, 130, 246, 0.45); }

  /* Quick Actions Section */
  .dashboard-section-title {
    font-size: 1.05rem;
    font-weight: 700;
    color: #0f172a;
    letter-spacing: -0.01em;
    margin: 2.2rem 0 1rem 0;
    display: flex;
    align-items: center;
    gap: 0.6rem;
  }

  .dashboard-section-title i {
    color: #d4af37;
    font-size: 0.95rem;
  }

  .quick-actions-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.15rem;
  }

  @media (max-width: 1100px) {
    .quick-actions-grid {
      grid-template-columns: repeat(2, 1fr);
    }
  }

  @media (max-width: 580px) {
    .quick-actions-grid {
      grid-template-columns: 1fr;
    }
  }

  .action-tile {
    background: #ffffff;
    border: 1px solid #edf2f7;
    border-radius: 16px;
    padding: 1.2rem 1.25rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    text-decoration: none;
    color: #0f172a;
    transition: all 0.28s ease;
    box-shadow: 0 1px 3px rgba(15, 23, 42, 0.02);
  }

  .action-tile:hover {
    transform: translateY(-3px);
    border-color: #fde68a;
    background: #fffefb;
    box-shadow: 0 10px 22px -4px rgba(245, 158, 11, 0.1);
  }

  .action-tile-icon {
    width: 46px;
    height: 46px;
    border-radius: 12px;
    background: #f8fafc;
    border: 1px solid #edf2f7;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #334155;
    font-size: 1.15rem;
    transition: all 0.28s ease;
    flex-shrink: 0;
  }

  .action-tile:hover .action-tile-icon {
    background: #fef3c7;
    color: #d97706;
    border-color: #fde68a;
  }

  .action-tile-content h4 {
    font-size: 0.92rem;
    font-weight: 700;
    margin: 0 0 2px 0;
    color: #0f172a;
  }

  .action-tile-content p {
    font-size: 0.76rem;
    color: #64748b;
    margin: 0;
  }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="font-heading mb-1 fw-bold" style="font-family: var(--font-heading); font-size: 2rem; color: #0f1115;">Executive Dashboard</h2>
        <p class="text-muted small mb-0">Live sales performance, active catalog items, and order metrics.</p>
    </div>
</div>

<!-- Dashboard Metric Cards Grid (2-column layout) -->
<div class="row g-4 mb-4">
    
    <!-- Row 1 Left: Greeting & Live Date/Time Card -->
    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-3 overflow-hidden h-100" style="border-radius: 12px !important;">
            <div class="card-body p-4 d-flex justify-content-between align-items-center bg-white">
                <div>
                    <div class="text-uppercase text-muted fw-bold mb-1" style="font-size: 0.78rem; letter-spacing: 0.08em; font-family: var(--font-nav);"><?php echo $greeting_prefix; ?></div>
                    <h3 class="fw-bold text-dark mb-0 font-heading" style="font-size: 1.65rem; font-family: var(--font-heading);"><?php echo htmlspecialchars($_SESSION['full_name'] ?? $_SESSION['username'] ?? 'ChronoHub Admin'); ?>!</h3>
                </div>
                <div class="greeting-illustration ps-3">
                    <svg width="110" height="75" viewBox="0 0 120 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="42" y="5" width="36" height="68" rx="6" fill="#c5a059" opacity="0.15" stroke="#c5a059" stroke-width="2"/>
                        <rect x="46" y="12" width="28" height="42" rx="2" fill="#FFFFFF"/>
                        <rect x="50" y="16" width="20" height="4" rx="1" fill="#c5a059"/>
                        <rect x="50" y="24" width="16" height="3" rx="1" fill="#d4af37" opacity="0.6"/>
                        <rect x="50" y="30" width="18" height="3" rx="1" fill="#d4af37" opacity="0.6"/>
                        <rect x="50" y="36" width="12" height="3" rx="1" fill="#d4af37" opacity="0.6"/>
                        <rect x="50" y="44" width="20" height="6" rx="3" fill="#0f1115"/>
                        <circle cx="24" cy="28" r="5" fill="#c5a059"/>
                        <path d="M16 48 C16 38, 32 38, 32 48 L32 58 L16 58 Z" fill="#0f1115"/>
                        <path d="M22 36 L15 28" stroke="#c5a059" stroke-width="2" stroke-linecap="round"/>
                        <circle cx="96" cy="28" r="5" fill="#0f1115"/>
                        <path d="M88 48 C88 38, 104 38, 104 48 L104 58 L88 58 Z" fill="#374151"/>
                        <path d="M92 36 L84 26" stroke="#0f1115" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </div>
            </div>
            <div class="card-footer border-0 px-4 py-2 d-flex align-items-center justify-content-between text-muted small" style="font-size: 0.82rem; background-color: #faf6ee !important;">
                <div class="d-flex align-items-center gap-2">
                    <i class="fa-regular fa-calendar-days text-gold" style="color: #c5a059;"></i>
                    <span id="dashLiveDate" class="fw-semibold text-dark"><?php echo date('M d, Y'); ?></span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <i class="fa-regular fa-clock text-gold" style="color: #c5a059;"></i>
                    <span id="dashLiveTime" class="fw-semibold text-dark"><?php echo date('h:i:s A'); ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 1 Right: ORDERS CARD -->
    <div class="col-md-6">
      <div class="attractive-stat-card card-theme-orders h-100">
        <i class="fa-solid fa-bag-shopping card-watermark-icon" style="color: #10b981;"></i>
        <div class="card-inner-content">
          <div>
            <div class="stat-card-header">
              <div class="stat-card-title-group">
                <span class="stat-card-label">ORDERS</span>
                <span class="stat-trend-pill pill-orders"><i class="fa-solid fa-arrow-trend-up"></i></span>
              </div>
              <div class="stat-glow-badge badge-glow-green">
                <i class="fa-solid fa-bag-shopping"></i>
              </div>
            </div>
            <h3 class="stat-card-value"><?php echo number_format($total_orders); ?></h3>
          </div>
          <div class="stat-card-footer">
            <span class="growth-text">
              <span class="pulse-dot pulse-green"></span>
              Total orders received
            </span>
          </div>
        </div>
      </div>
    </div>

    <!-- Row 2 Left: REVENUE CARD -->
    <div class="col-md-6">
      <div class="attractive-stat-card card-theme-revenue h-100">
        <i class="fa-solid fa-indian-rupee-sign card-watermark-icon" style="color: #f59e0b;"></i>
        <div class="card-inner-content">
          <div>
            <div class="stat-card-header">
              <div class="stat-card-title-group">
                <span class="stat-card-label">REVENUE</span>
                <span class="stat-trend-pill pill-revenue"><i class="fa-solid fa-arrow-trend-up"></i></span>
              </div>
              <div class="stat-glow-badge badge-glow-gold">
                <i class="fa-solid fa-indian-rupee-sign"></i>
              </div>
            </div>
            <h3 class="stat-card-value"><?php echo format_price($total_revenue); ?></h3>
          </div>
          <div class="stat-card-footer">
            <span class="growth-text">
              <span class="pulse-dot pulse-gold"></span>
              Total revenue generated
            </span>
          </div>
        </div>
      </div>
    </div>

    <!-- Row 2 Right: PRODUCTS CARD -->
    <div class="col-md-6">
      <div class="attractive-stat-card card-theme-products h-100">
        <i class="fa-solid fa-box-archive card-watermark-icon" style="color: #8b5cf6;"></i>
        <div class="card-inner-content">
          <div>
            <div class="stat-card-header">
              <div class="stat-card-title-group">
                <span class="stat-card-label">PRODUCTS</span>
                <span class="stat-trend-pill pill-products"><i class="fa-solid fa-gem"></i> Catalog</span>
              </div>
              <div class="stat-glow-badge badge-glow-purple">
                <i class="fa-solid fa-box-archive"></i>
              </div>
            </div>
            <h3 class="stat-card-value"><?php echo $count_product; ?></h3>
          </div>
          <div class="stat-card-footer">
            <span class="growth-text">
              <span class="pulse-dot pulse-purple"></span>
              Items in catalog
            </span>
          </div>
        </div>
      </div>
    </div>

    <!-- Row 3 Left: CUSTOMERS CARD -->
    <div class="col-md-6">
      <div class="attractive-stat-card card-theme-customers h-100">
        <i class="fa-solid fa-users card-watermark-icon" style="color: #f97316;"></i>
        <div class="card-inner-content">
          <div>
            <div class="stat-card-header">
              <div class="stat-card-title-group">
                <span class="stat-card-label">CUSTOMERS</span>
                <span class="stat-trend-pill pill-customers"><i class="fa-solid fa-shield-halved"></i> Active</span>
              </div>
              <div class="stat-glow-badge badge-glow-amber">
                <i class="fa-solid fa-users"></i>
              </div>
            </div>
            <h3 class="stat-card-value"><?php echo $count_user; ?></h3>
          </div>
          <div class="stat-card-footer">
            <span class="growth-text">
              <span class="pulse-dot pulse-amber"></span>
              Total registered users
            </span>
          </div>
        </div>
      </div>
    </div>

    <!-- Row 3 Right: CATEGORIES CARD -->
    <div class="col-md-6">
      <div class="attractive-stat-card card-theme-categories h-100">
        <i class="fa-solid fa-layer-group card-watermark-icon" style="color: #3b82f6;"></i>
        <div class="card-inner-content">
          <div>
            <div class="stat-card-header">
              <div class="stat-card-title-group">
                <span class="stat-card-label">CATEGORIES</span>
                <span class="stat-trend-pill pill-categories"><i class="fa-solid fa-circle-check"></i> Live</span>
              </div>
              <div class="stat-glow-badge badge-glow-blue">
                <i class="fa-solid fa-layer-group"></i>
              </div>
            </div>
            <h3 class="stat-card-value"><?php echo $count_category; ?></h3>
          </div>
          <div class="stat-card-footer">
            <span class="growth-text">
              <span class="pulse-dot pulse-blue"></span>
              All active categories
            </span>
          </div>
        </div>
      </div>
    </div>

</div>

<!-- Sales Report Card Widget -->
<div class="card border-0 shadow-sm bg-white mb-4" style="border-radius: 12px !important;">
    <div class="card-header bg-white border-0 p-4 pb-0 d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
            <h4 class="font-heading fw-bold text-dark mb-0 d-inline-block" style="font-family: var(--font-heading); font-size: 1.35rem;">Sales Report</h4>
            <span class="text-muted small ms-2" id="salesReportCountText">(<?php echo number_format($today_order_count); ?> Orders)</span>
        </div>
        <!-- Period Filter Pills -->
        <div class="btn-group p-1 bg-light rounded-3" role="group" id="salesReportTabs">
            <button type="button" class="btn btn-sm btn-white active fw-semibold shadow-sm rounded-2 border-0 px-3 py-1 text-dark" data-period="today" style="font-size: 0.84rem;">Today</button>
            <button type="button" class="btn btn-sm btn-light text-secondary border-0 px-3 py-1 rounded-2" data-period="monthly" style="font-size: 0.84rem;">Monthly</button>
            <button type="button" class="btn btn-sm btn-light text-secondary border-0 px-3 py-1 rounded-2" data-period="annual" style="font-size: 0.84rem;">Annual</button>
        </div>
    </div>

    <div class="card-body p-4">
        <!-- Metrics Sub-Header Row -->
        <div class="row g-3 mx-0 p-3 mb-4 rounded-3 align-items-center" style="background-color: #fdfbf7; border: none !important;">
            <div class="col-md-6 col-12 d-flex align-items-center gap-3 px-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 42px; height: 42px; background-color: rgba(197, 160, 89, 0.15); color: #c5a059;">
                    <i class="fa-solid fa-wallet fs-6"></i>
                </div>
                <div>
                    <div class="text-uppercase text-muted fw-bold" style="font-size: 0.73rem; letter-spacing: 0.06em; font-family: var(--font-nav);">Revenue</div>
                    <div class="fw-bold text-dark fs-5" id="reportRevVal" style="font-family: var(--font-body);"><?php echo format_price($today_revenue_val); ?></div>
                </div>
            </div>
            <div class="col-md-6 col-12 d-flex align-items-center gap-3 px-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 42px; height: 42px; background-color: rgba(100, 116, 139, 0.12); color: #526071;">
                    <i class="fa-solid fa-bag-shopping fs-6"></i>
                </div>
                <div>
                    <div class="text-uppercase text-muted fw-bold" style="font-size: 0.73rem; letter-spacing: 0.06em; font-family: var(--font-nav);">Orders</div>
                    <div class="fw-bold text-dark fs-5" id="reportOrdersVal" style="font-family: var(--font-body);"><?php echo number_format($today_order_count); ?></div>
                </div>
            </div>
        </div>

        <!-- Period Earnings Note -->
        <div class="mb-3">
            <h6 class="fw-bold text-dark mb-1 font-heading" id="reportEarningNote" style="font-size: 1.05rem; font-family: var(--font-heading);">Today's Earning: <span style="font-family: var(--font-body); font-weight: 700;"><?php echo format_price($today_revenue_val); ?></span></h6>
            <p class="text-muted small mb-0">Sales revenue distribution and order performance trends for ChronoHub luxury timepieces.</p>
        </div>

        <!-- Sales Chart Canvas -->
        <div style="height: 300px; position: relative;">
            <canvas id="salesReportChart"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    function updateDashboardClock() {
        const dateEl = document.getElementById('dashLiveDate');
        const timeEl = document.getElementById('dashLiveTime');
        if (!dateEl || !timeEl) return;
        const now = new Date();
        const dateStr = now.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
        const timeStr = now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true });
        dateEl.textContent = dateStr;
        timeEl.textContent = timeStr;
    }
    updateDashboardClock();
    setInterval(updateDashboardClock, 1000);

    const salesReportData = {
        today: {
            labels: <?php echo json_encode($today_labels); ?>,
            revenue: <?php echo json_encode($today_rev_points); ?>,
            orders: <?php echo json_encode($today_ord_points); ?>,
            earningText: "Today's Earning: <span style=\"font-family: var(--font-body); font-weight: 700;\"><?php echo format_price($today_revenue_val); ?></span>",
            revVal: "<?php echo format_price($today_revenue_val); ?>",
            ordersVal: "<?php echo number_format($today_order_count); ?>",
            countText: "(<?php echo number_format($today_order_count); ?> Orders)"
        },
        monthly: {
            labels: <?php echo json_encode($monthly_labels); ?>,
            revenue: <?php echo json_encode($monthly_rev_points); ?>,
            orders: <?php echo json_encode($monthly_ord_points); ?>,
            earningText: "This Month's Earning: <span style=\"font-family: var(--font-body); font-weight: 700;\"><?php echo format_price($this_month_rev_val); ?></span>",
            revVal: "<?php echo format_price($this_month_rev_val); ?>",
            ordersVal: "<?php echo number_format($this_month_orders); ?>",
            countText: "(<?php echo number_format($this_month_orders); ?> Orders)"
        },
        annual: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            revenue: <?php echo json_encode($annual_rev_points); ?>,
            orders: <?php echo json_encode($annual_ord_points); ?>,
            earningText: "Annual Earning: <span style=\"font-family: var(--font-body); font-weight: 700;\"><?php echo format_price($total_revenue); ?></span>",
            revVal: "<?php echo format_price($total_revenue); ?>",
            ordersVal: "<?php echo number_format($total_orders); ?>",
            countText: "(<?php echo number_format($total_orders); ?> Orders)"
        }
    };

    const canvasEl = document.getElementById('salesReportChart');
    if (canvasEl) {
        const ctx = canvasEl.getContext('2d');
        const goldGradient = ctx.createLinearGradient(0, 0, 0, 300);
        goldGradient.addColorStop(0, 'rgba(197, 160, 89, 0.35)');
        goldGradient.addColorStop(1, 'rgba(197, 160, 89, 0.01)');

        const chartConfig = {
            type: 'line',
            data: {
                labels: salesReportData.today.labels,
                datasets: [
                    {
                        label: 'Total Revenue',
                        data: salesReportData.today.revenue,
                        borderColor: '#c5a059',
                        backgroundColor: goldGradient,
                        fill: true,
                        tension: 0.4,
                        borderWidth: 3,
                        pointBackgroundColor: '#c5a059',
                        pointBorderColor: '#ffffff',
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        yAxisID: 'y'
                    },
                    {
                        label: 'Orders',
                        data: salesReportData.today.orders,
                        borderColor: '#0f1115',
                        backgroundColor: 'transparent',
                        borderDash: [5, 5],
                        fill: false,
                        tension: 0.4,
                        borderWidth: 2,
                        pointBackgroundColor: '#0f1115',
                        pointBorderColor: '#ffffff',
                        pointRadius: 3,
                        pointHoverRadius: 5,
                        yAxisID: 'y1'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: { usePointStyle: true, pointStyle: 'circle', padding: 20, font: { family: 'Outfit', size: 13, weight: '500' } }
                    },
                    tooltip: {
                        backgroundColor: '#0f1115',
                        titleFont: { family: 'Outfit', size: 13 },
                        bodyFont: { family: 'Plus Jakarta Sans', size: 12 },
                        padding: 12,
                        cornerRadius: 8
                    }
                },
                layout: {
                    padding: { left: 10, right: 10, top: 5, bottom: 5 }
                },
                scales: {
                    x: {
                        grid: { display: true, color: 'rgba(0, 0, 0, 0.04)', borderDash: [4, 4] },
                        ticks: { font: { family: 'Outfit', size: 12 }, color: '#6b7280' }
                    },
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        beginAtZero: true,
                        title: { 
                            display: true, 
                            text: 'Revenue (₹)', 
                            color: '#c5a059', 
                            font: { family: 'Outfit', size: 12, weight: '600' },
                            padding: { top: 0, bottom: 15 }
                        },
                        grid: { color: 'rgba(0, 0, 0, 0.04)', borderDash: [4, 4] },
                        ticks: {
                            font: { family: 'Plus Jakarta Sans', size: 11 },
                            color: '#6b7280',
                            padding: 8,
                            callback: function(value) { return '₹' + value.toLocaleString('en-IN'); }
                        }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        beginAtZero: true,
                        title: { 
                            display: true, 
                            text: 'Orders', 
                            color: '#0f1115', 
                            font: { family: 'Outfit', size: 12, weight: '600' },
                            padding: { top: 0, bottom: 15 }
                        },
                        grid: { display: false },
                        ticks: {
                            stepSize: 1,
                            precision: 0,
                            font: { family: 'Plus Jakarta Sans', size: 11 },
                            color: '#6b7280',
                            padding: 8,
                            callback: function(value) { return Math.floor(value) === value ? value : ''; }
                        }
                    }
                }
            }
        };

        const salesChart = new Chart(ctx, chartConfig);

        const tabButtons = document.querySelectorAll('#salesReportTabs button');
        tabButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                tabButtons.forEach(b => {
                    b.classList.remove('active', 'btn-white', 'shadow-sm', 'fw-semibold', 'text-dark');
                    b.classList.add('btn-light', 'text-secondary');
                });
                this.classList.add('active', 'btn-white', 'shadow-sm', 'fw-semibold', 'text-dark');
                this.classList.remove('btn-light', 'text-secondary');

                const period = this.getAttribute('data-period');
                const data = salesReportData[period];

                document.getElementById('salesReportCountText').textContent = data.countText;
                document.getElementById('reportRevVal').textContent = data.revVal;
                document.getElementById('reportOrdersVal').textContent = data.ordersVal;
                const growthEl = document.getElementById('reportGrowthVal');
                if (growthEl) growthEl.textContent = data.growthVal;
                document.getElementById('reportEarningNote').innerHTML = data.earningText;

                salesChart.data.labels = data.labels;
                salesChart.data.datasets[0].data = data.revenue;
                salesChart.data.datasets[1].data = data.orders;
                salesChart.update();
            });
        });
    }
});
</script>

<?php
    include('admin_footer.php');
?>