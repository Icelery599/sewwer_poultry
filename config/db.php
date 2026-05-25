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

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Helper functions
function isLoggedIn() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

function redirect($url) {
    header("Location: " . SITE_URL . $url);
    exit();
}

function sanitize($input) {
    return htmlspecialchars(strip_tags(trim($input)));
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
?>