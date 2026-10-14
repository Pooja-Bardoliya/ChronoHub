<style>
    /* Footer Specific Styles */
    .main-footer {
      background-color: #ffffff;
      border-top: 1px solid var(--border-color, #e5e7eb);
      padding: 4rem 0 2rem 0;
    }

    .footer-heading {
      font-family: var(--font-nav, 'Outfit', sans-serif);
      font-size: 0.85rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.1em;
      color: #111111;
      margin-bottom: 1.25rem;
    }

    .footer-links {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .footer-links li {
      margin-bottom: 0.6rem;
    }

    .footer-links a {
      color: var(--text-muted, #6c757d);
      font-size: 0.88rem;
      transition: all 0.25s ease;
      text-decoration: none;
    }

    .footer-links a:hover {
      color: #111111;
    }

    footer .social-icon {
      color: var(--badge-olive, #6b6b5a);
      font-size: 1.8rem;
      margin: 0 0.8rem;
      transition: all 0.3s;
      display: inline-block;
    }

    footer .social-icon:hover {
      color: var(--badge-darkgold, #a8895c);
      transform: translateY(-6px);
    }
</style>

<!-- ========== MAIN FOOTER (ChronoHub Design) ========== -->
  <footer class="main-footer">
    <div class="container">
      
      <div class="row g-4 pb-5">
        
        <!-- Brand Overview -->
        <div class="col-lg-4 col-md-6">
          <a href="home.php" class="brand-logo text-decoration-none d-inline-block mb-3">
            <span class="brand-text">CHR<img src="uploads/watch_o.png" class="watch-o-letter" alt="O">NO<span class="brand-gold">HUB</span></span>
          </a>
          <p class="text-muted small pe-lg-4">
            Curators of fine luxury timepieces, mechanical watchmaking, and precision chronographs. Engineered for timeless distinction and crafted to perfection.
          </p>
          <div class="d-flex gap-3 text-dark fs-5 mt-3">
            <a href="#" class="text-dark" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
            <a href="#" class="text-dark" aria-label="Facebook"><i class="fa-brands fa-facebook"></i></a>
            <a href="#" class="text-dark" aria-label="Twitter"><i class="fa-brands fa-x-twitter"></i></a>
            <a href="#" class="text-dark" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a>
          </div>
        </div>

        <!-- Quick Collections -->
        <div class="col-lg-2 col-md-6">
          <h6 class="footer-heading">Collections</h6>
          <ul class="footer-links">
            <li><a href="shop.php">Men's Watches</a></li>
            <li><a href="shop.php">Women's Collection</a></li>
            <li><a href="shop.php">Smart Watches</a></li>
            <li><a href="shop.php">Luxury Automatics</a></li>
            <li><a href="category.php">Shop by Category</a></li>
          </ul>
        </div>

        <!-- Client Services -->
        <div class="col-lg-3 col-md-6">
          <h6 class="footer-heading">Client Services</h6>
          <ul class="footer-links">
            <li><a href="my_orders.php">Order Tracking & History</a></li>
            <li><a href="my_orders.php">My Account</a></li>
            <li><a href="contact.php">Store & Boutique Locator</a></li>
            <li><a href="about.php">Heritage & Authenticity</a></li>
            <li><a href="contact.php">Warranty & Care Guide</a></li>
          </ul>
        </div>

        <!-- Boutique Info -->
        <div class="col-lg-3 col-md-6">
          <h6 class="footer-heading">ChronoHub Boutique</h6>
          <p class="text-muted small mb-2">
            <i class="fa-solid fa-location-dot me-2 text-dark"></i> 101, Luxury Avenue, Vesu<br>Surat, Gujarat 395007
          </p>
          <p class="text-muted small mb-2">
            <i class="fa-solid fa-phone me-2 text-dark"></i> +91 80000 55555
          </p>
          <p class="text-muted small mb-0">
            <i class="fa-solid fa-envelope me-2 text-dark"></i> concierge@chronohub.com
          </p>
        </div>

      </div>

      <!-- Sub-footer copyright & payment badges -->
      <div class="row pt-4 border-top align-items-center">
        <div class="col-md-6 text-center text-md-start mb-2 mb-md-0">
          <p class="text-muted small mb-0">&copy; <?php echo date('Y'); ?> ChronoHub Luxury Timepieces Inc. All rights reserved.</p>
        </div>
        <div class="col-md-6 text-center text-md-end">
          <div class="d-inline-flex gap-3 text-muted fs-4 align-items-center">
            <i class="fa-brands fa-cc-visa" title="Visa"></i>
            <i class="fa-brands fa-cc-mastercard" title="Mastercard"></i>
            <i class="fa-brands fa-cc-amex" title="American Express"></i>
            <i class="fa-brands fa-cc-apple-pay" title="Apple Pay"></i>
            <i class="fa-brands fa-cc-paypal" title="PayPal"></i>
          </div>
        </div>
      </div>

    </div>
  </footer>

  <!-- Bootstrap 5 JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Smooth scroll for anchor links -->
  <script>
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function(e) {
        const href = this.getAttribute('href');
        if (href === "#" || href === "") return;
        const target = document.querySelector(href);
        if (target) {
          e.preventDefault();
          target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
      });
    });
  </script>
</body>
</html>