<?php
include("admin_header.php");

// Static admin details (since no database table exists)
$admin_profile = [
    'username'     => 'admin',
    'role'         => 'Admin',
    'member_since' => 'Jul 31, 2026',
    'full_name'    => 'ChronoHub Admin',
    'email'        => 'admin@gmail.com',
    'phone'        => '9878678910',
    'address'      => '100 Radha Nagar , Surat Gujarat',
    'city'         => 'Surat',
    'zipcode'      => '395001'
];
?>

<style>
  .profile-page-wrapper {
    width: 100% !important;
    max-width: 100% !important;
    margin: 0.5rem 0 3rem 0;
    font-family: 'Outfit', 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
  }

  /* Breadcrumb Tag */
  .profile-top-label {
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: #94a3b8;
    margin-bottom: 0.4rem;
    display: inline-block;
  }

  /* Header */
  .profile-header-title {
    font-family: 'Playfair Display', Georgia, serif !important;
    font-size: 2.1rem;
    font-weight: 700;
    color: #0f172a;
    margin: 0 0 0.35rem 0;
    letter-spacing: -0.01em;
  }

  .profile-header-subtitle {
    font-size: 0.88rem;
    color: #64748b;
    margin: 0 0 1.8rem 0;
  }

  /* Top 3 Summary Cards */
  .profile-summary-row {
    display: flex;
    gap: 1.25rem;
    margin-bottom: 2rem;
    flex-wrap: wrap;
  }

  .summary-badge-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 1.1rem 1.4rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    min-width: 220px;
    flex: 1;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }

  .summary-badge-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.04);
  }

  .summary-badge-info {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
  }

  .summary-badge-label {
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    color: #64748b;
  }

  .summary-badge-value {
    font-size: 1.4rem;
    font-weight: 800;
    color: #0f172a;
    line-height: 1.2;
  }

  .summary-badge-icon {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    flex-shrink: 0;
  }

  .icon-role {
    background: #fbf7ee;
    color: #ca8a04;
    border: 1px solid #ebd9b8;
  }

  .icon-user {
    background: #eff6ff;
    color: #3b82f6;
    border: 1px solid #dbeafe;
  }

  .icon-member {
    background: #ecfdf5;
    color: #059669;
    border: 1px solid #a7f3d0;
  }

  /* 2-Column Main Section */
  .profile-content-grid {
    display: grid;
    grid-template-columns: 1.55fr 1fr;
    gap: 2rem;
    align-items: flex-start;
  }

  /* Card Styles */
  .profile-form-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 2rem 2.2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
  }

  .card-section-header {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    font-family: 'Cinzel', 'Playfair Display', Georgia, serif;
    font-size: 1.25rem;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 1.8rem;
    padding-bottom: 0.85rem;
    border-bottom: 1px solid #f1f5f9;
  }

  .card-section-header i {
    font-size: 1.15rem;
    color: #ca8a04;
  }

  /* Form Elements */
  .form-group-item {
    display: flex;
    flex-direction: column;
    gap: 0.45rem;
    margin-bottom: 1.25rem;
  }

  .form-group-label {
    font-size: 0.74rem;
    font-weight: 700;
    letter-spacing: 0.05em;
    text-transform: uppercase;
    color: #475569;
  }

  .form-group-label .required-star {
    color: #dc2626;
  }

  .p-input-wrapper {
    position: relative;
    display: flex;
    align-items: center;
  }

  .p-input-icon {
    position: absolute;
    left: 1rem;
    color: #94a3b8;
    font-size: 0.9rem;
    pointer-events: none;
  }

  .p-input-control {
    width: 100%;
    padding: 0.75rem 1rem;
    background: #f8fafc;
    border: 1.5px solid #e2e8f0;
    border-radius: 10px;
    font-size: 0.9rem;
    color: #0f172a;
    font-weight: 500;
    transition: all 0.25s ease;
    font-family: inherit;
  }

  .p-input-control.has-icon {
    padding-left: 2.7rem;
  }

  .p-input-control:focus {
    outline: none;
    background: #ffffff;
    border-color: #0f172a;
    box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.08);
  }

  .p-input-control.readonly-input {
    background: #f1f5f9;
    color: #64748b;
    cursor: not-allowed;
    border-color: #e2e8f0;
  }

  textarea.p-input-control {
    resize: vertical;
    min-height: 80px;
  }

  .form-grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.15rem;
  }

  /* Account Security Notice */
  .security-info-box {
    display: flex;
    align-items: flex-start;
    gap: 0.55rem;
    font-size: 0.78rem;
    color: #64748b;
    line-height: 1.45;
    margin: 0.25rem 0 1.8rem 0;
  }

  .security-info-box i {
    color: #ca8a04;
    margin-top: 0.15rem;
    font-size: 0.85rem;
    flex-shrink: 0;
  }

  /* Action Buttons */
  .btn-submit-profile {
    width: 100%;
    background: #111827;
    color: #ffffff;
    border: none;
    padding: 0.85rem 1.4rem;
    border-radius: 10px;
    font-size: 0.86rem;
    font-weight: 700;
    letter-spacing: 0.04em;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    transition: all 0.25s ease;
    box-shadow: 0 4px 12px rgba(17, 24, 39, 0.15);
    margin-bottom: 0.85rem;
  }

  .btn-submit-profile:hover {
    background: #000000;
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(17, 24, 39, 0.25);
  }

  .btn-cancel-link {
    display: block;
    width: 100%;
    text-align: center;
    background: transparent;
    color: #64748b;
    border: none;
    font-size: 0.84rem;
    font-weight: 600;
    text-decoration: none;
    padding: 0.4rem;
    transition: color 0.2s ease;
    cursor: pointer;
  }

  .btn-cancel-link:hover {
    color: #0f172a;
  }

  @media (max-width: 992px) {
    .profile-content-grid {
      grid-template-columns: 1fr;
      gap: 1.8rem;
    }
    .profile-summary-row {
      flex-direction: column;
    }
  }

  @media (max-width: 576px) {
    .form-grid-2 {
      grid-template-columns: 1fr;
    }
  }
