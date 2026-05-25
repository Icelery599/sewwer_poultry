<?php
// includes/footer.php - Global footer template
?>
</main>

<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h4><?php echo SITE_NAME; ?></h4>
                <p>Quality Noiler birds, fresh eggs, and organic manure. Established 2025.</p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-tiktok"></i></a>
                    <a href="#"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <h4>Quick Links</h4>
                <ul class="footer-links">
                    <li><a href="<?php echo SITE_URL; ?>products.php">Shop</a></li>
                    <li><a href="<?php echo SITE_URL; ?>about.php">About Us</a></li>
                    <li><a href="<?php echo SITE_URL; ?>contact.php">Bulk Orders</a></li>
                    <li><a href="<?php echo SITE_URL; ?>trust.php">Our Standards</a></li>
                </ul>
            </div>
            <div class="col-md-4 mb-4">
                <h4>Contact Info</h4>
                <p><i class="fas fa-map-marker-alt"></i> <?php echo LOCATION; ?></p>
                <p><i class="fas fa-phone"></i> <?php echo PHONE_NUMBER; ?></p>
                <p><i class="fas fa-envelope"></i> <?php echo EMAIL_ADDRESS; ?></p>
            </div>
        </div>
        <div class="copyright">
            <p>&copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. All rights reserved.</p>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo SITE_URL; ?>assets/js/main.js"></script>
</body>
</html>