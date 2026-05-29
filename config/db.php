<?php
session_start();

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'sewwer_poultry');

// Site configuration
define('SITE_NAME', 'Sewwer Poultry');
define('SITE_URL', 'http://localhost/sewwer_poultry/');
define('WHATSAPP_NUMBER', '2348123456789'); // Replace with actual number (without +)
define('ADMIN_EMAIL', 'info@sewwerpoultry.com');
define('PHONE_NUMBER', '+234 812 345 6789');
define('EMAIL_ADDRESS', 'info@sewwerpoultry.com');
define('LOCATION', 'TY Danjuma Way, ATC, Kofai, Nigeria');
define('PAYSTACK_PUBLIC_KEY', 'pk_test_replace_with_your_key');
define('SMS_SENDER_ID', 'SEWWER');

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

function isLoggedIn() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

function isCustomerLoggedIn() {
    return isset($_SESSION['customer_id']) && !empty($_SESSION['customer_id']);
}

function currentCustomerId() {
    return isCustomerLoggedIn() ? (int) $_SESSION['customer_id'] : null;
}

function redirect($url) {
    if (preg_match('/^https?:\/\//', $url)) {
        header("Location: " . $url);
    } else {
        header("Location: " . SITE_URL . ltrim($url, '/'));
    }
    exit();
}

function sanitize($input) {
    return htmlspecialchars(strip_tags(trim((string) $input)), ENT_QUOTES, 'UTF-8');
}

function slugify($text) {
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $text), '-'));
    return $slug ?: 'post-' . time();
}

function money($amount) {
    return '₦' . number_format((float) $amount, 2);
}

function statusBadgeClass($status) {
    $classes = [
        'pending' => 'warning',
        'processing' => 'info',
        'out_for_delivery' => 'primary',
        'completed' => 'success',
        'cancelled' => 'danger',
        'paid' => 'success',
        'unpaid' => 'secondary',
        'failed' => 'danger'
    ];
    return $classes[$status] ?? 'secondary';
}

function getCartCount() {
    $count = 0;
    if(isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
        foreach($_SESSION['cart'] as $item) {
            $count += $item['quantity'];
        }
    }
    return $count;
}

function getCartTotal() {
    $total = 0;
    if(isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
        foreach($_SESSION['cart'] as $item) {
            $total += $item['price'] * $item['quantity'];
        }
    }
    return $total;
}

function createNotification($pdo, $channel, $recipient, $subject, $message, $status = 'queued') {
    $stmt = $pdo->prepare("INSERT INTO notifications_log (channel, recipient, subject, message, status) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$channel, $recipient, $subject, $message, $status]);
}

function queueOrderNotifications($pdo, $order) {
    $subject = 'Order ' . $order['order_number'] . ' received';
    $message = 'Thank you, ' . $order['customer_name'] . '. We received your Sewwer Poultry order and will update you as it progresses.';
    createNotification($pdo, 'email', $order['customer_email'], $subject, $message);
    createNotification($pdo, 'sms', $order['customer_phone'], $subject, $message);
    createNotification($pdo, 'email', ADMIN_EMAIL, 'New order: ' . $order['order_number'], 'A new order worth ' . money($order['order_total']) . ' has been placed.');
}
?>
