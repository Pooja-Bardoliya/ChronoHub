<?php
include("header.php");
?>

<main>
    <div id="carouselExampleCaptions" class="carousel slide">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQicqK91ADVq0-bPG3G2WkuGW65mn_fjrgeE31NSwz3zg&s=10" class="d-block w-100 slider" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>First slide label</h5>
                    <p>Some representative placeholder content for the first slide.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="https://t4.ftcdn.net/jpg/04/62/25/91/360_F_462259136_ieLHu3BL11q66HMrKFTtzleU8QPPmEOT.jpg" class="d-block w-100 slider" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Second slide label</h5>
                    <p>Some representative placeholder content for the second slide.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="https://static.vecteezy.com/system/resources/thumbnails/006/532/742/small/flash-sale-banner-illustration-template-design-of-special-offer-discount-for-media-promotion-and-social-media-post-free-vector.jpg" class="d-block w-100 slider" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Third slide label</h5>
                    <p>Some representative placeholder content for the third slide.</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <div class="container text-center">
        <h2>Explore Our Collections</h2>
        <div class="row justify-content-center">
            <div class="col-3">

                <div class="card">
                    <img class="card-img-top product-img" src="https://png.pngtree.com/png-vector/20210602/ourmid/pngtree-3d-beauty-cosmetics-product-design-png-image_3350323.jpg" alt="Title" />
                    <div class="card-body">
                        <h4 class="card-title">Perfume</h4>
                        <p class="card-text">₹ 150</p>
                        <button class="btn btn-danger">Add to Cart <i class="fa-solid fa-cart-shopping"></i></button>
                    </div>
                </div>
                
            </div>

            <div class="col-3">
                <div class="card">
                    <img class="card-img-top product-img" src="https://i.pinimg.com/474x/66/23/9a/66239a1485de08d7c9d73f52e4ca2408.jpg?nii=t" alt="Title" />
                    <div class="card-body">
                        <h4 class="card-title">Cream</h4>
                        <p class="card-text">₹ 200</p>
                        <button class="btn btn-danger">Add to Cart <i class="fa-solid fa-cart-shopping"></i></button>
                    </div>
                </div>
                
            </div>

            <div class="col-3">
                <div class="card">
                    <img class="card-img-top product-img" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ0oVh21glZV7R6-77NZyu4lsPFPwtYwQL4yzEdZ3ZvPbs8ZMcWErnGWiKt&s=10" alt="Title" />
                    <div class="card-body">
                        <h4 class="card-title">Perfume</h4>
                        <p class="card-text">₹ 1000</p>
                        <button class="btn btn-danger">Add to Cart <i class="fa-solid fa-cart-shopping"></i></button>
                    </div>
                </div>
                
            </div>

            <div class="col-3"><div class="card">
                <img class="card-img-top product-img" src="https://mir-s3-cdn-cf.behance.net/project_modules/fs/b74e3a125239039.6114e20546a2f.jpg" alt="Title" />
                <div class="card-body">
                    <h4 class="card-title">Body Lotion</h4>
                    <p class="card-text">₹ 500</p>
                    <button class="btn btn-danger">Add to Cart <i class="fa-solid fa-cart-shopping"></i></button>
                </div>
            </div>
            </div>

        </div>
    </div>
</main>

<?php
include("footer.php");
?>