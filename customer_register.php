<?php
require_once 'config/db.php';
$page_title = 'Create Customer Account';
$page_description = 'Create a Sewwer Poultry customer account to track orders, save details, and review products.';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($_POST['name'] ?? '');
    $email = strtolower(sanitize($_POST['email'] ?? ''));
    $phone = sanitize($_POST['phone'] ?? '');
    $address = sanitize($_POST['address'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!$name || !$email || !$phone || !$password) {
        $errors[] = 'Please complete all required fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    } elseif (strlen($password) < 6) {
        $errors[] = 'Password must be at least 6 characters.';
    } else {
        $exists = $pdo->prepare('SELECT id FROM customers WHERE email = ? LIMIT 1');
        $exists->execute([$email]);
        if ($exists->fetch()) {
            $errors[] = 'An account with this email already exists.';
        } else {
            $stmt = $pdo->prepare('INSERT INTO customers (name, email, phone, address, password) VALUES (?, ?, ?, ?, ?)');
            $stmt->execute([$name, $email, $phone, $address, password_hash($password, PASSWORD_DEFAULT)]);
            $_SESSION['customer_id'] = $pdo->lastInsertId();
            $_SESSION['customer_name'] = $name;
            redirect('customer_dashboard.php');
        }
    }
}
include 'includes/header.php';
?>
<section class="section-padding">
    <div class="container narrow-container">
        <h1 class="mb-4">Create Customer Account</h1>
        <?php foreach ($errors as $error): ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endforeach; ?>
        <form method="POST" class="feature-card">
            <div class="mb-3"><label>Full Name *</label><input name="name" class="form-control" required></div>
            <div class="mb-3"><label>Email *</label><input type="email" name="email" class="form-control" required></div>
            <div class="mb-3"><label>Phone *</label><input name="phone" class="form-control" required></div>
            <div class="mb-3"><label>Delivery Address</label><textarea name="address" class="form-control" rows="3"></textarea></div>
            <div class="mb-3"><label>Password *</label><input type="password" name="password" class="form-control" minlength="6" required></div>
            <button class="btn btn-primary w-100">Create Account</button>
            <p class="mt-3 mb-0">Already registered? <a href="customer_login.php">Login here</a>.</p>
        </form>
    </div>
</section>
<?php include 'includes/footer.php'; ?>
