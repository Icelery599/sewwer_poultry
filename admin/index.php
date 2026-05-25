<?php
// admin/index.php - Admin Dashboard
require_once '../config/db.php';
if(!isLoggedIn()) redirect('login.php');

// Get counts
$product_count = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
$order_count = $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
$message_count = $pdo->query("SELECT COUNT(*) FROM contacts WHERE is_read=0")->fetchColumn();
$pending_orders = $pdo->query("SELECT COUNT(*) FROM orders WHERE order_status='pending'")->fetchColumn();

include 'includes/admin_header.php';
?>

<div class="container-fluid">
    <div class="row">
        <?php include 'includes/admin_sidebar.php'; ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1>Dashboard</h1>
            </div>
            <div class="row">
                <div class="col-md-3 mb-3"><div class="card text-white bg-primary"><div class="card-body"><h5>Products</h5><h2><?php echo $product_count; ?></h2></div></div></div>
                <div class="col-md-3 mb-3"><div class="card text-white bg-success"><div class="card-body"><h5>Total Orders</h5><h2><?php echo $order_count; ?></h2></div></div></div>
                <div class="col-md-3 mb-3"><div class="card text-white bg-warning"><div class="card-body"><h5>Unread Messages</h5><h2><?php echo $message_count; ?></h2></div></div></div>
                <div class="col-md-3 mb-3"><div class="card text-white bg-danger"><div class="card-body"><h5>Pending Orders</h5><h2><?php echo $pending_orders; ?></h2></div></div></div>
            </div>
            
            <h3>Recent Orders</h3>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead><tr><th>Order #</th><th>Customer</th><th>Total</th><th>Status</th><th>Date</th><th></th></tr></thead>
                    <tbody>
                        <?php
                        $orders = $pdo->query("SELECT * FROM orders ORDER BY id DESC LIMIT 5")->fetchAll();
                        foreach($orders as $order): ?>
                        <tr>
                            <td><?php echo $order['order_number']; ?></td>
                            <td><?php echo $order['customer_name']; ?></td>
                            <td>₦<?php echo number_format($order['order_total'],2); ?></td>
                            <td><span class="badge bg-<?php echo $order['order_status']=='pending'?'warning':'success'; ?>"><?php echo $order['order_status']; ?></span></td>
                            <td><?php echo $order['created_at']; ?></td>
                            <td><a href="order_details.php?id=<?php echo $order['id']; ?>" class="btn btn-sm btn-info">View</a></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>

<?php include 'includes/admin_footer.php'; ?>