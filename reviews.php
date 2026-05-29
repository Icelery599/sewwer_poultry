<?php
require_once 'config/db.php';
$page_title = 'Customer Reviews';
$page_description = 'Read and submit customer reviews for Sewwer Poultry products and services.';
$success = '';
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($_POST['customer_name'] ?? '');
    $email = sanitize($_POST['customer_email'] ?? '');
    $rating = (int) ($_POST['rating'] ?? 5);
    $review = sanitize($_POST['review'] ?? '');
    if (!$name || !$email || !$review || $rating < 1 || $rating > 5) {
        $errors[] = 'Please complete the review form with a rating from 1 to 5.';
    } else {
        $stmt = $pdo->prepare('INSERT INTO reviews (customer_id, customer_name, customer_email, rating, review) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([currentCustomerId(), $name, $email, $rating, $review]);
        $success = 'Thank you. Your review is pending approval.';
    }
}
$reviews = $pdo->query('SELECT * FROM reviews WHERE status = "approved" ORDER BY id DESC')->fetchAll();
include 'includes/header.php';
?>
<section class="section-padding">
    <div class="container">
        <h1 class="text-center mb-4">Customer Reviews</h1>
        <div class="row">
            <div class="col-lg-7">
                <?php foreach ($reviews as $review): ?>
                    <div class="feature-card mb-3"><div class="review-stars"><?php echo str_repeat('★', (int)$review['rating']) . str_repeat('☆', 5 - (int)$review['rating']); ?></div><p>“<?php echo $review['review']; ?>”</p><strong><?php echo $review['customer_name']; ?></strong></div>
                <?php endforeach; ?>
                <?php if (!$reviews): ?><p class="text-center">No approved reviews yet.</p><?php endif; ?>
            </div>
            <div class="col-lg-5">
                <form method="POST" class="feature-card">
                    <h3>Leave a Review</h3>
                    <?php if ($success): ?><div class="alert alert-success"><?php echo $success; ?></div><?php endif; ?>
                    <?php foreach ($errors as $error): ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endforeach; ?>
                    <div class="mb-3"><label>Name</label><input name="customer_name" class="form-control" value="<?php echo $_SESSION['customer_name'] ?? ''; ?>" required></div>
                    <div class="mb-3"><label>Email</label><input type="email" name="customer_email" class="form-control" required></div>
                    <div class="mb-3"><label>Rating</label><select name="rating" class="form-control"><option value="5">5 Stars</option><option value="4">4 Stars</option><option value="3">3 Stars</option><option value="2">2 Stars</option><option value="1">1 Star</option></select></div>
                    <div class="mb-3"><label>Review</label><textarea name="review" rows="4" class="form-control" required></textarea></div>
                    <button class="btn btn-primary w-100">Submit Review</button>
                </form>
            </div>
        </div>
    </div>
</section>
<?php include 'includes/footer.php'; ?>
