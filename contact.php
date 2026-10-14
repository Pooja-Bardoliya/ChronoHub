<?php
include("header.php");

$msg_success = "";
if (isset($_POST['btninquiry'])) {
    $msg_success = "Your inquiry has been submitted. Our watch concierge will reply within 24 hours.";
}
?>

<style>
    /* ---------- CONTACT PAGE MODULAR STYLES ---------- */
    .contact-header-banner {
        background: linear-gradient(180deg, #f8f9fa 0%, #ffffff 100%);
        padding: 3.5rem 0 2.5rem 0;
        border-bottom: 1px solid var(--border-color, #e5e7eb);
    }

    i, .text-gold {
        color: #111111 !important;
    }
    
    .tracking-wider {
        letter-spacing: 0.08em;
    }
    
    .btn-luxury-dark {
        background-color: #111111;
        color: #ffffff;
        border: 1px solid #111111;
        transition: all 0.25s ease;
    }
    .btn-luxury-dark:hover {
        background-color: #000000;
        color: #ffffff;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }

    .border-gold-subtle {
        border-color: rgba(197, 160, 89, 0.35) !important;
    }

    .faq-accordion .accordion-button {
        font-family: 'Outfit', 'Plus Jakarta Sans', sans-serif !important;
        font-size: 0.95rem;
    }

    .faq-accordion .accordion-button:not(.collapsed) {
        background-color: #f8f9fa;
        color: #111111;
        box-shadow: none;
    }

    .faq-accordion .accordion-button:focus {
        box-shadow: none;
        border-color: #111111;
    }
</style>

<!-- Hero / Header Banner -->
<div class="contact-header-banner mb-5">
    <div class="container text-center">
        <span class="text-uppercase text-dark fw-bold small tracking-wider font-nav">ChronoHub Boutiques & Support</span>
        <h1 class="font-heading display-6 fw-bold text-dark mt-1 mb-2">Contact Concierge & Flagship Boutique</h1>
        <p class="text-muted font-nav mx-auto mb-0" style="max-width: 680px; font-size: 1.02rem; line-height: 1.6;">
            Have questions about a timepiece movement, strap sizing, custom order, or boutique appointment? Our horology specialists are at your service.
        </p>
    </div>
</div>

<div class="container pb-5">
    
    <?php if (!empty($msg_success)): ?>
        <div class="alert alert-success alert-dismissible fade show max-w-800 mx-auto mb-4" role="alert" style="max-width: 860px;">
            <i class="fa-solid fa-circle-check me-2"></i> <?php echo htmlspecialchars($msg_success); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (!empty($msg_error)): ?>
        <div class="alert alert-danger alert-dismissible fade show max-w-800 mx-auto mb-4" role="alert" style="max-width: 860px;">
            <i class="fa-solid fa-circle-exclamation me-2"></i> <?php echo htmlspecialchars($msg_error); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row g-4 g-lg-5">
        
        <!-- 1. Contact Form Section (Centered with decreased width) -->
        <div class="col-12 col-lg-9 col-xl-8 mx-auto mb-4">
            <div class="p-4 p-md-5 bg-white border rounded-4 shadow-sm">
                <div class="d-flex align-items-center mb-4 pb-2">
                    <div class="fs-4 text-dark me-3"><i class="fa-solid fa-paper-plane"></i></div>
                    <div>
                        <h4 class="font-heading fw-bold mb-0 text-dark">Send An Inquiry</h4>
                        <small class="text-muted font-nav">We typically reply within 24 hours.</small>
                    </div>
                </div>

                <form action="contact.php" method="POST">
                    <div class="row g-3">
                        <div class="col-md-6 mb-3">
                            <label class="form-label font-nav small fw-bold text-uppercase">Your Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control form-control-lg fs-6" placeholder="e.g. Aarav Mehta" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label font-nav small fw-bold text-uppercase">Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control form-control-lg fs-6" placeholder="name@example.com" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-nav small fw-bold text-uppercase">Subject <span class="text-danger">*</span></label>
                        <select name="subject" class="form-select form-select-lg fs-6" required>
                            <option value="General Inquiry">General Product Inquiry</option>
                            <option value="Watch Servicing">Watch Servicing & Maintenance</option>
                            <option value="Order Status">Order Status & Delivery</option>
                            <option value="Boutique Appointment">Schedule Boutique Appointment</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label font-nav small fw-bold text-uppercase">Message <span class="text-danger">*</span></label>
                        <textarea name="message" class="form-control form-control-lg fs-6" rows="4" placeholder="How can our concierge assist you today?" required></textarea>
                    </div>

                    <button type="submit" name="btninquiry" class="btn btn-luxury-dark w-100 py-3 font-nav text-uppercase tracking-wider fw-bold">
                        <i class="fa-solid fa-paper-plane me-2"></i> Submit Inquiry
                    </button>
                </form>
            </div>
        </div>

        <!-- 2. Store Locator & Hours Section -->
        <div class="col-12 col-lg-12 mb-5">
            <div class="row g-4 align-items-stretch">
                <!-- Left Side: Showroom Image -->
                <div class="col-lg-6">
                    <div class="position-relative h-100 rounded-4 overflow-hidden shadow-sm" style="min-height: 380px;">
                        <img src="uploads/contact1.jpg" alt="ChronoHub Flagship Boutique" class="w-100 h-100 object-fit-cover">
                    </div>
                </div>

                <!-- Right Side: Heading + Location & Hours Cards -->
                <div class="col-lg-6 d-flex flex-column justify-content-between">
                    <div>
                        <!-- Heading -->
                        <div class="d-flex align-items-center mb-4">
                            <div class="fs-4 text-dark me-3"><i class="fa-solid fa-building-columns"></i></div>
                            <div>
                                <h4 class="font-heading fw-bold mb-0 text-dark">Flagship Boutique & Visiting Hours</h4>
                                <small class="text-muted font-nav">Experience our horology showroom in person</small>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <!-- Location Card -->
                            <div class="col-md-6">
                                <div class="p-4 bg-white border rounded-3 h-100 shadow-sm">
                                    <h6 class="font-nav text-uppercase small fw-bold text-dark mb-2">
                                        <i class="fa-solid fa-location-dot text-dark me-2"></i> Boutique Address
                                    </h6>
                                    <p class="text-dark small mb-1 fw-bold">ChronoHub Store</p>
                                    <p class="text-muted small mb-2">101, Luxury Avenue, Vesu, Surat, Gujarat 395007</p>
                                    <p class="text-muted small mb-0"><i class="fa-solid fa-phone me-1 text-dark"></i> Tel: +91 80000 55555</p>
                                </div>
                            </div>

                            <!-- Hours Card -->
                            <div class="col-md-6">
                                <div class="p-4 bg-white border rounded-3 h-100 shadow-sm">
                                    <h6 class="font-nav text-uppercase small fw-bold text-dark mb-2">
                                        <i class="fa-solid fa-clock text-dark me-2"></i> Visiting Hours
                                    </h6>
                                    <ul class="list-unstyled text-secondary small mb-0">
                                        <li class="d-flex justify-content-between py-1 border-bottom"><span>Mon - Fri:</span> <strong class="text-dark">10 AM - 7 PM</strong></li>
                                        <li class="d-flex justify-content-between py-1 border-bottom"><span>Saturday:</span> <strong class="text-dark">10 AM - 6 PM</strong></li>
                                        <li class="d-flex justify-content-between py-1"><span>Sunday:</span> <strong class="text-dark fw-bold">Private Appt</strong></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 24/7 Concierge Banner -->
                    <div class="p-3 p-md-4 bg-white border border-gold-subtle rounded-3 shadow-sm">
                        <div class="d-flex align-items-center">
                            <div class="fs-3 text-dark me-3"><i class="fa-solid fa-headset"></i></div>
                            <div>
                                <h6 class="font-nav text-uppercase small fw-bold text-dark mb-1">24/7 Horology Concierge Desk</h6>
                                <p class="small text-muted mb-0">Our horology specialists are available for live phone consultations & orders 24 hours a day, 7 days a week.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- 3. FAQ Section -->
    <div id="faq" class="mt-5 pt-4">
        <div class="text-center mb-4">
            <span class="text-uppercase text-dark fw-bold small tracking-wider font-nav">Help Center</span>
            <h4 class="font-heading fw-bold text-dark mt-1">Frequently Asked Questions</h4>
        </div>

        <div class="accordion faq-accordion max-w-800 mx-auto" id="faqAccordion" style="max-width: 860px;">
            
            <div class="accordion-item shadow-sm border mb-3 rounded-3 overflow-hidden">
                <h2 class="accordion-header" id="faq1">
                    <button class="accordion-button collapsed font-nav fw-medium py-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1">
                        <i class="fa-solid fa-circle-check text-dark me-2"></i> Are all watches guaranteed 100% authentic?
                    </button>
                </h2>
                <div id="collapse1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body text-secondary small leading-relaxed">
                        Yes, absolutely. ChronoHub sources all timepieces directly from authorized brand distributors and certified manufacture partners. Each watch ships with its original serial numbers, box, and stamped manufacturer warranty card.
                    </div>
                </div>
            </div>

            <div class="accordion-item shadow-sm border mb-3 rounded-3 overflow-hidden">
                <h2 class="accordion-header" id="faq2">
                    <button class="accordion-button collapsed font-nav fw-medium py-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2">
                        <i class="fa-solid fa-truck-fast text-dark me-2"></i> What is your shipping policy?
                    </button>
                </h2>
                <div id="collapse2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body text-secondary small leading-relaxed">
                        We offer complimentary insured express shipping on all orders over ₹5,000. Packages are shipped via insured express courier with required signature verification upon delivery.
                    </div>
                </div>
            </div>

            <div class="accordion-item shadow-sm border mb-3 rounded-3 overflow-hidden">
                <h2 class="accordion-header" id="faq3">
                    <button class="accordion-button collapsed font-nav fw-medium py-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3">
                        <i class="fa-solid fa-shield-halved text-dark me-2"></i> How does the 2-Year International Warranty work?
                    </button>
                </h2>
                <div id="collapse3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body text-secondary small leading-relaxed">
                        Every timepiece purchased includes a comprehensive 2-year movement warranty. Should your watch experience any mechanical defects, our master watchmakers will service or replace the movement free of charge.
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php
include("footer.php");
?>