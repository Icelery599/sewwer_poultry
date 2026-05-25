<?php
// place_order.php - Process Order
require_once 'config/db.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $phone = sanitize($_POST['phone']);
    $address = sanitize($_POST['address']);
    $cart_items = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
    
    if(empty($cart_items)) {
        header("Location: cart.php");
        exit();
    }
    
    $total = getCartTotal();
    $order_number = 'ORD-' . strtoupper(uniqid());
    
    try {
        $pdo->beginTransaction();
        
        // Insert order
        $stmt = $pdo->prepare("INSERT INTO orders (order_number, customer_name, customer_email, customer_phone, customer_address, order_total) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$order_number, $name, $email, $phone, $address, $total]);
        $order_id = $pdo->lastInsertId();
        
        // Insert order items
        foreach($cart_items as $item) {
            $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, product_name, quantity, price) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$order_id, $item['id'], $item['name'], $item['quantity'], $item['price']]);
            
            // Update stock
            $update = $pdo->prepare("UPDATE products SET stock_quantity = stock_quantity - ? WHERE id = ?");
            $update->execute([$item['quantity'], $item['id']]);
        }
        
        $pdo->commit();
        
        // Clear cart
        unset($_SESSION['cart']);
        $_SESSION['order_success'] = $order_number;
        header("Location: order_success.php");
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