<?php

session_start();
include "connect.php";
$islogin=false;
$cart_count = 0;

if (!isset($_SESSION['userid'])) {
	$islogin=false;
  
} else {
    $userid = $_SESSION['userid'];
	$username=$_SESSION['username'];
	$islogin=true;
    $cart_q = mysqli_query($con, "SELECT SUM(quantity) as total FROM tbl_cart WHERE userid='$userid'");
    if ($cart_q && $c_row = mysqli_fetch_assoc($cart_q)) {
        $cart_count = (int)($c_row['total'] ?? 0);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ChronoHub · Luxury Watches</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- FontAwesome 6 & Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <!-- Google Fonts: Playfair Display, Inter, Outfit & Plus Jakarta Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --bg-white: #ffffff;
      --bg-light: #f8f9fa;
      --text-primary: #0f1115;
      --text-muted: #6c757d;
      --border-color: #e5e7eb;
      --border-dark: #111111;
      --accent-gold: #c5a059;
      --accent-red: #d9534f;
      --font-heading: 'Playfair Display', serif;
      --font-body: 'Plus Jakarta Sans', sans-serif;
      --font-nav: 'Outfit', sans-serif;
      
      --badge-cream: #f7f3eb;
      --badge-sand: #e8e0d3;
      --badge-gold: #c6a87c;
      --badge-darkgold: #a8895c;
      --badge-olive: #6b6b5a;
      --badge-deep: #3a3a30;
      --badge-lighttext: #2e2e28;
      --badge-shadow: rgba(198, 168, 124, 0.25);
    }

    .text-gold {
      color: #c5a059 !important;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      background: var(--bg-white);
      font-family: var(--font-body), 'Inter', sans-serif;
      color: var(--text-primary);
      overflow-x: hidden;
      scroll-behavior: smooth;
    }

    h1, h2, h3, h4, h5, h6, .font-heading, .display-1, .navbar-brand {
      font-family: var(--font-heading), 'Playfair Display', serif !important;
      font-weight: 600;
    }

    /* ---------- MAIN HEADER (ChronoHub Luxury Style) ---------- */
    .main-header {
      border-bottom: 1px solid var(--border-color);
      background-color: var(--bg-white);
      position: relative;
      z-index: 1040;
    }

    .brand-logo {
      font-family: var(--font-heading);
      font-size: 1.85rem;
      font-weight: 700;
      letter-spacing: 0.04em;
      color: #0f1115;
      text-transform: uppercase;
      display: inline-flex;
      align-items: center;
      line-height: 1;
    }

    .brand-logo .brand-text {
      color: #0f1115;
      font-weight: 700;
      display: inline-flex;
      align-items: center;
    }

    .brand-logo .brand-gold {
      font-weight: 700;
      color: var(--accent-gold) !important;
    }

    .watch-o-letter {
      display: inline-block;
      vertical-align: -0.15em !important;
      margin: 0 2px 0 1px !important;
      height: 1.08em !important;
      width: auto !important;
      flex-shrink: 0;
      overflow: visible;
      transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .brand-logo:hover .watch-o-letter {
      transform: scale(1.08);
    }

    .search-input-group {
      border: 1.5px solid #111111;
      border-radius: 4px;
      overflow: hidden;
      background: #ffffff;
    }

    .search-input-group input {
      border: none;
      box-shadow: none !important;
      font-size: 0.88rem;
      padding: 0.55rem 1rem;
    }

    .search-input-group .btn-search {
      background: transparent;
      border: none;
      color: #111111;
      padding: 0 1.1rem;
    }

    /* ---------- LUXURY NAVBAR ---------- */
    .navbar-nav-luxury .nav-link {
      font-family: var(--font-nav);
      font-size: 0.85rem;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.08em;
      color: #222222 !important;
      padding: 0.85rem 1.1rem !important;
      position: relative;
    }

    .navbar-nav-luxury .nav-link::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 50%;
      transform: translateX(-50%);
      width: 0;
      height: 2px;
      background-color: #111111;
      transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .navbar-nav-luxury .nav-link:hover::after,
    .navbar-nav-luxury .nav-link.active::after {
      width: 60%;
    }

    .nav-icon-badge {
      position: absolute;
      top: -5px;
      right: -8px;
      background-color: #111111;
      color: #ffffff;
      font-size: 0.65rem;
      font-weight: 700;
      border-radius: 50%;
      width: 18px;
      height: 18px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .no-caret::after {
      display: none !important;
    }

    .dropdown {
      position: relative !important;
    }

    .dropdown-menu {
      z-index: 1050 !important;
      box-shadow: 0 10px 30px rgba(0,0,0,0.12) !important;
      position: absolute !important;
      top: 100% !important;
      right: 0 !important;
      left: auto !important;
      margin-top: 0.35rem !important;
      min-width: 160px;
      display: none !important;
    }

    .dropdown-menu.show {
      display: block !important;
      opacity: 1 !important;
      visibility: visible !important;
    }

  </style>
</head>
<body>

  <!-- ========== TOP STICKY HEADER WRAPPER ========== -->
  <div class="sticky-top bg-white border-bottom shadow-sm" style="z-index: 1040;">

    <!-- TOP MAIN HEADER (ChronoHub Design) -->
    <header class="main-header py-3 border-bottom-0">
      <div class="container">
        <div class="row align-items-center">
          
          <!-- Brand Logo -->
          <div class="col-md-4 col-6">
            <a href="home.php" class="brand-logo text-decoration-none">
              <span class="brand-text">CHR<img src="uploads/watch_o.png" class="watch-o-letter" alt="O">NO<span class="brand-gold">HUB</span></span>
            </a>
          </div>

          <!-- Search Bar -->
          <div class="col-md-5 d-none d-md-block">
            <form action="shop.php" method="GET">
              <div class="input-group search-input-group">
                <input type="text" name="search" class="form-control" placeholder="Search watches or categories..." value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
                <button class="btn btn-search" type="submit" aria-label="Search">
                  <i class="fa-solid fa-magnifying-glass"></i>
                </button>
              </div>
            </form>
          </div>

          <!-- User Info & Cart Count -->
          <div class="col-md-3 col-6 text-end">
            <div class="d-inline-flex align-items-center gap-3">
              <?php if ($islogin): ?>
                <div class="dropdown position-relative">
                  <a href="javascript:void(0)" class="text-dark fw-bold text-decoration-none dropdown-toggle no-caret small" id="userMenu" aria-expanded="false" role="button">
                    <i class="fa-regular fa-user me-1 fs-5"></i> <?php echo htmlspecialchars($username); ?>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-1" aria-labelledby="userMenu">
                    <li><a class="dropdown-item py-2" href="my_orders.php"><i class="fa-solid fa-box me-2"></i> My Orders</a></li>
                    <li><a class="dropdown-item py-2" href="profile.php"><i class="fa-solid fa-id-card me-2"></i> Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item py-2 text-danger" href="logout.php"><i class="fa-solid fa-right-from-bracket me-2"></i> Logout</a></li>
                  </ul>
                </div>
                <script>
                  document.addEventListener('DOMContentLoaded', function() {
                    var uMenu = document.getElementById('userMenu');
                    if (uMenu) {
                      uMenu.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        var menu = this.nextElementSibling;
                        if (menu) {
                          menu.classList.toggle('show');
                        }
                      });
                      document.addEventListener('click', function(e) {
                        if (uMenu && !uMenu.contains(e.target)) {
                          var menu = uMenu.nextElementSibling;
                          if (menu && menu.classList.contains('show')) {
                            menu.classList.remove('show');
                          }
                        }
                      });
                    }
                  });
                </script>
              <?php else: ?>
                <a href="login.php" class="text-dark fw-bold text-decoration-none small">
                  <i class="fa-regular fa-user me-1 fs-5"></i> Login
                </a>
              <?php endif ?>

              <a href="cart.php" class="text-dark fs-5 position-relative ms-2" title="Cart">
                <i class="fa-solid fa-bag-shopping"></i>
                <span class="nav-icon-badge"><?php echo $cart_count; ?></span>
              </a>
            </div>
          </div>

        </div>
      </div>
    </header>

    <!-- LUXURY NAVBAR (ChronoHub Design) -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white py-0 border-top">
      <div class="container">
        <button class="navbar-toggler my-2" type="button" data-bs-toggle="collapse" data-bs-target="#miniNavbar" aria-controls="miniNavbar" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-center" id="miniNavbar">
          <ul class="navbar-nav navbar-nav-luxury">
            <li class="nav-item">
              <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'home.php' || basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : ''; ?>" href="home.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'shop.php') ? 'active' : ''; ?>" href="shop.php">Shop</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'about.php') ? 'active' : ''; ?>" href="about.php">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'contact.php') ? 'active' : ''; ?>" href="contact.php">Contact</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'cart.php') ? 'active' : ''; ?>" href="cart.php">Cart (<?php echo $cart_count; ?>)</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

  </div>
