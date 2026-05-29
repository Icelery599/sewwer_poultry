<?php
// place_order.php - Process Order
require_once 'config/db.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = sanitize($_POST['name'] ?? '');
    $email = strtolower(sanitize($_POST['email'] ?? ''));
    $phone = sanitize($_POST['phone'] ?? '');
    $address = sanitize($_POST['address'] ?? '');
    $notes = sanitize($_POST['notes'] ?? '');
    $payment_method = sanitize($_POST['payment_method'] ?? 'Bank Transfer');
    $allowedPayments = ['Bank Transfer', 'Cash on Delivery', 'Online Payment'];
    if (!in_array($payment_method, $allowedPayments, true)) {
        $payment_method = 'Bank Transfer';
    }
    $cart_items = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
    
    if(empty($cart_items)) {
        header("Location: cart.php");
        exit();
    }
    
    $total = getCartTotal();
    $order_number = 'ORD-' . strtoupper(uniqid());
    
    try {
        $pdo->beginTransaction();
        
        $stmt = $pdo->prepare("INSERT INTO orders (order_number, customer_id, customer_name, customer_email, customer_phone, customer_address, order_total, payment_method, order_notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$order_number, currentCustomerId(), $name, $email, $phone, $address, $total, $payment_method, $notes]);
        $order_id = $pdo->lastInsertId();
        
        foreach($cart_items as $item) {
            $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, product_name, quantity, price) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$order_id, $item['id'], $item['name'], $item['quantity'], $item['price']]);
            
            $update = $pdo->prepare("UPDATE products SET stock_quantity = GREATEST(stock_quantity - ?, 0) WHERE id = ?");
            $update->execute([$item['quantity'], $item['id']]);
        }

        $orderStmt = $pdo->prepare('SELECT * FROM orders WHERE id = ?');
        $orderStmt->execute([$order_id]);
        $order = $orderStmt->fetch();
        queueOrderNotifications($pdo, $order);
        
        $pdo->commit();
        
        unset($_SESSION['cart']);
        $_SESSION['order_success'] = $order_number;
        if ($payment_method === 'Online Payment') {
            header("Location: payment.php?order=" . urlencode($order_number));
        } else {
            header("Location: order_success.php");
        }
        exit();
        
    } catch(Exception $e) {
        $pdo->rollBack();
        $_SESSION['error'] = "Order failed. Please try again.";
        header("Location: checkout.php");
        exit();
    }
} else {
    header("Location: cart.php");
    exit();
}
?>
