<?php
include("admin_header.php");
include("connect.php");
$query = "SELECT * FROM tbl_category";
$res = mysqli_query($con,$query);
$count = mysqli_num_rows($res);
$categories = array();
while($row = mysqli_fetch_assoc($res))
{
    $categories[] = $row;
}
?>

<style>
  .category-page-wrapper {
    width: 100% !important;
    max-width: 100% !important;
    margin: 0.5rem 0 2.5rem 0;
  }

  .cat-header-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.75rem;
    flex-wrap: wrap;
    gap: 1rem;
  }

  .cat-page-title {
    font-family: 'Playfair Display', Georgia, serif !important;
    font-size: 1.85rem;
    font-weight: 700;
    color: #111827;
    margin-bottom: 0.2rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
  }

  .cat-count-badge {
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

  .cat-page-subtitle {
    font-size: 0.85rem;
    color: #64748b;
  }

  .btn-add-category-luxury {
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

  .btn-add-category-luxury:hover {
    background: #000000;
    color: #ffffff;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
  }

  /* Table Card */
  .luxury-table-card {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid #edf2f7;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.04), 0 8px 10px -6px rgba(0, 0, 0, 0.02);
    overflow: hidden;
  }

  .luxury-cat-table {
    width: 100%;
    border-collapse: collapse;
    text-align: left;
  }

  .luxury-cat-table thead {
    background: #fafbfc;
    border-bottom: 1.5px solid #edf2f7;
  }

  .luxury-cat-table th {
    padding: 1rem 1.5rem;
    font-size: 0.74rem;
    font-weight: 700;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    color: #64748b;
  }

  .luxury-cat-table tbody tr {
    border-bottom: 1px solid #f1f5f9;
    transition: background-color 0.2s ease;
  }

  .luxury-cat-table tbody tr:hover {
    background-color: #fdfaf3;
  }

  .luxury-cat-table tbody tr:last-child {
    border-bottom: none;
  }

  .luxury-cat-table td {
    padding: 1.15rem 1.5rem;
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

  .cat-name-cell {
    display: flex;
    align-items: center;
    gap: 0.65rem;
    font-weight: 600;
    color: #0f172a;
    font-size: 0.95rem;
  }

  .cat-name-icon {
    width: 32px;
    height: 32px;
    background: #fbf7ee;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #b8860b;
    font-size: 0.85rem;
    flex-shrink: 0;
  }

  /* Image Thumbnail Frame */
  .cat-img-frame {
    width: 65px;
    height: 65px;
    border-radius: 10px;
    overflow: hidden;
    border: 1.5px solid #e2e8f0;
    background: #f8fafc;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
  }

  .cat-img-frame img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
  }

  .luxury-cat-table tbody tr:hover .cat-img-frame img {
    transform: scale(1.08);
  }

  /* Action Edit Button - Luxury Gold Styling */
  .btn-edit-luxury {
    background: linear-gradient(135deg, #fefcf6 0%, #fbf3de 100%);
    color: #925c0e;
    border: 1px solid #ebd49d;
    padding: 0.46rem 0.95rem;
    border-radius: 8px;
    font-size: 0.78rem;
    font-weight: 700;
    letter-spacing: 0.04em;
    text-transform: uppercase;
    display: inline-flex;
    align-items: center;
    gap: 0.45rem;
    text-decoration: none;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 2px 5px rgba(212, 175, 55, 0.12);
    position: relative;
    overflow: hidden;
  }

  .btn-edit-luxury i {
    font-size: 0.8rem;
    color: #b8860b;
    transition: transform 0.25s ease, color 0.25s ease;
  }

  .btn-edit-luxury:hover {
    background: linear-gradient(135deg, #d4af37 0%, #c59b27 50%, #a67c00 100%);
    color: #ffffff;
    border-color: #a67c00;
    box-shadow: 0 4px 14px rgba(184, 134, 11, 0.35), 0 2px 4px rgba(0, 0, 0, 0.06);
    transform: translateY(-2px);
  }

  .btn-edit-luxury:hover i {
    color: #ffffff;
    transform: scale(1.15) rotate(-6deg);
  }

  .btn-edit-luxury:active {
    transform: translateY(0);
    box-shadow: 0 2px 6px rgba(184, 134, 11, 0.2);
  }

  /* Action Delete Button */
  .btn-delete-luxury {
    background: linear-gradient(135deg, #fffafa 0%, #fee2e2 100%);
    color: #dc2626;
    border: 1px solid #fecaca;
    padding: 0.46rem 0.95rem;
    border-radius: 8px;
    font-size: 0.78rem;
    font-weight: 700;
    letter-spacing: 0.04em;
    text-transform: uppercase;
    display: inline-flex;
    align-items: center;
    gap: 0.45rem;
    text-decoration: none;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 2px 5px rgba(220, 38, 38, 0.08);
    position: relative;
    overflow: hidden;
  }

  .btn-delete-luxury i {
    font-size: 0.8rem;
    color: #dc2626;
    transition: transform 0.25s ease, color 0.25s ease;
  }

  .btn-delete-luxury:hover {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: #ffffff;
    border-color: #dc2626;
    box-shadow: 0 4px 14px rgba(220, 38, 38, 0.35), 0 2px 4px rgba(0, 0, 0, 0.06);
    transform: translateY(-2px);
  }

  .btn-delete-luxury:hover i {
    color: #ffffff;
    transform: scale(1.15) rotate(6deg);
  }

  .btn-delete-luxury:active {
    transform: translateY(0);
    box-shadow: 0 2px 6px rgba(220, 38, 38, 0.2);
  }

  /* Actions wrapper */
  .actions-cell-wrapper {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    justify-content: flex-end;
  }

  /* Empty State */
  .empty-cat-state {
    text-align: center;
    padding: 3.5rem 1.5rem;
    color: #94a3b8;
  }
  .empty-cat-icon {
    font-size: 2.5rem;
    color: #cbd5e1;
    margin-bottom: 0.75rem;
    display: block;
  }
</style>

<div class="category-page-wrapper">

    <!-- Header Row -->
    <div class="cat-header-row">
        <div>
            <h1 class="cat-page-title">
                List of Categories
                <span class="cat-count-badge"><?= $count ?> Total</span>
            </h1>
            <p class="cat-page-subtitle">Manage all luxury timepiece collection categories and catalog catalogs</p>
        </div>
        <a href="admin_add_category.php" class="btn-add-category-luxury">
            <i class="fa-solid fa-plus"></i>  Add Category
        </a>
    </div>

    <!-- Luxury Table Card -->
    <div class="luxury-table-card">
        <div style="overflow-x: auto;">
            <table class="luxury-cat-table">
                <thead>
                    <tr>
                        <th style="width: 100px; text-align: center;">Sr No</th>
                        <th>Category Name</th>
                        <th style="width: 160px; text-align: center;">Category Image</th>
                        <th style="width: 190px; text-align: right; padding-right: 2rem; white-space: nowrap;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                      $i = 1;
                      foreach ($categories as $c):
                    ?>
                    <tr>
                        <td style="text-align: center;">
                            <span class="sr-no-badge"><?= $i++ ?></span>
                        </td>
                        <td>
                            <div class="cat-name-cell">
                                <div class="cat-name-icon">
                                    <i class="fa-solid fa-tag"></i>
                                </div>
                                <span><?= $c['cname'] ?></span>
                            </div>
                        </td>
                        <td style="text-align: center;">
                            <div class="cat-img-frame" style="margin: 0 auto;">
                                <img src="<?= $c['cpic'] ?>" alt="">
                            </div>
                        </td>
                        <td style="text-align: right; padding-right: 2rem;">
                            <div class="actions-cell-wrapper">
                                <a href="admin_update_category.php?id=<?= $c['cid'] ?>" class="btn-edit-luxury">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <a href="admin_delete_category.php?id=<?= $c['cid'] ?>" class="btn-delete-luxury">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<?php
include("admin_footer.php");
?>