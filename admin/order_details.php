<?php
require_once '../config/db.php';
if(!isLoggedIn()) redirect('admin/login.php');
if(!isset($_GET['id'])) redirect('admin/orders.php');
$id = (int) $_GET['id'];
$orderStmt = $pdo->prepare('SELECT * FROM orders WHERE id=?');
$orderStmt->execute([$id]);
$order = $orderStmt->fetch();
if (!$order) redirect('admin/orders.php');
$itemsStmt = $pdo->prepare('SELECT * FROM order_items WHERE order_id=?');
$itemsStmt->execute([$id]);
$items = $itemsStmt->fetchAll();
include 'includes/admin_header.php';
?>
<div class="container-fluid"><div class="row"><?php include 'includes/admin_sidebar.php'; ?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <h2>Order Details: <?php echo $order['order_number']; ?></h2>
    <div class="card card-body mb-3">
        <p><strong>Customer:</strong> <?php echo $order['customer_name']; ?><br><strong>Email:</strong> <?php echo $order['customer_email']; ?><br><strong>Phone:</strong> <?php echo $order['customer_phone']; ?><br><strong>Address:</strong> <?php echo $order['customer_address']; ?></p>
        <p><strong>Order Status:</strong> <span class="badge bg-<?php echo statusBadgeClass($order['order_status']); ?>"><?php echo ucwords(str_replace('_', ' ', $order['order_status'])); ?></span> <strong>Payment:</strong> <span class="badge bg-<?php echo statusBadgeClass($order['payment_status']); ?>"><?php echo ucfirst($order['payment_status']); ?></span> via <?php echo $order['payment_method']; ?></p>
        <?php if($order['order_notes']): ?><p><strong>Notes:</strong> <?php echo $order['order_notes']; ?></p><?php endif; ?>
    </div>
    <table class="table"><tr><th>Product</th><th>Qty</th><th>Price</th><th>Subtotal</th></tr><?php foreach($items as $i): ?><tr><td><?php echo $i['product_name']; ?></td><td><?php echo $i['quantity']; ?></td><td><?php echo money($i['price']); ?></td><td><?php echo money($i['price']*$i['quantity']); ?></td></tr><?php endforeach; ?></table>
    <p><strong>Total: <?php echo money($order['order_total']); ?></strong></p><a href="orders.php" class="btn btn-secondary">Back</a>
</main></div></div>
<?php include 'includes/admin_footer.php'; ?>
