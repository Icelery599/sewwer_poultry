<?php
// includes/header.php - Global header template
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title><?php echo isset($page_title) ? $page_title . ' - ' . SITE_NAME : SITE_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>assets/css/style.css">
    <link rel="icon" href="<?php echo SITE_URL; ?>assets/images/favicon.ico" type="image/x-icon">
</head>
<body>

<!-- WhatsApp Floating Button -->
<a href="https://wa.me/<?php echo WHATSAPP_NUMBER; ?>?text=Hello%20Sewwer%20Poultry,%20I%20need%20more%20information%20about%20your%20products" 
   class="whatsapp-float" target="_blank">
    <i class="fab fa-whatsapp"></i>
</a>

<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <a class="navbar-brand" href="<?php echo SITE_URL; ?>">
            <img src="<?php echo SITE_URL; ?>assets/images/logo.png" alt="<?php echo SITE_NAME; ?>" height="50">
            <span class="brand-text">SEWWER POULTRY</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="<?php echo SITE_URL; ?>">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo SITE_URL; ?>about.php">About</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo SITE_URL; ?>products.php">Products</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo SITE_URL; ?>trust.php">Trust & Transparency</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo SITE_URL; ?>gallery.php">Gallery</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo SITE_URL; ?>contact.php">Contact</a></li>
                <li class="nav-item">
                    <a class="nav-link cart-icon" href="<?php echo SITE_URL; ?>cart.php">
                        <i class="fas fa-shopping-cart"></i> 
                        <span class="cart-badge"><?php echo getCartCount(); ?></span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main>