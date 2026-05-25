<?php
// checkout.php - Checkout Page
require_once 'config/db.php';
$page_title = 'Checkout';
include 'includes/header.php';

$cart_items = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$total = getCartTotal();

if(empty($cart_items)) {
    header("Location: cart.php");
    exit();
}
?>

<section class="section-padding">
    <div class="container">
        <h1 class="text-center mb-5">Checkout</h1>
        
        <div class="row">
            <div class="col-md-7">
                <form action="place_order.php" method="POST" class="checkout-form">
                    <div class="mb-3">
                        <label>Full Name *</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Email Address *</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Phone Number *</label>
                        <input type="tel" name="phone" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Delivery Address *</label>
                        <textarea name="address" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Order Notes (Optional)</label>
                        <textarea name="notes" class="form-control" rows="2"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg w-100">Place Order</button>
                </form>
            </div>
            <div class="col-md-5">
                <div class="order-summary">
                    <h4>Order Summary</h4>
                    <?php foreach($cart_items as $item): ?>
                    <div class="summary-item">
                        <span><?php echo $item['name']; ?> x <?php echo $item['quantity']; ?></span>
                        <span>₦<?php echo number_format($item['price'] * $item['quantity'], 2); ?></span>
                    </div>
                    <?php endforeach; ?>
                    <hr>
                    <div class="summary-total">
                        <strong>Total:</strong>
                        <strong>₦<?php echo number_format($total, 2); ?></strong>
                    </div>
                    <p class="mt-3 text-muted small">Payment via Bank Transfer will be provided after order confirmation.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>