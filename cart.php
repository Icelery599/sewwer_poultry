<?php
// cart.php - Shopping Cart Page
require_once 'config/db.php';
$page_title = 'Shopping Cart';
include 'includes/header.php';

$cart_items = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$total = getCartTotal();
?>

<section class="section-padding">
    <div class="container">
        <h1 class="text-center mb-5">Your Shopping Cart</h1>
        
        <?php if(isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        <?php if(isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>
        
        <?php if(empty($cart_items)): ?>
            <div class="text-center">
                <p>Your cart is empty.</p>
                <a href="products.php" class="btn btn-primary">Continue Shopping</a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table cart-table">
                    <thead>
                        <tr><th>Product</th><th>Price</th><th>Quantity</th><th>Subtotal</th><th></th></tr>
                    </thead>
                    <tbody>
                        <?php foreach($cart_items as $index => $item): ?>
                        <tr>
                            <td><?php echo $item['name']; ?></td>
                            <td>₦<?php echo number_format($item['price'], 2); ?></td>
                            <td>
                                <form action="update_cart.php" method="POST" class="d-inline">
                                    <input type="hidden" name="index" value="<?php echo $index; ?>">
                                    <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" style="width:70px">
                                    <button type="submit" class="btn btn-sm btn-secondary">Update</button>
                                </form>
                            </td>
                            <td>₦<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                            <td><a href="remove_from_cart.php?index=<?php echo $index; ?>" class="btn btn-sm btn-danger">Remove</a></td>
                        </tr>
                        <?php endforeach; ?>
                        <tr class="table-active">
                            <td colspan="3"><strong>Total</strong></td>
                            <td colspan="2"><strong>₦<?php echo number_format($total, 2); ?></strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="text-end">
                <a href="products.php" class="btn btn-secondary">Add More Items</a>
                <a href="checkout.php" class="btn btn-primary">Proceed to Checkout</a>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php include 'includes/footer.php'; ?>