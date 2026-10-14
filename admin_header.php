<?php
session_start();
$isadmin = false;
if (isset($_SESSION['isadmin']) || $_SESSION['isadmin'] != NULL) {
    $isadmin = true;
}
if (!$isadmin) {
    header("location:login.php");
    exit();
}

$current_page = basename($_SERVER['PHP_SELF']);

// Active status indicators
$products_pages  = ['admin_show_product.php', 'admin_add_product.php', 'admin_update_product.php', 'admin_view_product.php'];
$category_pages  = ['admin_show_category.php', 'admin_add_category.php', 'admin_update_category.php'];
$orders_pages    = ['admin_show_order.php', 'admin_update_order.php'];
$customers_pages = ['admin_show_user.php'];

$is_products_active  = in_array($current_page, $products_pages);
$is_category_active  = in_array($current_page, $category_pages);
$is_orders_active    = in_array($current_page, $orders_pages);
$is_customers_active = in_array($current_page, $customers_pages);

// Helper function to render admin sidebar navigation items
function render_pooja_admin_nav_items($current_page, $id_suffix = '') {
    global $is_products_active, $is_category_active, $is_orders_active, $is_customers_active;
    ?>
    <nav class="nav flex-column py-2 admin-nav-menu">
        <!-- GENERAL CATEGORY -->
        <div class="sidebar-category-title">GENERAL</div>

        <!-- Dashboard -->
        <a class="nav-link <?php echo ($current_page === 'admin_home.php') ? 'active' : ''; ?>" href="admin_home.php" title="Dashboard">
            <div class="d-flex align-items-center">
                <i class="fa-solid fa-gauge me-2 nav-icon"></i>
                <span class="nav-label">Dashboard</span>
            </div>
        </a>

        <!-- Products Submenu -->
        <a class="nav-link nav-link-collapse d-flex justify-content-between align-items-center <?php echo $is_products_active ? 'active' : 'collapsed'; ?>" data-bs-toggle="collapse" data-bs-target="#menuProducts<?php echo $id_suffix; ?>" href="javascript:void(0);" role="button" aria-expanded="<?php echo $is_products_active ? 'true' : 'false'; ?>" aria-controls="menuProducts<?php echo $id_suffix; ?>" title="Products">
            <div class="d-flex align-items-center">
                <i class="fa-solid fa-box me-2 nav-icon"></i>
                <span class="nav-label">Products</span>
            </div>
            <i class="fa-solid fa-chevron-down chevron-icon"></i>
        </a>
        <div class="collapse sidebar-submenu <?php echo $is_products_active ? 'show' : ''; ?>" id="menuProducts<?php echo $id_suffix; ?>">
            <a class="submenu-link <?php echo ($current_page === 'admin_show_product.php') ? 'active' : ''; ?>" href="admin_show_product.php">All Products</a>
            <a class="submenu-link <?php echo ($current_page === 'admin_add_product.php') ? 'active' : ''; ?>" href="admin_add_product.php">Add Product</a>
        </div>

        <!-- Category Submenu -->
        <a class="nav-link nav-link-collapse d-flex justify-content-between align-items-center <?php echo $is_category_active ? 'active' : 'collapsed'; ?>" data-bs-toggle="collapse" data-bs-target="#menuCategory<?php echo $id_suffix; ?>" href="javascript:void(0);" role="button" aria-expanded="<?php echo $is_category_active ? 'true' : 'false'; ?>" aria-controls="menuCategory<?php echo $id_suffix; ?>" title="Category">
            <div class="d-flex align-items-center">
                <i class="fa-solid fa-layer-group me-2 nav-icon"></i>
                <span class="nav-label">Category</span>
            </div>
            <i class="fa-solid fa-chevron-down chevron-icon"></i>
        </a>
        <div class="collapse sidebar-submenu <?php echo $is_category_active ? 'show' : ''; ?>" id="menuCategory<?php echo $id_suffix; ?>">
            <a class="submenu-link <?php echo ($current_page === 'admin_show_category.php') ? 'active' : ''; ?>" href="admin_show_category.php">All Categories</a>
            <a class="submenu-link <?php echo ($current_page === 'admin_add_category.php') ? 'active' : ''; ?>" href="admin_add_category.php">Add Category</a>
        </div>

        <!-- Orders Direct Link -->
        <a class="nav-link <?php echo ($current_page === 'admin_show_order.php') ? 'active' : ''; ?>" href="admin_show_order.php" title="Orders">
            <div class="d-flex align-items-center">
                <i class="fa-solid fa-cart-shopping me-2 nav-icon"></i>
                <span class="nav-label">Orders</span>
            </div>
        </a>

        <!-- USERS CATEGORY -->
        <div class="sidebar-category-title mt-3">USERS</div>

        <!-- Profile -->
        <a class="nav-link <?php echo ($current_page === 'admin_show_profile.php') ? 'active' : ''; ?>" href="admin_show_profile.php" title="Profile">
            <div class="d-flex align-items-center">
                <i class="fa-solid fa-circle-user me-2 nav-icon"></i>
                <span class="nav-label">Profile</span>
            </div>
        </a>

        <!-- Customers Direct Link -->
        <a class="nav-link <?php echo ($current_page === 'admin_show_user.php') ? 'active' : ''; ?>" href="admin_show_user.php" title="Customers">
            <div class="d-flex align-items-center">
                <i class="fa-solid fa-users me-2 nav-icon"></i>
                <span class="nav-label">Customers</span>
            </div>
        </a>

        <div class="my-2"></div>
        
        <a class="nav-link text-info" href="home.php" target="_blank" title="View Storefront">
            <div class="d-flex align-items-center">
                <i class="fa-solid fa-store me-2 nav-icon"></i>
                <span class="nav-label">View Storefront</span>
            </div>
        </a>
        <a class="nav-link text-danger" href="logout.php" title="Logout">
            <div class="d-flex align-items-center">
                <i class="fa-solid fa-right-from-bracket me-2 nav-icon"></i>
                <span class="nav-label">Logout</span>
            </div>
        </a>
    </nav>
    <?php
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? htmlspecialchars($page_title) . ' | Admin Panel' : 'ChronoHub Admin Control System'; ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- FontAwesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <!-- Google Fonts: Playfair Display, Outfit & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Anti-Flash Sidebar State Script -->
    <script>
        if (localStorage.getItem('chronohub_sidebar_collapsed') === 'true') {
            document.documentElement.classList.add('sidebar-collapsed');
        }
    </script>

    <style>
        :root {
            --bg-white: #ffffff;
            --bg-light: #f8f9fa;
            --text-primary: #0f1115;
            --text-muted: #6c757d;
            --border-color: #e5e7eb;
            --accent-gold: #c5a059;
            --font-heading: 'Playfair Display', serif;
            --font-body: 'Plus Jakarta Sans', sans-serif;
            --font-nav: 'Outfit', sans-serif;
            --transition-fast: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: var(--font-body);
            color: var(--text-primary);
            background-color: var(--bg-light);
        }

        .no-caret::after {
            display: none !important;
        }

        /* Brand Logo */
        .brand-logo {
            font-family: var(--font-heading);
            font-size: 1.6rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            color: #0f1115 !important;
            text-transform: uppercase;
            display: inline-flex;
            align-items: center;
            line-height: 1;
            text-decoration: none;
        }

        .brand-logo .brand-full {
            color: #0f1115;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
        }

        .brand-logo .brand-mini {
            color: #0f1115;
            font-weight: 700;
            display: none !important;
            align-items: center;
        }

        .brand-logo .brand-gold,
        .brand-logo span.brand-gold {
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
        }

        /* Global Heading Font Family */
        h1, h2, h3:not(.stat-card-value), h4,
        .font-heading:not(.stat-card-value),
        .prod-page-title,
        .cat-page-title,
        .user-page-title,
        .profile-header-title,
        .form-main-title,
        .form-title,
        .overview-title,
        .detail-product-name,
        .overview-section-heading,
        .admin-page-title,
        .page-heading {
            font-family: 'Playfair Display', Georgia, serif !important;
        }

        /* Stat Card Numbers Font Style */
        .stat-card-value,
        .inv-stat-value {
            font-family: 'Plus Jakarta Sans', 'Outfit', system-ui, -apple-system, sans-serif !important;
            font-weight: 800 !important;
            letter-spacing: -0.02em !important;
        }

        /* ChronoHub Luxury Dark + Gold Outline Button Design */
        .btn-chronohub-luxury,
        .btn-add-product-luxury,
        .btn-back-product,
        .btn-create-product,
        .btn-add-category-luxury,
        .btn-back-category,
        .btn-create-category,
        .btn-save-profile,
        .overview-btn-back,
        .overview-btn-edit,
        .btn-order-action,
        .btn-gold-black,
        .btn-back-luxury,
        .btn-submit-luxury {
            background: #0f1115 !important;
            color: #ffffff !important;
            border: 1.5px solid #c5a059 !important;
            padding: 0.72rem 1.5rem !important;
            font-size: 0.82rem !important;
            font-weight: 700 !important;
            font-family: var(--font-nav, 'Outfit', sans-serif) !important;
            letter-spacing: 0.08em !important;
            text-transform: uppercase !important;
            border-radius: 10px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 0.55rem !important;
            text-decoration: none !important;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important;
            box-shadow: 0 4px 14px rgba(15, 17, 21, 0.15) !important;
            cursor: pointer !important;
        }

        .btn-chronohub-luxury i,
        .btn-add-product-luxury i,
        .btn-back-product i,
        .btn-create-product i,
        .btn-add-category-luxury i,
        .btn-back-category i,
        .btn-create-category i,
        .btn-save-profile i,
        .overview-btn-back i,
        .overview-btn-edit i,
        .btn-order-action i,
        .btn-gold-black i,
        .btn-back-luxury i,
        .btn-submit-luxury i {
            color: #c5a059 !important;
            font-size: 0.9rem !important;
            transition: transform 0.25s ease !important;
        }

        .btn-chronohub-luxury:hover,
        .btn-add-product-luxury:hover,
        .btn-back-product:hover,
        .btn-create-product:hover,
        .btn-add-category-luxury:hover,
        .btn-back-category:hover,
        .btn-create-category:hover,
        .btn-save-profile:hover,
        .overview-btn-back:hover,
        .overview-btn-edit:hover,
        .btn-order-action:hover,
        .btn-gold-black:hover,
        .btn-back-luxury:hover,
        .btn-submit-luxury:hover {
            background: #1a1e26 !important;
            color: #ffffff !important;
            border-color: #d4af37 !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 8px 20px rgba(197, 160, 89, 0.25) !important;
        }

        .btn-back-product:hover i,
        .btn-back-category:hover i,
        .overview-btn-back:hover i,
        .btn-back-luxury:hover i {
            transform: translateX(-4px) !important;
        }

        .brand-mini {
            display: none !important;
        }

        /* Admin Sidebar Layout */
        .admin-sidebar {
            min-height: 100vh;
            background-color: #ffffff !important;
            color: #0f1115 !important;
            width: 250px;
            flex-shrink: 0;
            transition: width 0.25s ease-in-out;
        }

        @media (min-width: 768px) {
            .admin-sidebar {
                position: fixed !important;
                top: 0;
                left: 0;
                bottom: 0;
                width: 250px;
                height: 100vh;
                max-height: 100vh;
                overflow-y: auto;
                overflow-x: hidden;
                z-index: 1030;
                transition: width 0.25s ease-in-out;
            }

            .admin-top-header {
                position: fixed !important;
                top: 0;
                right: 0;
                left: 250px;
                height: 65px;
                z-index: 1020;
                background-color: #ffffff !important;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
                transition: left 0.25s ease-in-out;
            }

            .flex-grow-1.min-vh-100 {
                margin-left: 250px;
                padding-top: 65px;
                transition: margin-left 0.25s ease-in-out;
            }

            html.sidebar-collapsed .admin-top-header {
                left: 72px !important;
            }

            html.sidebar-collapsed .flex-grow-1.min-vh-100 {
                margin-left: 72px !important;
            }
        }

        .sidebar-toggle-btn {
            font-size: 1rem;
            color: #6b7280;
            transition: color 0.2s ease;
        }

        .sidebar-toggle-btn:hover {
            color: #c5a059;
        }

        /* Sidebar Collapsed State */
        html.sidebar-collapsed .admin-sidebar {
            width: 72px !important;
            z-index: 1040;
            transition: width 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        html.sidebar-collapsed .admin-sidebar:not(:hover) .brand-full {
            display: none !important;
        }

        html.sidebar-collapsed .admin-sidebar:not(:hover) .brand-mini {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        html.sidebar-collapsed .admin-sidebar:not(:hover) .brand-mini .watch-o-letter {
            margin: 0 !important;
        }

        html.sidebar-collapsed .admin-sidebar:not(:hover) .sidebar-brand {
            justify-content: center !important;
            padding: 0 !important;
            cursor: pointer;
        }

        html.sidebar-collapsed .admin-sidebar:not(:hover) .sidebar-brand .sidebar-toggle-btn {
            display: none !important;
        }

        html.sidebar-collapsed .admin-sidebar:not(:hover) .sidebar-category-title {
            display: none !important;
        }

        html.sidebar-collapsed .admin-sidebar:not(:hover) .nav-link .nav-label,
        html.sidebar-collapsed .admin-sidebar:not(:hover) .chevron-icon,
        html.sidebar-collapsed .admin-sidebar:not(:hover) .sidebar-submenu {
            display: none !important;
        }

        html.sidebar-collapsed .admin-sidebar:not(:hover) .nav-link {
            justify-content: center !important;
            padding: 0.9rem 0 !important;
            gap: 0 !important;
            text-align: center !important;
        }

        html.sidebar-collapsed .admin-sidebar:not(:hover) .nav-link > div.d-flex {
            justify-content: center !important;
            width: 100% !important;
            margin: 0 !important;
        }

        html.sidebar-collapsed .admin-sidebar:not(:hover) .nav-link i.nav-icon {
            font-size: 1.25rem !important;
            margin: 0 !important;
            width: auto !important;
            display: inline-block !important;
            text-align: center !important;
        }

        html.sidebar-collapsed .admin-sidebar .nav-link:hover,
        html.sidebar-collapsed .admin-sidebar .nav-link.active {
            border-left: 4px solid #c5a059 !important;
        }

        /* Hover Expansion on Desktop Collapsed Sidebar */
        @media (min-width: 768px) {
            html.sidebar-collapsed .admin-sidebar:hover {
                width: 250px !important;
                z-index: 1050 !important;
                box-shadow: 6px 0 25px rgba(0, 0, 0, 0.15) !important;
                background-color: #ffffff !important;
            }

            html.sidebar-collapsed .admin-sidebar:hover .brand-full {
                display: inline-flex !important;
                white-space: nowrap !important;
            }

            html.sidebar-collapsed .admin-sidebar:hover .brand-mini {
                display: none !important;
            }

            html.sidebar-collapsed .admin-sidebar:hover .sidebar-brand {
                justify-content: space-between !important;
                padding: 0 1rem !important;
            }

            html.sidebar-collapsed .admin-sidebar:hover .sidebar-toggle-btn {
                display: inline-block !important;
            }

            html.sidebar-collapsed .admin-sidebar:hover .sidebar-category-title {
                display: block !important;
            }

            html.sidebar-collapsed .admin-sidebar:hover .nav-link .nav-label {
                display: inline !important;
            }

            html.sidebar-collapsed .admin-sidebar:hover .chevron-icon {
                display: inline-block !important;
            }

            html.sidebar-collapsed .admin-sidebar:hover .sidebar-submenu.show {
                display: block !important;
            }

            html.sidebar-collapsed .admin-sidebar:hover .nav-link {
                justify-content: flex-start !important;
                padding: 0.85rem 1.5rem !important;
                text-align: left !important;
                gap: 0.75rem !important;
            }

            html.sidebar-collapsed .admin-sidebar:hover .nav-link-collapse {
                justify-content: space-between !important;
            }

            html.sidebar-collapsed .admin-sidebar:hover .nav-link > div.d-flex {
                justify-content: flex-start !important;
                width: auto !important;
                margin: 0 !important;
            }

            html.sidebar-collapsed .admin-sidebar:hover .nav-link i.nav-icon {
                font-size: 1rem !important;
                margin-right: 0.75rem !important;
                width: 1.25rem !important;
                text-align: center !important;
            }
        }

        .admin-sidebar .sidebar-brand {
            height: 65px;
            padding: 0 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            box-sizing: border-box;
            white-space: nowrap !important;
            overflow: hidden !important;
        }

        .admin-top-header {
            height: 65px;
            box-sizing: border-box;
            position: sticky;
            top: 0;
            z-index: 1010;
            background-color: #ffffff !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
        }

        .admin-sidebar .nav-link {
            color: #374151 !important;
            padding: 0.85rem 1.5rem;
            font-size: 0.88rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            transition: var(--transition-fast);
            border-left: 4px solid transparent;
        }

        .admin-sidebar .nav-icon {
            width: 20px;
            text-align: center;
            display: inline-block;
            flex-shrink: 0;
        }

        .admin-sidebar .nav-link:hover {
            color: #0f1115 !important;
            background-color: rgba(197, 160, 89, 0.04) !important;
            border-left: 4px solid #c5a059 !important;
        }

        .admin-sidebar .nav-link.active {
            color: #0f1115 !important;
            background-color: rgba(197, 160, 89, 0.07) !important;
            border-left: 4px solid #c5a059 !important;
            font-weight: 600;
        }

        .admin-sidebar .nav-link.text-info {
            color: #0284c7 !important;
        }

        .admin-sidebar .nav-link.text-info:hover {
            color: #0369a1 !important;
            background-color: rgba(197, 160, 89, 0.04) !important;
            border-left: 4px solid #c5a059 !important;
        }

        .admin-sidebar .nav-link.text-danger {
            color: #dc2626 !important;
        }

        .admin-sidebar .nav-link.text-danger:hover {
            color: #b91c1c !important;
            background-color: rgba(220, 38, 38, 0.06) !important;
            border-left: 4px solid #c5a059 !important;
        }

        .sidebar-category-title {
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            color: #9ca3af;
            padding: 0.75rem 1.5rem 0.35rem 1.5rem;
        }

        .admin-sidebar .nav-link-collapse .chevron-icon {
            font-size: 0.75rem;
            transition: transform 0.25s ease, color 0.25s ease;
            color: #9ca3af;
            margin-left: auto !important;
        }

        .admin-sidebar .nav-link-collapse:not(.collapsed) .chevron-icon {
            transform: rotate(180deg);
            color: #c5a059;
        }

        .admin-sidebar .nav-link-collapse:not(.collapsed) {
            color: #0f1115 !important;
            background-color: rgba(197, 160, 89, 0.04) !important;
        }

        .admin-sidebar .sidebar-submenu {
            background-color: transparent;
            border-left: none;
            margin: 0;
            padding: 0.2rem 0;
        }

        .admin-sidebar .submenu-link {
            display: block;
            padding: 0.45rem 1.5rem 0.45rem 3.25rem;
            font-size: 0.86rem;
            color: #6b7280;
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition-fast);
        }

        .admin-sidebar .submenu-link:hover {
            color: #0f1115;
            background-color: rgba(197, 160, 89, 0.04);
        }

        .admin-sidebar .submenu-link.active {
            color: #c5a059;
            font-weight: 600;
            background-color: rgba(197, 160, 89, 0.07);
        }
    </style>
</head>
<body class="bg-light">

<!-- Mobile Offcanvas Navigation Sidebar -->
<div class="offcanvas offcanvas-start admin-sidebar p-0 d-md-none" tabindex="-1" id="adminMobileSidebar" style="width: 260px;">
    <div class="offcanvas-header border-0 px-3 py-3">
        <a href="admin_home.php" class="brand-logo text-decoration-none">
            <span class="brand-full">CHR<img src="uploads/watch_o.png" class="watch-o-letter" alt="O" style="height: 1.08em; width: auto; vertical-align: -0.15em; margin: 0 2px 0 1px;">NO<span class="brand-gold">HUB</span></span>
        </a>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-0">
        <?php render_pooja_admin_nav_items($current_page, '-mobile'); ?>
    </div>
</div>

<div class="admin-main-wrapper">
    
    <!-- Admin Desktop Sidebar -->
    <aside class="admin-sidebar d-none d-md-block">
        <div class="sidebar-brand text-center d-flex align-items-center justify-content-between px-3">
            <a href="admin_home.php" class="brand-logo text-decoration-none">
                <span class="brand-full">CHR<img src="uploads/watch_o.png" class="watch-o-letter" alt="O" style="height: 1.08em; width: auto; vertical-align: -0.15em; margin: 0 2px 0 1px;">NO<span class="brand-gold">HUB</span></span>
                <span class="brand-mini"><img src="uploads/watch_o.png" class="watch-o-letter" alt="O" style="height: 1.08em; width: auto; vertical-align: -0.15em;"></span>
            </a>
            <button type="button" class="btn btn-link text-secondary p-0 sidebar-toggle-btn border-0 shadow-none" id="sidebarToggle" title="Toggle Sidebar Navigation">
                <i class="fa-solid fa-angles-left"></i>
            </button>
        </div>
        
        <?php render_pooja_admin_nav_items($current_page, '-desktop'); ?>
    </aside>

    <!-- Main Content Wrapper -->
    <div class="flex-grow-1 min-vh-100 d-flex flex-column style-full-width" style="min-width: 0; width: auto;">
        
        <!-- Top Navbar -->
        <header class="admin-top-header bg-white border-0 px-3 px-md-4 d-flex justify-content-between align-items-center">
            <!-- Left Side: Mobile Menu Button & Dynamic Header Title -->
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-link text-dark fs-4 p-0 d-md-none border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#adminMobileSidebar" aria-controls="adminMobileSidebar">
                    <i class="fa-solid fa-bars"></i>
                </button>
                
                <?php
                $header_title = "DASHBOARD";
                if ($current_page === 'admin_show_product.php') {
                    $header_title = "ALL PRODUCTS";
                } elseif ($current_page === 'admin_add_product.php') {
                    $header_title = "ADD PRODUCT";
                } elseif ($current_page === 'admin_update_product.php') {
                    $header_title = "EDIT PRODUCT";
                } elseif ($current_page === 'admin_view_product.php') {
                    $header_title = "PRODUCT DETAILS";
                } elseif ($current_page === 'admin_show_category.php') {
                    $header_title = "ALL CATEGORIES";
                } elseif ($current_page === 'admin_add_category.php') {
                    $header_title = "ADD CATEGORY";
                } elseif ($current_page === 'admin_update_category.php') {
                    $header_title = "EDIT CATEGORY";
                } elseif ($current_page === 'admin_show_order.php') {
                    $header_title = "ALL ORDERS";
                } elseif ($current_page === 'admin_update_order.php') {
                    $header_title = "EDIT ORDER";
                } elseif ($current_page === 'admin_show_profile.php') {
                    $header_title = "ADMIN PROFILE";
                } elseif ($current_page === 'admin_show_user.php') {
                    $header_title = "ALL CUSTOMERS";
                }
                ?>
                <span class="fw-bold text-uppercase text-secondary small mb-0" style="letter-spacing: 0.12em; font-size: 0.82rem; font-family: var(--font-nav);"><?php echo htmlspecialchars($header_title); ?></span>
            </div>
            
            <!-- Right Side: Admin Avatar Dropdown & Search Bar -->
            <div class="d-flex align-items-center gap-3">

                <!-- Clean Admin Avatar Icon & Dropdown -->
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle no-caret" id="adminUserDropdown" data-bs-toggle="dropdown" aria-expanded="false" title="Admin Profile">
                        <div class="admin-avatar-btn d-flex align-items-center justify-content-center rounded-circle text-white shadow-sm" style="width: 36px; height: 36px; background-color: #0f1115; border: 1.5px solid #c5a059;">
                            <i class="fa-solid fa-user-gear" style="font-size: 0.85rem; color: #c5a059;"></i>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-2 mt-2" aria-labelledby="adminUserDropdown" style="min-width: 200px;">
                        <li class="px-3 py-2 border-bottom bg-light">
                            <span class="d-block fw-bold text-dark small">Administrator</span>
                            <small class="text-muted" style="font-size: 0.75rem;"><i class="fa-solid fa-shield-halved text-success me-1"></i> Admin System</small>
                        </li>
                        <li>
                            <a class="dropdown-item py-2 small" href="admin_show_profile.php">
                                <i class="fa-regular fa-id-card me-2 text-secondary"></i> My Profile
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item py-2 small" href="home.php" target="_blank">
                                <i class="fa-solid fa-store me-2 text-primary"></i> View Storefront
                            </a>
                        </li>
                        <li><hr class="dropdown-divider my-1"></li>
                        <li>
                            <a class="dropdown-item py-2 small text-danger" href="logout.php">
                                <i class="fa-solid fa-power-off me-2"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>

            </div>
        </header>

        <main class="flex-grow-1 px-4 py-4 w-100" style="width: 100%;">

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggleBtn = document.getElementById('sidebarToggle');

    function toggleSidebarState(e) {
        if (e) {
            e.preventDefault();
            e.stopPropagation();
        }
        document.documentElement.classList.toggle('sidebar-collapsed');
        const isCollapsed = document.documentElement.classList.contains('sidebar-collapsed');
        localStorage.setItem('chronohub_sidebar_collapsed', isCollapsed ? 'true' : 'false');
        
        updateToggleIcon(isCollapsed);
    }

    function updateToggleIcon(isCollapsed) {
        if (toggleBtn) {
            const icon = toggleBtn.querySelector('i');
            if (icon) {
                icon.className = isCollapsed ? 'fa-solid fa-angles-right' : 'fa-solid fa-angles-left';
            }
        }
    }

    if (toggleBtn) {
        toggleBtn.addEventListener('click', toggleSidebarState);
    }

    if (document.documentElement.classList.contains('sidebar-collapsed')) {
        updateToggleIcon(true);
    }

    // Explicit click handler for accordion items
    document.querySelectorAll('.nav-link-collapse').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('data-bs-target');
            if (targetId) {
                const targetEl = document.querySelector(targetId);
                if (targetEl) {
                    if (typeof bootstrap !== 'undefined' && bootstrap.Collapse) {
                        const bsCollapse = bootstrap.Collapse.getOrCreateInstance(targetEl);
                        bsCollapse.toggle();
                    } else {
                        targetEl.classList.toggle('show');
                    }
                    this.classList.toggle('collapsed');
                    const isExpanded = !this.classList.contains('collapsed');
                    this.setAttribute('aria-expanded', isExpanded ? 'true' : 'false');
                }
            }
        });
    });
});
</script>