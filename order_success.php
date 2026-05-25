<?php
// order_success.php - Order Confirmation
require_once 'config/db.php';
$page_title = 'Order Confirmed';
include 'includes/header.php';

$order_number = isset($_SESSION['order_success']) ? $_SESSION['order_success'] : null;
unset($_SESSION['order_success']);
?>

<section class="section-padding text-center">
    <div class="container">
        <?php if($order_number): ?>
            <div class="success-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h2>Thank You for Your Order!</h2>
            <p>Your order number: <strong><?php echo $order_number; ?></strong></p>
            <p>You will receive a confirmation call within 24 hours for payment and delivery details.</p>
            <p>For urgent inquiries, contact us via WhatsApp.</p>
            <a href="products.php" class="btn btn-primary mt-3">Continue Shopping</a>
        <?php else: ?>
            <p>No order found. <a href="products.php">Shop now</a></p>
        <?php endif; ?>
    </div>
</section>

<?php include 'includes/footer.php'; ?>