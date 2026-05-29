<?php
require_once 'config/db.php';
$page_title = 'Track Order';
$page_description = 'Track your Sewwer Poultry order status, payment status and delivery updates online.';
$order = null;
$items = [];
$error = '';
$orderNumber = sanitize($_GET['order_number'] ?? $_POST['order_number'] ?? '');
$email = strtolower(sanitize($_GET['email'] ?? $_POST['email'] ?? ''));

if ($orderNumber && $email) {
    $stmt = $pdo->prepare('SELECT * FROM orders WHERE order_number = ? AND customer_email = ? LIMIT 1');
    $stmt->execute([$orderNumber, $email]);
    $order = $stmt->fetch();
    if ($order) {
        $itemStmt = $pdo->prepare('SELECT * FROM order_items WHERE order_id = ?');
        $itemStmt->execute([$order['id']]);
        $items = $itemStmt->fetchAll();
    } else {
        $error = 'No matching order found. Please check the order number and email address.';
    }
}
include 'includes/header.php';
?>
<section class="section-padding">
    <div class="container">
        <h1 class="mb-4">Track Your Order</h1>
        <form method="POST" class="feature-card mb-4">
            <div class="row g-3">
                <div class="col-md-5"><label>Order Number</label><input name="order_number" value="<?php echo $orderNumber; ?>" class="form-control" placeholder="ORD-..." required></div>
                <div class="col-md-5"><label>Email Used at Checkout</label><input type="email" name="email" value="<?php echo $email; ?>" class="form-control" required></div>
                <div class="col-md-2 d-flex align-items-end"><button class="btn btn-primary w-100">Track</button></div>
            </div>
        </form>
        <?php if ($error): ?><div class="alert alert-warning"><?php echo $error; ?></div><?php endif; ?>
        <?php if ($order): ?>
            <div class="feature-card">
                <div class="d-flex justify-content-between flex-wrap mb-3"><h3><?php echo $order['order_number']; ?></h3><strong><?php echo money($order['order_total']); ?></strong></div>
                <div class="order-timeline">
                    <?php $steps = ['pending' => 'Order received', 'processing' => 'Preparing order', 'out_for_delivery' => 'Out for delivery', 'completed' => 'Completed']; $active = array_search($order['order_status'], array_keys($steps), true); if ($active === false) $active = 0; ?>
                    <?php foreach (array_values($steps) as $index => $label): ?>
                        <div class="timeline-step <?php echo $index <= $active ? 'active' : ''; ?>"><span><?php echo $index + 1; ?></span><p><?php echo $label; ?></p></div>
                    <?php endforeach; ?>
                </div>
                <p><strong>Status:</strong> <span class="badge bg-<?php echo statusBadgeClass($order['order_status']); ?>"><?php echo ucwords(str_replace('_', ' ', $order['order_status'])); ?></span></p>
                <p><strong>Payment:</strong> <span class="badge bg-<?php echo statusBadgeClass($order['payment_status']); ?>"><?php echo ucfirst($order['payment_status']); ?></span> via <?php echo $order['payment_method']; ?></p>
                <p><strong>Delivery Address:</strong> <?php echo $order['customer_address']; ?></p>
                <h5>Items</h5>
                <ul><?php foreach ($items as $item): ?><li><?php echo $item['product_name']; ?> x <?php echo $item['quantity']; ?> — <?php echo money($item['price'] * $item['quantity']); ?></li><?php endforeach; ?></ul>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php include 'includes/footer.php'; ?>
