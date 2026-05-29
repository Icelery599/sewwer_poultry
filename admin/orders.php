<?php
// Admin additional files - orders.php, products.php, messages.php (CRUD)
// admin/orders.php - View all orders
require_once '../config/db.php';
if(!isLoggedIn()) redirect('admin/login.php');
$orders = $pdo->query("SELECT * FROM orders ORDER BY id DESC")->fetchAll();
include 'includes/admin_header.php';
?>
<div class="container-fluid">
    <div class="row">
        <?php include 'includes/admin_sidebar.php'; ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <h2>All Orders</h2>
            <table class="table">
                <thead><tr><th>Order #</th><th>Customer</th><th>Total</th><th>Payment</th><th>Status</th><th>Date</th><th>Action</th></tr></thead>
                <tbody>
                    <?php foreach($orders as $order): ?>
                    <tr>
                        <td><?php echo $order['order_number']; ?></td>
                        <td><?php echo $order['customer_name']; ?></td>
                        <td>₦<?php echo number_format($order['order_total'],2); ?></td>
                        <td><span class="badge bg-<?php echo statusBadgeClass($order['payment_status']); ?>"><?php echo ucfirst($order['payment_status']); ?></span></td>
                        <td>
                            <form method="POST" action="update_order_status.php" style="display:inline">
                                <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                <select name="status" onchange="this.form.submit()">
                                    <option value="pending" <?php echo $order['order_status']=='pending'?'selected':''; ?>>Pending</option>
                                    <option value="processing" <?php echo $order['order_status']=='processing'?'selected':''; ?>>Processing</option>
                                    <option value="out_for_delivery" <?php echo $order['order_status']=='out_for_delivery'?'selected':''; ?>>Out for Delivery</option>
                                    <option value="completed" <?php echo $order['order_status']=='completed'?'selected':''; ?>>Completed</option>
                                    <option value="cancelled" <?php echo $order['order_status']=='cancelled'?'selected':''; ?>>Cancelled</option>
                                </select>
                            </form>
                        </td>
                        <td><?php echo $order['created_at']; ?></td>
                        <td><a href="order_details.php?id=<?php echo $order['id']; ?>" class="btn btn-sm btn-info">View</a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </main>
    </div>
</div>
<?php include 'includes/admin_footer.php'; ?>