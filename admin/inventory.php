<?php
require_once '../config/db.php';
if(!isLoggedIn()) redirect('admin/login.php');
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST['stock'] ?? [] as $productId => $stock) {
        $stmt = $pdo->prepare('UPDATE products SET stock_quantity = ? WHERE id = ?');
        $stmt->execute([(int)$stock, (int)$productId]);
    }
    $message = 'Inventory updated successfully.';
}
$products = $pdo->query('SELECT id, name, stock_quantity FROM products ORDER BY stock_quantity ASC, name ASC')->fetchAll();
$lowStock = $pdo->query('SELECT COUNT(*) FROM products WHERE stock_quantity <= 10')->fetchColumn();
include 'includes/admin_header.php';
?>
<div class="container-fluid"><div class="row"><?php include 'includes/admin_sidebar.php'; ?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="pt-3 pb-2 mb-3 border-bottom"><h1>Inventory Management</h1><p class="text-muted">Update stock counts and monitor low-stock products.</p></div>
    <?php if($message): ?><div class="alert alert-success"><?php echo $message; ?></div><?php endif; ?>
    <?php if($lowStock): ?><div class="alert alert-warning"><?php echo $lowStock; ?> product(s) are at or below the low-stock threshold.</div><?php endif; ?>
    <form method="POST"><table class="table table-striped align-middle"><thead><tr><th>Product</th><th>Current Stock</th><th>New Stock Quantity</th></tr></thead><tbody>
        <?php foreach($products as $product): ?><tr><td><?php echo $product['name']; ?></td><td><?php echo $product['stock_quantity']; ?></td><td><input type="number" class="form-control" name="stock[<?php echo $product['id']; ?>]" value="<?php echo $product['stock_quantity']; ?>" min="0"></td></tr><?php endforeach; ?>
    </tbody></table><button class="btn btn-primary">Save Inventory</button></form>
</main></div></div>
<?php include 'includes/admin_footer.php'; ?>
