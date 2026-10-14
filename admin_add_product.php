<?php
    include("admin_header.php");
    include("connect.php");
    if(isset($_POST['btnsubmit']))
    {
        $pname = $_POST['txtpname'];
        $gender = $_POST['rdbgender'];
        $price = $_POST['txtprice'];
        $discount = $_POST['txtdiscount'];
        $description = $_POST['txtdesciption'];
        $bestseller = $_POST['txtbestseller'] ?? "no";
        $waterresis = $_POST['txtwaterresis'];
        $category = $_POST['txtcategory'];
        $dialcolor = $_POST['txtdialcolor'];
        $strapmaterial = $_POST['txtstrapmaterial'];
        $strapcolor = $_POST['txtstrapcolor'];
        $brand = $_POST['txtbrand'];
        $stock  = $_POST['txtstock'];   
        $casesize = $_POST['txtcasesize'];
        $movement = $_POST['txtmovement'];
        if($bestseller=="yes"){
            $best=true;
        }else{
            $best=false;
        }
        
        
        if(empty($pname) || empty($gender) || empty($price) || empty($discount) || empty($description) || empty($bestseller) || empty($waterresis) || empty($category) || empty($dialcolor) || empty($strapmaterial) || empty($strapcolor) || empty($brand) || empty($casesize) || empty($movement))
        {
            echo "<script>alert('Please fill all the fields')</script>";
        }
        else
        {
            $prodimage = $_FILES['txtpimage']['name'];
            $tmp_name = $_FILES['txtpimage']['tmp_name'];

            $query = "INSERT INTO `tbl_product` (`pid`, `cid`, `name`, `gender`, `brand`, `price`, `discount`, `stock`, `movement`, `descrip`, `pic`, `bestseller`, `water_resist`, `dial_color`, `strap_material`, `strap_color`, `case_size`) VALUES (NULL, '$category', '$pname', '$gender', '$brand', '$price', '$discount', '$stock', '$movement', '$description', 'uploads/$prodimage', '$best', '$waterresis', '$dialcolor', '$strapmaterial', '$strapcolor', '$casesize');";
            // echo $query;

            $res = mysqli_query($con,$query);
            if($res>0)
            {
                move_uploaded_file($tmp_name,"uploads/".$prodimage);
                echo "<script>window.location.href='admin_show_product.php'</script>";
            }
            
        }
    }

    // Fetch all categories for dropdown selection
    $cat_query = "SELECT * FROM tbl_category";
    $cat_res = mysqli_query($con, $cat_query);
    $categories = array();
    while($cat_row = mysqli_fetch_assoc($cat_res))
    {
        $categories[] = $cat_row;
    }
?>

