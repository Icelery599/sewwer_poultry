<?php
require_once 'config/db.php';
if (!isCustomerLoggedIn()) redirect('customer_login.php');
$page_title = 'Customer Dashboard';
$page_description = 'View Sewwer Poultry order history, payment status and delivery tracking updates.';

$customerStmt = $pdo->prepare('SELECT * FROM customers WHERE id = ?');
$customerStmt->execute([currentCustomerId()]);
$customer = $customerStmt->fetch();

$orderStmt = $pdo->prepare('SELECT * FROM orders WHERE customer_id = ? OR customer_email = ? ORDER BY id DESC');
$orderStmt->execute([currentCustomerId(), $customer['email']]);
$orders = $orderStmt->fetchAll();
include 'includes/header.php';
?>
<section class="section-padding">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div><h1>Welcome, <?php echo $customer['name']; ?></h1><p class="mb-0 text-muted">Track orders, payments and delivery updates from one place.</p></div>
            <a class="btn btn-outline-secondary" href="customer_logout.php">Logout</a>
        </div>
        <div class="row mb-4">
            <div class="col-md-4"><div class="feature-card"><h5>Total Orders</h5><h2><?php echo count($orders); ?></h2></div></div>
            <div class="col-md-4"><div class="feature-card"><h5>Open Orders</h5><h2><?php echo count(array_filter($orders, fn($o) => !in_array($o['order_status'], ['completed','cancelled']))); ?></h2></div></div>
            <div class="col-md-4"><div class="feature-card"><h5>Support</h5><p class="mb-0"><a href="https://wa.me/<?php echo WHATSAPP_NUMBER; ?>">Chat on WhatsApp</a></p></div></div>
        </div>
        <div class="feature-card">
            <h3>My Orders</h3>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead><tr><th>Order #</th><th>Total</th><th>Order Status</th><th>Payment</th><th>Date</th><th></th></tr></thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?php echo $order['order_number']; ?></td>
                            <td><?php echo money($order['order_total']); ?></td>
                            <td><span class="badge bg-<?php echo statusBadgeClass($order['order_status']); ?>"><?php echo ucwords(str_replace('_', ' ', $order['order_status'])); ?></span></td>
                            <td><span class="badge bg-<?php echo statusBadgeClass($order['payment_status']); ?>"><?php echo ucfirst($order['payment_status']); ?></span></td>
                            <td><?php echo $order['created_at']; ?></td>
                            <td><a class="btn btn-sm btn-primary" href="track_order.php?order_number=<?php echo urlencode($order['order_number']); ?>&email=<?php echo urlencode($customer['email']); ?>">Track</a></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if (!$orders): ?><tr><td colspan="6" class="text-center">No orders yet. <a href="products.php">Start shopping</a>.</td></tr><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<?php include 'includes/footer.php'; ?>
