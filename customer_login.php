<?php
require_once 'config/db.php';
$page_title = 'Customer Login';
$page_description = 'Login to your Sewwer Poultry customer dashboard to track orders and manage your profile.';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = strtolower(sanitize($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';
    $stmt = $pdo->prepare('SELECT * FROM customers WHERE email = ? LIMIT 1');
    $stmt->execute([$email]);
    $customer = $stmt->fetch();
    if ($customer && password_verify($password, $customer['password'])) {
        $_SESSION['customer_id'] = $customer['id'];
        $_SESSION['customer_name'] = $customer['name'];
        redirect('customer_dashboard.php');
    }
    $error = 'Invalid email or password.';
}
include 'includes/header.php';
?>
<section class="section-padding">
    <div class="container narrow-container">
        <h1 class="mb-4">Customer Login</h1>
        <?php if ($error): ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endif; ?>
        <form method="POST" class="feature-card">
            <div class="mb-3"><label>Email</label><input type="email" name="email" class="form-control" required></div>
            <div class="mb-3"><label>Password</label><input type="password" name="password" class="form-control" required></div>
            <button class="btn btn-primary w-100">Login</button>
            <p class="mt-3 mb-0">New customer? <a href="customer_register.php">Create an account</a>.</p>
        </form>
    </div>
</section>
<?php include 'includes/footer.php'; ?>