<style>
  .product-form-container {
    max-width: 960px;
    margin: 0.5rem auto 2.5rem auto;
    width: 100%;
  }

  .form-header-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.75rem;
    flex-wrap: wrap;
    gap: 1rem;
  }

  .form-main-title {
    font-family: 'Playfair Display', Georgia, serif !important;
    font-size: 1.85rem;
    font-weight: 700;
    color: #111827;
    margin-bottom: 0.2rem;
  }

  .form-main-subtitle {
    font-size: 0.85rem;
    color: #64748b;
  }

  .luxury-product-card {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid #edf2f7;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.04), 0 8px 10px -6px rgba(0, 0, 0, 0.02);
    padding: 2.25rem 2.5rem;
  }

  .form-section-divider {
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    color: #b8860b;
    background: #fbf7ee;
    border: 1px solid #ebd9b8;
    padding: 0.4rem 0.85rem;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    margin: 1.5rem 0 1.25rem 0;
  }
  .form-section-divider:first-of-type {
    margin-top: 0;
  }

  .form-grid-2 {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.25rem;
    margin-bottom: 1.25rem;
  }

  .form-grid-3 {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.25rem;
    margin-bottom: 1.25rem;
  }

  @media (max-width: 768px) {
    .form-grid-2,
    .form-grid-3 {
      grid-template-columns: 1fr;
    }
    .luxury-product-card {
      padding: 1.5rem;
    }
  }

  .p-form-group {
    display: flex;
    flex-direction: column;
    margin-bottom: 1.25rem;
  }

  .p-form-label {
    display: flex;
    align-items: center;
    gap: 0.45rem;
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: 0.04em;
    text-transform: uppercase;
    color: #334155;
    margin-bottom: 0.45rem;
  }

  .p-form-label i {
    color: #b8860b;
    font-size: 0.8rem;
  }

  .p-form-control,
  .p-form-select {
    width: 100%;
    background: #f8fafc;
    border: 1.5px solid #e2e8f0;
    border-radius: 9px;
    padding: 0.7rem 0.95rem;
    font-size: 0.88rem;
    color: #0f172a;
    font-family: var(--font-sans);
    transition: all 0.2s ease;
    outline: none;
  }

  .p-form-control:focus,
  .p-form-select:focus {
    background: #ffffff;
    border-color: #d4af37;
    box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.15);
  }

  /* Gender Radio Buttons */
  .gender-pill-wrapper {
    display: flex;
    gap: 0.75rem;
    background: #f8fafc;
    border: 1.5px solid #e2e8f0;
    padding: 0.4rem 0.65rem;
    border-radius: 9px;
  }

  .gender-radio-label {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    font-size: 0.85rem;
    font-weight: 600;
    color: #475569;
    cursor: pointer;
    margin: 0 0.5rem;
  }

  .gender-radio-label input[type="radio"] {
    accent-color: #111827;
    cursor: pointer;
  }

  /* BestSeller Switch Toggle */
  .bestseller-box {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #f8fafc;
    border: 1.5px solid #e2e8f0;
    padding: 0.65rem 1rem;
    border-radius: 9px;
  }

  .bestseller-box input[type="checkbox"] {
    accent-color: #111827;
    width: 18px;
    height: 18px;
    cursor: pointer;
  }

  /* Product Media Dropzone */
  .product-file-dropzone {
    background: #f8fafc;
    border: 2px dashed #cbd5e1;
    border-radius: 12px;
    padding: 1.4rem;
    text-align: center;
    transition: all 0.2s ease;
  }

  .product-file-dropzone:hover {
    border-color: #d4af37;
    background: #fdfaf3;
  }

  .product-file-input {
    width: 100%;
    cursor: pointer;
    font-size: 0.85rem;
    color: #64748b;
  }

  .product-file-input::file-selector-button {
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

  .product-file-input::file-selector-button:hover {
    background: #000000;
    color: #ffffff;
  }

  /* Action Buttons */
  .form-actions-row {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 1px solid #f1f5f9;
  }

  .btn-create-product {
    flex: 1;
    background: #111827;
    color: #d4af37;
    border: 1px solid #1f2937;
    padding: 0.85rem 1.75rem;
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

  .btn-create-product:hover {
    background: #000000;
    color: #ffffff;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
  }

  .btn-back-product {
    background: #ffffff;
    color: #64748b;
    border: 1.5px solid #e2e8f0;
    padding: 0.85rem 1.5rem;
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

  .btn-back-product:hover {
    background: #f8fafc;
    color: #0f172a;
    border-color: #cbd5e1;
  }
</style>

<div class="product-form-container">

    <!-- Header Row -->
    <div class="form-header-row">
        <div>
            <h1 class="form-main-title">Add Product</h1>
            <p class="form-main-subtitle">Add luxury timepiece models, specifications, and catalog gallery</p>
        </div>
        <a href="admin_show_product.php" class="btn-back-product">
            <i class="fa-solid fa-arrow-left"></i> Back to Products
        </a>
    </div>

    <!-- Main Form Card -->
    <div class="luxury-product-card">

        <form action="" method="post" enctype="multipart/form-data">

            <!-- SECTION 1: PRODUCT IMAGE -->
            <div class="form-section-divider">
                <i class="fa-solid fa-image"></i> Product Image
            </div>

            <div class="p-form-group">
                <div class="product-file-dropzone">
                    <i class="fa-solid fa-cloud-arrow-up" style="font-size: 1.8rem; color: #94a3b8; margin-bottom: 0.4rem; display: block;"></i>
                    <input class="product-file-input" type="file" name="txtpimage" required>
                    <small style="display: block; color: #94a3b8; margin-top: 0.45rem; font-size: 0.78rem;">Select high resolution product timepiece image (PNG, JPEG)</small>
                </div>
            </div>

            <!-- SECTION 2: PRIMARY INFORMATION -->
            <div class="form-section-divider">
                <i class="fa-solid fa-gem"></i> Primary Information
            </div>

            <div class="p-form-group">
                <label class="p-form-label">
                    <i class="fa-solid fa-tag"></i> Product Name :
                </label>
                <input type="text" class="p-form-control" placeholder="Enter Product name" name="txtpname">
            </div>

            <div class="form-grid-3">
                <div class="p-form-group" style="margin-bottom: 0;">
                    <label class="p-form-label">
                        <i class="fa-solid fa-copyright"></i> Brand
                    </label>
                    <select class="p-form-select" name="txtbrand">
                        <option value="" disabled selected>Choose Brand</option>
                        <option value="Casio">Casio</option>
                        <option value="Titan">Titan</option>
                        <option value="Fossil">Fossil</option>
                        <option value="Tissot">Tissot</option>
                        <option value="Omega">Omega</option>
                        <option value="Seiko">Seiko</option>
                    </select>
                </div>

                <div class="p-form-group" style="margin-bottom: 0;">
                    <label class="p-form-label">
                        <i class="fa-solid fa-layer-group"></i> Category
                    </label>
                    <select class="p-form-select" name="txtcategory" required>
                        <option value="" disabled selected>Choose Category</option>
                        <?php foreach($categories as $c) : ?>
                            <option value="<?= $c['cid'] ?>"><?= $c['cname'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="p-form-group" style="margin-bottom: 0;">
                    <label class="p-form-label">
                        <i class="fa-solid fa-venus-mars"></i> Gender
                    </label>
                    <div class="gender-pill-wrapper">
                        <label class="gender-radio-label">
                            <input type="radio" name="rdbgender" value="Male" checked> Male
                        </label>
                        <label class="gender-radio-label">
                            <input type="radio" name="rdbgender" value="Female"> Female
                        </label>
                        <label class="gender-radio-label">
                            <input type="radio" name="rdbgender" value="Unisex"> Unisex
                        </label>
                    </div>
                </div>
            </div>

            <!-- SECTION 3: PRICING & INVENTORY -->
            <div class="form-section-divider">
                <i class="fa-solid fa-indian-rupee-sign"></i> Pricing & Inventory
            </div>

            <div class="form-grid-3">
                <div class="p-form-group" style="margin-bottom: 0;">
                    <label class="p-form-label">
                        <i class="fa-solid fa-receipt"></i> Price (₹)
                    </label>
                    <input type="number" step="any" class="p-form-control" placeholder="e.g. 15999" name="txtprice">
                </div>

                <div class="p-form-group" style="margin-bottom: 0;">
                    <label class="p-form-label">
                        <i class="fa-solid fa-percent"></i> Discount (₹ or %)
                    </label>
                    <input type="number" step="any" class="p-form-control" placeholder="e.g. 10" name="txtdiscount">
                </div>

                <div class="p-form-group" style="margin-bottom: 0;">
                    <label class="p-form-label">
                        <i class="fa-solid fa-boxes-stacked"></i> Stock Quantity
                    </label>
                    <input type="number" step="any" class="p-form-control" placeholder="Enter Stock Quantity" name="txtstock">
                </div>
            </div>

            <div class="p-form-group">
                <label class="p-form-label">
                    <i class="fa-solid fa-star"></i> BestSeller Status
                </label>
                <div class="bestseller-box">
                    <span style="font-size: 0.85rem; font-weight: 600; color: #475569;">Feature on Homepage / Signature Collection</span>
                    <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; font-size: 0.85rem; font-weight: 700; color: #111827;">
                        <input type="checkbox" name="txtbestseller" value="yes" checked> Yes
                    </label>
                </div>
            </div>

            <!-- SECTION 4: TECHNICAL SPECIFICATIONS -->
            <div class="form-section-divider">
                <i class="fa-solid fa-sliders"></i> Technical Specifications
            </div>

            <div class="form-grid-3">
                <div class="p-form-group" style="margin-bottom: 0;">
                    <label class="p-form-label">
                        <i class="fa-solid fa-gears"></i> Movement
                    </label>
                    <select class="p-form-select" name="txtmovement">
                        <option value="" disabled selected>Choose Movement</option>
                        <option value="Quartz">Quartz</option>
                        <option value="Automatic">Automatic</option>
                        <option value="Mechanical">Mechanical</option>
                    </select>
                </div>

                <div class="p-form-group" style="margin-bottom: 0;">
                    <label class="p-form-label">
                        <i class="fa-solid fa-ruler-combined"></i> Case Diameter
                    </label>
                    <input type="text" class="p-form-control" placeholder="e.g. 40mm, 42mm" name="txtcasesize">
                </div>

                <div class="p-form-group" style="margin-bottom: 0;">
                    <label class="p-form-label">
                        <i class="fa-solid fa-water"></i> Water Resistance
                    </label>
                    <input type="text" class="p-form-control" placeholder="e.g. 50M, 100M Water Resistant" name="txtwaterresis">
                </div>
            </div>

            <div class="form-grid-3">
                <div class="p-form-group" style="margin-bottom: 0;">
                    <label class="p-form-label">
                        <i class="fa-solid fa-palette"></i> Dial Color
                    </label>
                    <select class="p-form-select" name="txtdialcolor">
                        <option value="" disabled selected>Choose Color</option>
                        <option value="Blue">Blue</option>
                        <option value="Red">Red</option>
                        <option value="Silver">Silver</option>
                        <option value="Gold">Gold</option>
                        <option value="Black">Black</option>
                        <option value="Green">Green</option>
                        <option value="Pink">Pink</option>
                        <option value="Yellow">Yellow</option>
                        <option value="Purple">Purple</option>
                        <option value="Orange">Orange</option>
                        <option value="Brown">Brown</option>
                        <option value="White">White</option>
                        <option value="Tiffancy Blue">Tiffancy Blue</option>
                    </select>
                </div>

                <div class="p-form-group" style="margin-bottom: 0;">
                    <label class="p-form-label">
                        <i class="fa-solid fa-link"></i> Strap Material
                    </label>
                    <select class="p-form-select" name="txtstrapmaterial">
                        <option value="" disabled selected>Choose Strap Material</option>
                        <option value="Stainless Steel">Stainless Steel</option>
                        <option value="Leather">Leather</option>
                        <option value="Ceramic">Ceramic</option>
                        <option value="Mesh">Mesh</option>
                        <option value="Resin">Resin</option>
                        <option value="Silicone">Silicone</option>
                    </select>
                </div>

                <div class="p-form-group" style="margin-bottom: 0;">
                    <label class="p-form-label">
                        <i class="fa-solid fa-droplet"></i> Strap Color
                    </label>
                    <select class="p-form-select" name="txtstrapcolor">
                        <option value="" disabled selected>Choose Strap Color</option>
                        <option value="Blue">Blue</option>
                        <option value="Rose Gold">Rose Gold</option>
                        <option value="Silver">Silver</option>
                        <option value="Gold">Gold</option>
                        <option value="Black">Black</option>
                        <option value="Green">Green</option>
                        <option value="Pink">Pink</option>
                        <option value="Navy Blue">Navy Blue</option>
                        <option value="Purple">Purple</option>
                        <option value="Sky Blue">Sky Blue</option>
                        <option value="Red">Red</option>
                        <option value="Maroon">Maroon</option>
                        <option value="Brown">Brown</option>
                        <option value="Dark Brown">Dark Brown</option>
                        <option value="White">White</option>
                        <option value="Olive Green">Olive Green</option>
                        <option value="Gray">Gray</option>
                        <option value="Charcoal Gray">Charcoal Gray</option>
                        <option value="Beige">Beige</option>
                        <option value="Cream">Cream</option>
                    </select>
                </div>
            </div>

            <!-- SECTION 5: DESCRIPTION -->
            <div class="form-section-divider">
                <i class="fa-solid fa-circle-info"></i> Product Description
            </div>

            <div class="p-form-group">
                <label class="p-form-label">
                    <i class="fa-solid fa-align-left"></i> Description
                </label>
                <textarea class="p-form-control" rows="3" placeholder="Enter timepiece craftsmanship, movement, and warranty details..." name="txtdesciption"></textarea>
            </div>

            <!-- ACTION BUTTONS -->
            <div class="form-actions-row">
                <button type="submit" class="btn-create-product" name="btnsubmit">
                    
                    <i class="fa-solid fa-plus"></i> Add Product
                </button>
                <a href="admin_show_product.php" class="btn-back-product">Back</a>
            </div>

        </form>

    </div>

</div>

<?php
include("admin_footer.php");
?>