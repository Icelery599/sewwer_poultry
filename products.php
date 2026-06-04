<?php
// products.php - Products Listing with E-commerce
require_once 'config/db.php';
$page_title = 'Our Products';
include 'includes/header.php';

// Get all products
$stmt = $pdo->query("SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id = c.id WHERE p.status = 1 ORDER BY p.category_id");
$products = $stmt->fetchAll();

// Group by category
$grouped = [];
foreach($products as $product) {
    $grouped[$product['category_name']][] = $product;
}
?>

<section class="section-padding">
    <div class="container">
        <h1 class="text-center mb-4">Our Products</h1>
        <p class="text-center mb-5">Browse our premium poultry products - Order directly or inquire via WhatsApp</p>
        
        <?php foreach($grouped as $category => $items): ?>
        <h2 class="category-title mt-5 mb-4"><?php echo $category; ?></h2>
        <div class="row g-4">
            <?php foreach($items as $product): ?>
            <div class="col-md-6 col-lg-3">
                <div class="card product-card h-100 shadow-sm">
                    <img src="assets/images/products/<?php echo $product['image']; ?>" class="card-img-top product-img" alt="<?php echo $product['name']; ?>" style="height: 200px; object-fit: cover;">
                    <div class="card-body d-flex flex-column">
                        <h4 class="card-title"><?php echo $product['name']; ?></h4>
                        <p class="card-text text-muted"><?php echo substr($product['description'], 0, 80); ?>...</p>
                        <p class="price fw-bold text-primary mt-2">₦<?php echo number_format($product['price'], 2); ?></p>
                        <p class="stock text-secondary mb-3">In Stock: <?php echo $product['stock_quantity']; ?></p>
                        <form action="add_to_cart.php" method="POST" class="mt-auto">
                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                            <div class="qty-input mb-3">
                                <label for="qty-<?php echo $product['id']; ?>" class="form-label">Quantity:</label>
                                <input type="number" id="qty-<?php echo $product['id']; ?>" name="quantity" value="1" min="1" max="<?php echo $product['stock_quantity']; ?>" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-primary w-100 mb-2">Add to Cart</button>
                        </form>
                        <a href="https://wa.me/<?php echo WHATSAPP_NUMBER; ?>?text=I'm%20interested%20in%20<?php echo urlencode($product['name']); ?>%20(₦<?php echo $product['price']; ?>)" class="btn btn-outline-success w-100"><i class="fab fa-whatsapp"></i> Chat on WhatsApp</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
