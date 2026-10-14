<?php
include('header.php');
include("connect.php");
$query = "SELECT * FROM `tbl_category`";
$cats = array();
$res = mysqli_query($con, $query);
while ($row = mysqli_fetch_assoc($res)) {
    $cats[] = $row;
}

?>
<section id="categories" class="section-badge alt-bg">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Shop by Category</h2>
            <p class="section-sub">Find your perfect timepiece by style</p>
        </div>
        <div class="row g-4 justify-content-center">

            <?php
            foreach ($cats as $c) { ?>

                <div class="col-6 col-md-4 col-lg-2">
                    <div class="category-card">
                        <img src="<?= $c['cpic'] ?>" alt="" height="100" width="100">
                        <h5><?= $c['cname'] ?></h5>
                        <a href="shop.php?id=<?= $c['cid'] ?>">Explore</a>
                    </div>
                </div>


            <?php

            } ?>


        </div>
    </div>
</section>
<?php
include('footer.php');
?>