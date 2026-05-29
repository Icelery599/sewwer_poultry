<?php
require_once '../config/db.php';
if(!isLoggedIn()) redirect('admin/login.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int) ($_POST['review_id'] ?? 0);
    $status = sanitize($_POST['status'] ?? 'pending');
    if ($id && in_array($status, ['pending', 'approved', 'rejected'], true)) {
        $stmt = $pdo->prepare('UPDATE reviews SET status = ? WHERE id = ?');
        $stmt->execute([$status, $id]);
    }
}
$reviews = $pdo->query('SELECT * FROM reviews ORDER BY id DESC')->fetchAll();
include 'includes/admin_header.php';
?>
<div class="container-fluid"><div class="row"><?php include 'includes/admin_sidebar.php'; ?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="pt-3 pb-2 mb-3 border-bottom"><h1>Customer Reviews</h1></div>
    <table class="table table-striped align-middle"><thead><tr><th>Customer</th><th>Rating</th><th>Review</th><th>Status</th></tr></thead><tbody>
        <?php foreach($reviews as $review): ?><tr><td><?php echo $review['customer_name']; ?><br><small><?php echo $review['customer_email']; ?></small></td><td><?php echo str_repeat('★', (int)$review['rating']); ?></td><td><?php echo $review['review']; ?></td><td><form method="POST"><input type="hidden" name="review_id" value="<?php echo $review['id']; ?>"><select class="form-select" name="status" onchange="this.form.submit()"><option value="pending" <?php echo $review['status']=='pending'?'selected':''; ?>>Pending</option><option value="approved" <?php echo $review['status']=='approved'?'selected':''; ?>>Approved</option><option value="rejected" <?php echo $review['status']=='rejected'?'selected':''; ?>>Rejected</option></select></form></td></tr><?php endforeach; ?>
    </tbody></table>
</main></div></div>
<?php include 'includes/admin_footer.php'; ?>
