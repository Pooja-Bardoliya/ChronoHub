<?php
include("header.php");
?>

<style>
    /* ---------- ABOUT PAGE MODULAR STYLES ---------- */
    .about-header-banner {
        background: linear-gradient(180deg, #f8f9fa 0%, #ffffff 100%);
        padding: 3.5rem 0 2.5rem 0;
        border-bottom: 1px solid var(--border-color, #e5e7eb);
    }
    
    .font-heading {
        font-family: 'Playfair Display', serif !important;
    }

    .tracking-wider {
        letter-spacing: 0.08em;
    }
    
    .about-stat-card {
        background-color: #f8f9fa;
        border: 1px solid var(--border-color, #e5e7eb);
        border-radius: 8px;
        padding: 1rem;
    }
    
    .about-pillar-card {
        background: #ffffff;
        border: 1px solid var(--border-color, #e5e7eb);
        border-radius: 12px;
        padding: 2rem 1.5rem;
    }
    
    .quotes-carousel-section {
        position: relative;
    }
    
    .about-quote-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(15, 17, 21, 0.45) 0%, rgba(15, 17, 21, 0.55) 100%), url('uploads/about2.jpg') center/cover no-repeat;
        z-index: 1;
    }
</style>

<!-- About Us Page Header Banner -->
<div class="about-header-banner mb-5">
    <div class="container text-center">
        <span class="text-uppercase text-gold fw-bold small tracking-wider">Established 2026</span>
        <h1 class="font-heading display-4 fw-bold mb-3 mt-1 text-dark">The Art of Fine Watchmaking</h1>
        <p class="lead text-secondary mx-auto mb-0" style="max-width: 700px; font-size: 1.1rem; line-height: 1.6;">
            ChronoHub was founded on a singular passion: bringing world-class mechanical precision and haute horology directly to watch collectors and enthusiasts.
        </p>
    </div>
</div>

<div class="container pb-5">
    
    <!-- Philosophy & Heritage Section -->
    <div class="row align-items-center g-5 mb-5 pb-lg-4">
        <div class="col-lg-6">
            <img src="uploads/about1.jpg" alt="Horology Craft" class="img-fluid rounded-4 shadow-md w-100" style="object-fit: cover; max-height: 480px;">
        </div>
        <div class="col-lg-6">
            <span class="text-uppercase text-muted small fw-bold tracking-wider">Our Philosophy</span>
            <h2 class="font-heading fs-2 mb-3 mt-1 fw-bold text-dark">Precision Engineering Meets Timeless Design</h2>
            <p class="text-secondary leading-relaxed mb-4" style="line-height: 1.7; font-size: 0.95rem;">
                Every timepiece in our catalog is rigorously authenticated and hand-inspected by certified watchmakers. From self-winding automatic rotors and balance wheels to sapphire crystal casings and hand-stitched Italian leather straps, we ensure that every second counts.
            </p>
            <div class="row g-3">
                <div class="col-6">
                    <div class="about-stat-card text-center">
                        <div class="fs-2 fw-bold text-dark font-nav">10,000+</div>
                        <small class="text-muted text-uppercase font-nav fw-semibold" style="font-size: 0.75rem; letter-spacing: 0.05em;">Timepieces Delivered</small>
                    </div>
                </div>
                <div class="col-6">
                    <div class="about-stat-card text-center">
                        <div class="fs-2 fw-bold text-dark font-nav">100%</div>
                        <small class="text-muted text-uppercase font-nav fw-semibold" style="font-size: 0.75rem; letter-spacing: 0.05em;">Authentic Guarantee</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Craftsmanship Pillars Section -->
    <div class="text-center mt-5 pt-4 mb-5">
        <span class="text-uppercase text-gold fw-bold small tracking-wider">Why Choose ChronoHub</span>
        <h2 class="font-heading fs-2 fw-bold text-dark mt-1">Our Pillars of Excellence</h2>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="about-pillar-card text-center h-100">
                <div class="fs-1 text-gold mb-3"><i class="fa-solid fa-gem"></i></div>
                <h5 class="font-heading fw-bold text-dark mb-2">Uncompromising Quality</h5>
                <p class="text-muted small mb-0" style="line-height: 1.6;">Direct partnerships with Swiss and Japanese manufacture houses ensuring genuine provenance.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="about-pillar-card text-center h-100">
                <div class="fs-1 text-gold mb-3"><i class="fa-solid fa-screwdriver-wrench"></i></div>
                <h5 class="font-heading fw-bold text-dark mb-2">Master Servicing</h5>
                <p class="text-muted small mb-0" style="line-height: 1.6;">In-house watchmakers dedicated to movement calibration, pressure testing, and care.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="about-pillar-card text-center h-100">
                <div class="fs-1 text-gold mb-3"><i class="fa-solid fa-user-shield"></i></div>
                <h5 class="font-heading fw-bold text-dark mb-2">VIP Concierge</h5>
                <p class="text-muted small mb-0" style="line-height: 1.6;">Personalized consultation for new collectors, vintage watch enthusiasts, and gift givers.</p>
            </div>
        </div>
    </div>

    <!-- Quotes / Testimonials Carousel Section -->
    <div class="quotes-carousel-section mt-5 pt-4 mb-2">
        <div id="aboutQuotesCarousel" class="carousel slide position-relative rounded-4 overflow-hidden shadow-lg" data-bs-ride="carousel" data-bs-interval="3500">
            <!-- Background Overlay Image -->
            <div class="about-quote-overlay"></div>
            
            <div class="carousel-inner text-center py-5 px-4 px-md-5 position-relative text-white" style="z-index: 2; min-height: 270px;">
                
                <!-- Quote 1 -->
                <div class="carousel-item active">
                    <div class="fs-1 text-gold mb-3" style="text-shadow: 0 2px 8px rgba(0,0,0,0.6);"><i class="fa-solid fa-quote-left"></i></div>
                    <h4 class="font-heading fw-bold text-uppercase text-white mx-auto mb-3" style="max-width: 820px; letter-spacing: 0.03em; line-height: 1.6; font-size: 1.25rem; text-shadow: 0 2px 10px rgba(0, 0, 0, 0.85);">
                        "WE EXCEL IN BLENDING TIMELESS ELEGANCE WITH STYLE, CRAFTING EXQUISITE DESIGNS"
                    </h4>
                    <p class="font-nav text-gold small fw-semibold text-uppercase tracking-wider mb-2" style="text-shadow: 0 2px 6px rgba(0,0,0,0.8);">Aarav Mehta - Consumer</p>
                </div>

                <!-- Quote 2 -->
                <div class="carousel-item">
                    <div class="fs-1 text-gold mb-3" style="text-shadow: 0 2px 8px rgba(0,0,0,0.6);"><i class="fa-solid fa-quote-left"></i></div>
                    <h4 class="font-heading fw-bold text-uppercase text-white mx-auto mb-3" style="max-width: 820px; letter-spacing: 0.03em; line-height: 1.6; font-size: 1.25rem; text-shadow: 0 2px 10px rgba(0, 0, 0, 0.85);">
                        "OUR COMMITMENT TO QUALITY ENSURES EACH PIECE IS FOR ALL OCCASIONS"
                    </h4>
                    <p class="font-nav text-gold small fw-semibold text-uppercase tracking-wider mb-2" style="text-shadow: 0 2px 6px rgba(0,0,0,0.8);">Priya Sharma - Consumer</p>
                </div>

                <!-- Quote 3 -->
                <div class="carousel-item">
                    <div class="fs-1 text-gold mb-3" style="text-shadow: 0 2px 8px rgba(0,0,0,0.6);"><i class="fa-solid fa-quote-left"></i></div>
                    <h4 class="font-heading fw-bold text-uppercase text-white mx-auto mb-3" style="max-width: 820px; letter-spacing: 0.03em; line-height: 1.6; font-size: 1.25rem; text-shadow: 0 2px 10px rgba(0, 0, 0, 0.85);">
                        "INNOVATION AND CRAFTSMANSHIP DEFINE OUR APPROACH, BRINGING DREAMS TO LIFE"
                    </h4>
                    <p class="font-nav text-gold small fw-semibold text-uppercase tracking-wider mb-2" style="text-shadow: 0 2px 6px rgba(0,0,0,0.8);">Vikram Malhotra - Consumer</p>
                </div>

                <!-- Quote 4 -->
                <div class="carousel-item">
                    <div class="fs-1 text-gold mb-3" style="text-shadow: 0 2px 8px rgba(0,0,0,0.6);"><i class="fa-solid fa-quote-left"></i></div>
                    <h4 class="font-heading fw-bold text-uppercase text-white mx-auto mb-3" style="max-width: 820px; letter-spacing: 0.03em; line-height: 1.6; font-size: 1.25rem; text-shadow: 0 2px 10px rgba(0, 0, 0, 0.85);">
                        "WE TAKE PRIDE IN OUR UNIQUE DESIGNS, WHICH MERGE TRADITION AND MODERNITY"
                    </h4>
                    <p class="font-nav text-gold small fw-semibold text-uppercase tracking-wider mb-2" style="text-shadow: 0 2px 6px rgba(0,0,0,0.8);">Ananya Patel - Consumer</p>
                </div>

            </div>

            <!-- Carousel Indicators -->
            <div class="carousel-indicators position-relative mb-4" style="z-index: 2;">
                <button type="button" data-bs-target="#aboutQuotesCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#aboutQuotesCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#aboutQuotesCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                <button type="button" data-bs-target="#aboutQuotesCarousel" data-bs-slide-to="3" aria-label="Slide 4"></button>
            </div>
        </div>
    </div>

    <!-- The Watch Advantages Section -->
    <div class="text-center mt-5 pt-4 mb-5">
        <span class="text-uppercase text-gold fw-bold small tracking-wider">ChronoHub Distinction</span>
        <h2 class="font-heading fs-2 fw-bold text-dark mt-1">The Watch Advantages</h2>
    </div>

    <div class="row g-4">
        <!-- Advantage 1 -->
        <div class="col-md-4">
            <div class="about-pillar-card text-center h-100">
                <div class="fs-1 text-gold mb-3"><i class="fa-solid fa-gem"></i></div>
                <h5 class="font-heading fw-bold text-dark mb-2">Sapphire Crystal Glass</h5>
                <p class="text-muted small mb-0" style="line-height: 1.6;">Virtually unscratchable synthetic sapphire crystal featuring double-sided anti-reflective coating for crystal-clear legibility.</p>
            </div>
        </div>

        <!-- Advantage 2 -->
        <div class="col-md-4">
            <div class="about-pillar-card text-center h-100">
                <div class="fs-1 text-gold mb-3"><i class="fa-solid fa-clock-rotate-left"></i></div>
                <h5 class="font-heading fw-bold text-dark mb-2">Automatic Kinetic Rotors</h5>
                <p class="text-muted small mb-0" style="line-height: 1.6;">Self-winding mechanical movements powered naturally by your daily wrist motion, completely eliminating battery replacements.</p>
            </div>
        </div>

        <!-- Advantage 3 -->
        <div class="col-md-4">
            <div class="about-pillar-card text-center h-100">
                <div class="fs-1 text-gold mb-3"><i class="fa-solid fa-shield-halved"></i></div>
                <h5 class="font-heading fw-bold text-dark mb-2"><span class="font-num fw-bold">316L</span> Surgical Stainless Steel</h5>
                <p class="text-muted small mb-0" style="line-height: 1.6;">Ultra-durable, corrosion-resistant surgical grade stainless steel casings hand-polished with alternating satin and mirror finishes.</p>
            </div>
        </div>

        <!-- Advantage 4 -->
        <div class="col-md-4">
            <div class="about-pillar-card text-center h-100">
                <div class="fs-1 text-gold mb-3"><i class="fa-solid fa-water"></i></div>
                <h5 class="font-heading fw-bold text-dark mb-2"><span class="font-num fw-bold">100M</span> Water Resistance</h5>
                <p class="text-muted small mb-0" style="line-height: 1.6;">Precision-machined screw-down crowns and double gasket seals designed for swimming, water sports, and daily active wear.</p>
            </div>
        </div>

        <!-- Advantage 5 -->
        <div class="col-md-4">
            <div class="about-pillar-card text-center h-100">
                <div class="fs-1 text-gold mb-3"><i class="fa-solid fa-compass-drafting"></i></div>
                <h5 class="font-heading fw-bold text-dark mb-2">Swiss & Japanese Precision</h5>
                <p class="text-muted small mb-0" style="line-height: 1.6;">Regulated by master horologists with high-frequency balance wheel oscillations ensuring certified timekeeping precision.</p>
            </div>
        </div>

        <!-- Advantage 6 -->
        <div class="col-md-4">
            <div class="about-pillar-card text-center h-100">
                <div class="fs-1 text-gold mb-3"><i class="fa-solid fa-award"></i></div>
                <h5 class="font-heading fw-bold text-dark mb-2">Hand-Crafted Leather & Straps</h5>
                <p class="text-muted small mb-0" style="line-height: 1.6;">Top-grain Italian leather straps and solid steel link bracelets with micro-adjustable luxury deployment butterfly clasps.</p>
            </div>
        </div>
    </div>

</div>

<?php
include("footer.php");
?>