</style>

<div class="profile-page-wrapper">

    <!-- Top Label -->
    <span class="profile-top-label">ADMIN PROFILE</span>

    <!-- Page Header -->
    <h1 class="profile-header-title">Administrator Profile</h1>
    <p class="profile-header-subtitle">Manage your administrator credentials, personal identity, contact details, and account security.</p>

    <!-- Top 3 Metric Summary Cards -->
    <div class="profile-summary-row">
        <div class="summary-badge-card">
            <div class="summary-badge-info">
                <span class="summary-badge-label">Account Role</span>
                <span class="summary-badge-value"><?= htmlspecialchars($admin_profile['role']) ?></span>
            </div>
            <div class="summary-badge-icon icon-role">
                <i class="fa-solid fa-shield-halved"></i>
            </div>
        </div>

        <div class="summary-badge-card">
            <div class="summary-badge-info">
                <span class="summary-badge-label">Username</span>
                <span class="summary-badge-value"><?= htmlspecialchars($admin_profile['username']) ?></span>
            </div>
            <div class="summary-badge-icon icon-user">
                <i class="fa-solid fa-user"></i>
            </div>
        </div>

        <div class="summary-badge-card">
            <div class="summary-badge-info">
                <span class="summary-badge-label">Member Since</span>
                <span class="summary-badge-value"><?= htmlspecialchars($admin_profile['member_since']) ?></span>
            </div>
            <div class="summary-badge-icon icon-member">
                <i class="fa-regular fa-calendar-check"></i>
            </div>
        </div>
    </div>

    <!-- Main 2-Column Grid -->
    <div class="profile-content-grid">

        <!-- Column 1: Personal Identity & Contact -->
        <div class="profile-form-card">
            <div class="card-section-header">
                <i class="fa-regular fa-address-card"></i> Personal Identity & Contact
            </div>

            <form action="#" method="POST">
                <div class="form-grid-2">
                    <div class="form-group-item">
                        <label class="form-group-label">Username</label>
                        <input type="text" class="p-input-control readonly-input" value="<?= htmlspecialchars($admin_profile['username']) ?>" readonly>
                    </div>

                    <div class="form-group-item">
                        <label class="form-group-label">Account Role</label>
                        <input type="text" class="p-input-control readonly-input" value="<?= htmlspecialchars($admin_profile['role']) ?>" readonly>
                    </div>
                </div>

                <div class="form-group-item">
                    <label class="form-group-label">Full Name <span class="required-star">*</span></label>
                    <input type="text" name="txtfullname" class="p-input-control" value="<?= htmlspecialchars($admin_profile['full_name']) ?>">
                </div>

                <div class="form-grid-2">
                    <div class="form-group-item">
                        <label class="form-group-label">Email Address <span class="required-star">*</span></label>
                        <div class="p-input-wrapper">
                            <i class="fa-regular fa-envelope p-input-icon"></i>
                            <input type="email" name="txtemail" class="p-input-control has-icon" value="<?= htmlspecialchars($admin_profile['email']) ?>">
                        </div>
                    </div>

                    <div class="form-group-item">
                        <label class="form-group-label">Phone Number</label>
                        <div class="p-input-wrapper">
                            <i class="fa-solid fa-phone p-input-icon"></i>
                            <input type="text" name="txtphone" class="p-input-control has-icon" value="<?= htmlspecialchars($admin_profile['phone']) ?>">
                        </div>
                    </div>
                </div>

                <div class="form-group-item">
                    <label class="form-group-label">Office / Street Address</label>
                    <textarea name="txtaddress" class="p-input-control" rows="3"><?= htmlspecialchars($admin_profile['address']) ?></textarea>
                </div>

                <div class="form-grid-2" style="margin-bottom: 0;">
                    <div class="form-group-item" style="margin-bottom: 0;">
                        <label class="form-group-label">City</label>
                        <input type="text" name="txtcity" class="p-input-control" value="<?= htmlspecialchars($admin_profile['city']) ?>">
                    </div>

                    <div class="form-group-item" style="margin-bottom: 0;">
                        <label class="form-group-label">Zip / Postal Code</label>
                        <input type="text" name="txtzip" class="p-input-control" value="<?= htmlspecialchars($admin_profile['zipcode']) ?>">
                    </div>
                </div>
            </form>
        </div>

        <!-- Column 2: Account Security -->
        <div class="profile-form-card">
            <div class="card-section-header">
                <i class="fa-solid fa-key"></i> Account Security
            </div>

            <form action="#" method="POST">
                <div class="form-group-item">
                    <label class="form-group-label">New Password</label>
                    <div class="p-input-wrapper">
                        <i class="fa-solid fa-lock p-input-icon"></i>
                        <input type="password" name="txtpassword" class="p-input-control has-icon" placeholder="Leave blank to keep current">
                    </div>
                </div>

                <div class="form-group-item">
                    <label class="form-group-label">Confirm New Password</label>
                    <div class="p-input-wrapper">
                        <i class="fa-solid fa-shield-halved p-input-icon"></i>
                        <input type="password" name="txtcpassword" class="p-input-control has-icon" placeholder="Repeat new password">
                    </div>
                </div>

                <div class="security-info-box">
                    <i class="fa-solid fa-circle-info"></i>
                    <span>Password must be at least 6 characters long. Leave password fields blank if you do not wish to update your password.</span>
                </div>

                <button type="submit" name="btnupdate" class="btn-submit-profile">
                    <i class="fa-solid fa-check"></i> Update Profile Settings
                </button>

                <a href="admin_home.php" class="btn-cancel-link">Cancel</a>
            </form>
        </div>

    </div>

</div>

<?php
include("admin_footer.php");
?>
