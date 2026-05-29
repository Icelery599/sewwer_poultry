<?php
require_once '../config/db.php';
if(!isLoggedIn()) redirect('admin/login.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderId = (int) ($_POST['order_id'] ?? 0);
    $status = sanitize($_POST['status'] ?? 'pending');
    $allowed = ['pending', 'processing', 'out_for_delivery', 'completed', 'cancelled'];
    if (in_array($status, $allowed, true) && $orderId > 0) {
        $stmt = $pdo->prepare('UPDATE orders SET order_status = ? WHERE id = ?');
        $stmt->execute([$status, $orderId]);
        $orderStmt = $pdo->prepare('SELECT * FROM orders WHERE id = ?');
        $orderStmt->execute([$orderId]);
        $order = $orderStmt->fetch();
        if ($order) {
            $message = 'Your order ' . $order['order_number'] . ' is now ' . str_replace('_', ' ', $status) . '.';
            createNotification($pdo, 'email', $order['customer_email'], 'Order status updated', $message);
            createNotification($pdo, 'sms', $order['customer_phone'], 'Order status updated', $message);
        }
    }
}
redirect('admin/orders.php');
?>
