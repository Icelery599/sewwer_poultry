<?php
require_once 'config/db.php';
$page_title = 'Online Payment';
$orderNumber = sanitize($_GET['order'] ?? '');
$stmt = $pdo->prepare('SELECT * FROM orders WHERE order_number = ? LIMIT 1');
$stmt->execute([$orderNumber]);
$order = $stmt->fetch();
if (!$order) redirect('products.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reference = 'PAY-' . strtoupper(uniqid());
    $update = $pdo->prepare("UPDATE orders SET payment_status = 'paid', payment_reference = ?, payment_method = 'Online Payment' WHERE id = ?");
    $update->execute([$reference, $order['id']]);
    createNotification($pdo, 'email', $order['customer_email'], 'Payment received', 'Your payment for order ' . $order['order_number'] . ' has been recorded.', 'queued');
    $_SESSION['order_success'] = $order['order_number'];
    redirect('order_success.php');
}
include 'includes/header.php';
?>
<section class="section-padding">
    <div class="container narrow-container">
        <div class="feature-card text-center">
            <h1>Pay Online</h1>
            <p>Order <strong><?php echo $order['order_number']; ?></strong></p>
            <h2><?php echo money($order['order_total']); ?></h2>
            <p class="text-muted">This page is ready for a Paystack/Flutterwave integration. Add your live public key in <code>config/db.php</code> and replace the demo confirmation with the provider callback verification before production use.</p>
            <form method="POST"><button class="btn btn-primary btn-lg w-100">Record Demo Online Payment</button></form>
        </div>
    </div>
</section>
<?php include 'includes/footer.php'; ?>
