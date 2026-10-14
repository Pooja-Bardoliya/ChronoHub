<?php
    include("admin_header.php");
    include("connect.php");
    $id = $_GET['id'];
    $query = "SELECT * FROM tbl_category WHERE cid = $id";
    $res = mysqli_query($con,$query);
    $row = mysqli_fetch_assoc($res);

    if(isset($_POST['btnsubmit']))
    {
        $catname = $_POST['txtcatname'];
        if(empty('$catname'))
        {
            echo "<script>alert('Please fill all the fields')</script>";
        }
        else
        {
            $catimage = $_FILES['txtcatimage']['name'];
            $tmp_name = $_FILES['txtcatimage']['tmp_name'];

            $query = "UPDATE `tbl_category` SET `cname` = '$catname', `cpic` = 'uploads/$catimage' WHERE `tbl_category`.`cid` = $id;";
            $res = mysqli_query($con,$query);
            if($res>0)
            {
                move_uploaded_file($tmp_name,"uploads/".$catimage);
                echo "<script>window.location.href='admin_show_category.php'</script>";
            }
        }
    }
?>

<style>
  .form-page-container {
    max-width: 680px;
    margin: 0.5rem auto 2rem auto;
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

  .custom-input-text {
    width: 100%;
    background: #f8fafc;
    border: 1.5px solid #e2e8f0;
    border-radius: 10px;
    padding: 0.75rem 1rem;
    font-size: 0.9rem;
    color: #0f172a;
    font-family: var(--font-sans);
    transition: all 0.2s ease;
    outline: none;
  }

  .custom-input-text:focus {
    background: #ffffff;
    border-color: #d4af37;
    box-shadow: 0 0 0 4px rgba(212, 175, 55, 0.15);
  }

  .custom-file-wrapper {
    background: #f8fafc;
    border: 2px dashed #cbd5e1;
    border-radius: 12px;
    padding: 1.5rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s ease;
    position: relative;
  }

  .custom-file-wrapper:hover {
    border-color: #d4af37;
    background: #fdfaf3;
  }

  .custom-file-icon {
    font-size: 2rem;
    color: #94a3b8;
    margin-bottom: 0.5rem;
    display: block;
    transition: color 0.2s ease;
  }

  .custom-file-wrapper:hover .custom-file-icon {
    color: #b8860b;
  }

  .custom-file-input {
    width: 100%;
    cursor: pointer;
    font-size: 0.85rem;
    color: #64748b;
  }

  .custom-file-input::file-selector-button {
    background: #111827;
    color: #d4af37;
    border: none;
    padding: 0.45rem 1rem;
    border-radius: 6px;
    font-size: 0.78rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    cursor: pointer;
    margin-right: 0.85rem;
    transition: all 0.2s ease;
  }

  .custom-file-input::file-selector-button:hover {
    background: #000000;
    color: #ffffff;
  }

  .form-actions {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 1px solid #f1f5f9;
  }

  .btn-submit-luxury {
    flex: 1;
    background: #111827;
    color: #d4af37;
    border: 1px solid #1f2937;
    padding: 0.8rem 1.5rem;
    font-size: 0.85rem;
    font-weight: 700;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    border-radius: 10px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    cursor: pointer;
    transition: all 0.25s ease;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  }

  .btn-submit-luxury:hover {
    background: #000000;
    color: #ffffff;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
  }

  .btn-back-luxury {
    background: #ffffff;
    color: #64748b;
    border: 1.5px solid #e2e8f0;
    padding: 0.8rem 1.5rem;
    font-size: 0.85rem;
    font-weight: 600;
    border-radius: 10px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
  }

  .btn-back-luxury:hover {
    background: #f8fafc;
    color: #0f172a;
    border-color: #cbd5e1;
  }
</style>

<div class="form-page-container">

    <!-- Header Row -->
    <div class="form-header-area">
        <div>
            <h1 class="form-title">Edit Category</h1>
            <p class="form-subtitle">Create a new luxury watch catalog collection category</p>
        </div>
        <a href="admin_show_category.php" class="btn-back-luxury">
            <i class="fa-solid fa-arrow-left"></i> View Categories
        </a>
    </div>

    <!-- Luxury Card Form -->
    <div class="luxury-form-card">
        <div class="card-top-badge">
            <i class="fa-solid fa-layer-group"></i> Category Information
        </div>

        <form action="" method="post" enctype="multipart/form-data">
            <div class="custom-form-group">
                <label class="custom-form-label">
                    <i class="fa-solid fa-tag"></i> Category Name
                </label>
                <input type="text" class="custom-input-text" placeholder="e.g. Chronograph Watches, Luxury Automatic" name="txtcatname">
            </div>

            <div class="custom-form-group">
                <label class="custom-form-label">
                    <i class="fa-solid fa-image"></i> Category Image
                </label>
                <div class="custom-file-wrapper">
                    <i class="fa-solid fa-cloud-arrow-up custom-file-icon"></i>
                    <input class="custom-file-input" type="file" name="txtcatimage">
                    <small style="display: block; color: #94a3b8; margin-top: 0.5rem; font-size: 0.78rem;">PNG, JPG, WEBP formats supported</small>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit-luxury" name="btnsubmit">
                    <i class="fa-solid fa-plus"></i> Edit Category
                </button>
                <a href="admin_show_category.php" class="btn-back-luxury">Back</a>
            </div>
        </form>
    </div>

</div>


<?php
    include("admin_footer.php");
?>