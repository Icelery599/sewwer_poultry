<?php
// index.php - Homepage
require_once 'config/db.php';
$page_title = 'Home';
include 'includes/header.php';

// Fetch featured products
$stmt = $pdo->query("SELECT * FROM products WHERE status = 1 LIMIT 4");
$featured_products = $stmt->fetchAll();
?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1>Premium Noiler Birds & Fresh Poultry Products</h1>
                <p>Established 2025 | Ethical Farming | Quality Guaranteed</p>
                <a href="products.php" class="btn btn-primary btn-lg">Shop Now</a>
                <a href="https://wa.me/<?php echo WHATSAPP_NUMBER; ?>" class="btn btn-outline-light btn-lg ms-2">WhatsApp Inquiry</a>
            </div>
            <div class="col-lg-6">
                <img src="assets/images/hero-chicken.jpg" alt="Sewwer Poultry Farm" class="img-fluid rounded">
            </div>
        </div>
    </div>
</section>

<!-- About Preview -->
<section class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h2>About Sewwer Poultry</h2>
                <p>Sewwer Poultry was established in 2025 with the mission of providing healthy, quality Noiler birds, fresh eggs, poultry manure, and mature birds for consumption. We are committed to ethical poultry farming, proper bird care, and customer satisfaction while maintaining quality production standards.</p>
                <a href="about.php" class="btn btn-secondary">Read More</a>
            </div>
            <div class="col-lg-6">
                <div class="farm-stats">
                    <div class="stat-card">
                        <h3>1000+</h3>
                        <p>Birds Monthly</p>
                    </div>
                    <div class="stat-card">
                        <h3>100%</h3>
                        <p>Vaccinated</p>
                    </div>
                    <div class="stat-card">
                        <h3>500+</h3>
                        <p>Happy Customers</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="section-padding bg-light">
    <div class="container">
        <h2 class="text-center mb-5">Our Premium Products</h2>
        <div class="row">
            <?php foreach($featured_products as $product): ?>
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="product-card">
                    <img src="assets/images/products/<?php echo $product['image']; ?>" class="product-img" alt="<?php echo $product['name']; ?>">
                    <h4><?php echo $product['name']; ?></h4>
                    <p class="price">₦<?php echo number_format($product['price'], 2); ?></p>
                    <a href="products.php" class="btn btn-sm btn-primary">Order Now</a>
                    <a href="https://wa.me/<?php echo WHATSAPP_NUMBER; ?>?text=I'm%20interested%20in%20<?php echo urlencode($product['name']); ?>" class="btn btn-sm btn-success">WhatsApp</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section class="section-padding">
    <div class="container">
        <h2 class="text-center mb-5">Why Choose Sewwer Poultry</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="feature-box">
                    <i class="fas fa-shield-alt"></i>
                    <h4>Biosecurity Measures</h4>
                    <p>Strict disease prevention and sanitation protocols</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-box">
                    <i class="fas fa-syringe"></i>
                    <h4>Full Vaccination</h4>
                    <p>Complete vaccination program for healthy birds</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-box">
                    <i class="fas fa-leaf"></i>
                    <h4>Ethical Farming</h4>
                    <p>Humane treatment and sustainable practices</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Location Preview -->
<section class="section-padding bg-secondary text-white">
    <div class="container text-center">
        <h2>Visit Our Farm</h2>
        <p><?php echo LOCATION; ?></p>
        <a href="contact.php" class="btn btn-light">Get Directions</a>
    </div>
</section>

<?php include 'includes/footer.php'; ?>