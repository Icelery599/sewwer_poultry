<?php
// add_to_cart.php
require_once 'config/db.php';

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id'])) {
    $product_id = (int)$_POST['product_id'];
    $quantity = (int)$_POST['quantity'];
    
    // Get product details
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ? AND status = 1");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch();
    
    if($product && $quantity > 0 && $quantity <= $product['stock_quantity']) {
        if(!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        
        // Check if product already in cart
        $found = false;
        foreach($_SESSION['cart'] as &$item) {
            if($item['id'] == $product_id) {
                $new_qty = $item['quantity'] + $quantity;
                if($new_qty <= $product['stock_quantity']) {
                    $item['quantity'] = $new_qty;
                }
                $found = true;
                break;
            }
        }
        
        if(!$found) {
            $_SESSION['cart'][] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => $quantity,
                'image' => $product['image']
            ];
        }
        
        $_SESSION['success'] = "Product added to cart!";
    } else {
        $_SESSION['error'] = "Invalid quantity or product out of stock.";
    }
}

header("Location: products.php");
exit();
?>