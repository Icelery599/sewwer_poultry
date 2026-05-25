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
        <h2 class="category-title"><?php echo $category; ?></h2>
        <div class="row">
            <?php foreach($items as $product): ?>
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="product-card">
                    <img src="assets/images/products/<?php echo $product['image']; ?>" class="product-img" alt="<?php echo $product['name']; ?>">
                    <h4><?php echo $product['name']; ?></h4>
                    <p class="product-desc"><?php echo substr($product['description'], 0, 80); ?>...</p>
                    <p class="price">₦<?php echo number_format($product['price'], 2); ?></p>
                    <p class="stock">In Stock: <?php echo $product['stock_quantity']; ?></p>
                    <form action="add_to_cart.php" method="POST">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <div class="qty-input">
                            <input type="number" name="quantity" value="1" min="1" max="<?php echo $product['stock_quantity']; ?>">
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm w-100 mb-2">Add to Cart</button>
                    </form>
                    <a href="https://wa.me/<?php echo WHATSAPP_NUMBER; ?>?text=I'm%20interested%20in%20<?php echo urlencode($product['name']); ?>%20(₦<?php echo $product['price']; ?>)" class="btn btn-success btn-sm w-100">Order via WhatsApp</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<?php include 'includes/footer.php'; ?>