<?php
include("admin_header.php");
include("connect.php");
$query = "SELECT * FROM tbl_user";
$res = mysqli_query($con,$query);
$count = mysqli_num_rows($res);
$users = array();
while($row = mysqli_fetch_assoc($res)){
    $users[]=$row;
}
?>

<style>
  .user-page-wrapper {
    width: 100% !important;
    max-width: 100% !important;
    margin: 0.5rem 0 2.5rem 0;
  }

  .user-header-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.75rem;
    flex-wrap: wrap;
    gap: 1rem;
  }

  .user-page-title {
    font-family: 'Playfair Display', Georgia, serif !important;
    font-size: 1.85rem;
    font-weight: 700;
    color: #111827;
    margin-bottom: 0.2rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
  }

  .user-count-badge {
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

  .user-page-subtitle {
    font-size: 0.85rem;
    color: #64748b;
  }

  .btn-back-luxury {
    background: #ffffff;
    color: #64748b;
    border: 1.5px solid #e2e8f0;
    padding: 0.75rem 1.4rem;
    font-size: 0.82rem;
    font-weight: 600;
    border-radius: 10px;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    text-decoration: none;
    transition: all 0.2s ease;
  }

  .btn-back-luxury:hover {
    background: #f8fafc;
    color: #0f172a;
    border-color: #cbd5e1;
  }

  /* Table Card */
  .luxury-table-card {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid #edf2f7;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.04), 0 8px 10px -6px rgba(0, 0, 0, 0.02);
    overflow: hidden;
  }

  .luxury-user-table-responsive {
    overflow-x: auto;
    width: 100%;
  }

  .luxury-user-table {
    width: 100%;
    border-collapse: collapse;
    text-align: left;
  }

  .luxury-user-table thead {
    background: #fafbfc;
    border-bottom: 1.5px solid #edf2f7;
  }

  .luxury-user-table th {
    padding: 1rem 1.4rem;
    font-size: 0.74rem;
    font-weight: 700;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    color: #64748b;
    white-space: nowrap;
  }

  .luxury-user-table tbody tr {
    border-bottom: 1px solid #f1f5f9;
    transition: background-color 0.2s ease;
  }

  .luxury-user-table tbody tr:hover {
    background-color: #fdfaf3;
  }

  .luxury-user-table tbody tr:last-child {
    border-bottom: none;
  }

  .luxury-user-table td {
    padding: 1.15rem 1.4rem;
    vertical-align: middle;
    color: #1e293b;
    font-size: 0.9rem;
  }

  .sr-no-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-weight: 700;
    font-size: 0.8rem;
    color: #64748b;
  }

  .user-name-cell {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-weight: 600;
    color: #0f172a;
  }

  .user-avatar-badge {
    width: 34px;
    height: 34px;
    background: #f1f5f9;
    border: 1px solid #e2e8f0;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #64748b;
    font-size: 0.85rem;
    flex-shrink: 0;
  }

  .email-text {
    color: #475569;
    font-weight: 500;
  }

  .contact-text {
    font-weight: 600;
    color: #0f172a;
    letter-spacing: 0.02em;
  }

  .address-text {
    color: #64748b;
    max-width: 250px;
    line-height: 1.4;
  }
</style>

<div class="user-page-wrapper">

    <!-- Header Row -->
    <div class="user-header-row">
        <div>
            <h1 class="user-page-title">
                List of Customers
                <span class="user-count-badge"><?= $count ?> Total</span>
            </h1>
            <p class="user-page-subtitle">View and inspect registered customer accounts, contact details, and shipping addresses</p>
        </div>
        <a href="admin_home.php" class="btn-back-luxury">
            <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>

    <!-- Luxury Table Card -->
    <div class="luxury-table-card">
        <div class="luxury-user-table-responsive">
            <table class="luxury-user-table">
                <thead>
                    <tr>
                        <th style="width: 90px; text-align: center;">Sr No</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Contact No</th>
                        <th>Address</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($users as $u) {?>   
                        <tr>
                            <td style="text-align: center;" scope="row">
                                <span class="sr-no-badge"><?php echo $u['user_id'] ?></span>
                            </td>
                            <td>
                                <div class="user-name-cell">
                                    <div class="user-avatar-badge">
                                        <i class="fa-solid fa-user"></i>
                                    </div>
                                    <span><?php echo $u['username'] ?></span>
                                </div>
                            </td>
                            <td>
                                <span class="email-text"><?php echo $u['email'] ?></span>
                            </td>
                            <td>
                                <span class="contact-text"><?php echo $u['mobileno'] ?></span>
                            </td>
                            <td>
                                <span class="address-text"><?php echo $u['address'] ?></span>
                            </td>
                        </tr>
                    <?php }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<?php
include("admin_footer.php");
?>