<?php
require_once '../config/db.php';
if(!isLoggedIn()) redirect('admin/login.php');
$products = $pdo->query('SELECT p.*, c.name AS category_name FROM products p JOIN categories c ON p.category_id = c.id ORDER BY p.name')->fetchAll();
include 'includes/admin_header.php';
?>
<div class="container-fluid"><div class="row"><?php include 'includes/admin_sidebar.php'; ?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom"><h1>Products</h1><a href="product_add.php" class="btn btn-primary">Add Product</a></div>
    <table class="table table-striped align-middle"><thead><tr><th>Name</th><th>Category</th><th>Price</th><th>Stock</th><th>Status</th></tr></thead><tbody>
        <?php foreach($products as $product): ?><tr><td><?php echo $product['name']; ?></td><td><?php echo $product['category_name']; ?></td><td><?php echo money($product['price']); ?></td><td><?php echo $product['stock_quantity']; ?></td><td><?php echo $product['status'] ? 'Active' : 'Hidden'; ?></td></tr><?php endforeach; ?>
    </tbody></table>
</main></div></div>
<?php include 'includes/admin_footer.php'; ?>
