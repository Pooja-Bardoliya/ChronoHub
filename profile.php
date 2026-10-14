<?php
include 'header.php';
include 'connect.php';

if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit();
}

$userid = $_SESSION['userid'];

// Update Profile
if (isset($_POST['btnupdate'])) {

    $username = $_POST['username'];
    $email = $_POST['email'];
    $mobileno = $_POST['mobileno'];
    $address = $_POST['address'];

    $query = "UPDATE tbl_user SET
              username = '$username',
              email = '$email',
              mobileno = '$mobileno',
              address = '$address'
              WHERE user_id = '$userid'";

    mysqli_query($con, $query);

    $_SESSION['username'] = $username;

    echo "<script>alert('Profile updated successfully!');</script>";
}

// Get User Data
$query = "SELECT * FROM tbl_user WHERE user_id = '$userid'";
$result = mysqli_query($con, $query);

$user = mysqli_fetch_assoc($result);

// First letter of username
$initial_letter = strtoupper(substr($user['username'], 0, 1));
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
    .text-gold {
        color: #c5a880 !important;
    }
    .btn-luxury-dark {
        background-color: #111111;
        color: #ffffff;
        border: 1px solid #111111;
        transition: all 0.25s ease;
    }
    .btn-luxury-dark:hover {
        background-color: #333333;
        color: #ffffff;
    }
</style>

<!-- Hero / Header Banner -->
<div class="py-5 bg-light border-bottom mb-5">
    <div class="container text-center">
        <span class="text-uppercase text-gold fw-bold small tracking-wider font-nav">Customer Account</span>
        <h1 class="font-heading display-6 fw-bold text-dark mt-1 mb-2">My Profile Settings</h1>
        <p class="text-muted font-nav mx-auto mb-0" style="max-width: 580px;">
            Manage your personal details and default shipping preferences for your account.
        </p>
    </div>
</div>

<div class="container pb-5">
    
    <?php if (!empty($success_msg)): ?>
        <div class="alert alert-success alert-dismissible fade show font-nav mb-4 mx-auto" style="max-width: 900px;" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i> <?php echo htmlspecialchars($success_msg); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (!empty($error_msg)): ?>
        <div class="alert alert-danger alert-dismissible fade show font-nav mb-4 mx-auto" style="max-width: 900px;" role="alert">
            <i class="fa-solid fa-triangle-exclamation me-2"></i> <?php echo htmlspecialchars($error_msg); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <form action="profile.php" method="POST">
        <div class="row g-4 justify-content-center">
            
            <!-- Left Column: Personal & Shipping Details -->
            <div class="col-lg-8 col-xl-8">
                <div class="bg-white border rounded-4 shadow-sm p-4 p-md-5 mb-4">
                    <h4 class="font-heading fw-bold text-dark mb-4 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-address-card text-gold"></i> Personal & Shipping Details
                    </h4>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label font-nav small fw-bold text-uppercase">Username <span class="text-danger">*</span></label>
                            <input type="text" name="username" class="form-control font-nav" value="<?php echo htmlspecialchars($user['username'] ?? ''); ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label font-nav small fw-bold text-uppercase">Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control font-nav" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" required>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label font-nav small fw-bold text-uppercase">Mobile Number (10 Digits)</label>
                            <input type="tel" name="mobileno" class="form-control font-nav" placeholder="e.g. 9876543210" pattern="[0-9]{10}" maxLength="10" value="<?php echo htmlspecialchars($user['mobileno'] ?? ''); ?>">
                        </div>

                        <div class="col-12">
                            <label class="form-label font-nav small fw-bold text-uppercase">Default Shipping Address</label>
                            <textarea name="address" class="form-control font-nav" rows="4" placeholder="Street address, apartment, suite, city, state, etc."><?php echo htmlspecialchars($user['address'] ?? ''); ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Sidebar: Account Summary -->
            <div class="col-lg-4 col-xl-4">
                
                <div class="bg-white border rounded-4 shadow-sm p-4 text-center">
                    
                    <!-- Avatar Circle -->
                    <div class="mx-auto mb-3 bg-dark text-gold rounded-circle d-flex align-items-center justify-content-center fw-bold fs-2 font-heading border border-2 border-warning" style="width: 80px; height: 80px;">
                        <?php echo htmlspecialchars($initial_letter); ?>
                    </div>

                    <h4 class="font-heading fw-bold text-dark mb-1"><?php echo htmlspecialchars($user['username'] ?? ''); ?></h4>
                    <p class="text-muted font-nav small mb-4 pb-1"><?php echo htmlspecialchars($user['email'] ?? ''); ?></p>

                    <div class="d-flex flex-column gap-3 text-start font-nav small mb-4 border-top pt-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="text-muted"><i class="fa-solid fa-id-badge me-2 text-gold"></i>User Account ID</span>
                            <strong class="text-dark">#<?php echo htmlspecialchars($user['user_id'] ?? ''); ?></strong>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="text-muted"><i class="fa-solid fa-circle-check me-2 text-success"></i>Account Status</span>
                            <strong class="text-success">Active Member</strong>
                        </div>
                    </div>

                    <a href="my_orders.php" class="btn btn-outline-dark font-nav text-uppercase tracking-wider fw-bold small rounded-3 w-100 py-2.5 mb-3">
                        <i class="fa-solid fa-box-open me-2"></i> View Order History
                    </a>

                    <button type="submit" name="btnupdate" class="btn btn-luxury-dark font-nav text-uppercase tracking-wider fw-bold small rounded-3 w-100 py-2.5">
                        <i class="fa-solid fa-floppy-disk me-2"></i> Save Profile Changes
                    </button>
                </div>

            </div>

        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js">
</script>

<?php
include 'footer.php';
?>
