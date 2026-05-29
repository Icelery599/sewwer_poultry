<?php
// includes/header.php - Global header template
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title><?php echo isset($page_title) ? $page_title . ' - ' . SITE_NAME : SITE_NAME . ' | Fresh Poultry Products in Nigeria'; ?></title>
    <meta name="description" content="<?php echo isset($page_description) ? htmlspecialchars($page_description) : 'Order fresh eggs, healthy Noiler birds, organic poultry manure and farm products from Sewwer Poultry in Nigeria.'; ?>">
    <meta name="keywords" content="Sewwer Poultry, Noiler birds, fresh eggs Nigeria, poultry farm, organic manure, poultry tips">
    <link rel="canonical" href="<?php echo isset($canonical_url) ? $canonical_url : SITE_URL . basename($_SERVER['PHP_SELF']); ?>">
    <meta property="og:title" content="<?php echo isset($page_title) ? $page_title . ' - ' . SITE_NAME : SITE_NAME; ?>">
    <meta property="og:description" content="<?php echo isset($page_description) ? htmlspecialchars($page_description) : 'Fresh poultry products, reliable order tracking, and helpful farming resources.'; ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo isset($canonical_url) ? $canonical_url : SITE_URL . basename($_SERVER['PHP_SELF']); ?>">
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "LocalBusiness",
      "name": "<?php echo SITE_NAME; ?>",
      "url": "<?php echo SITE_URL; ?>",
      "telephone": "<?php echo PHONE_NUMBER; ?>",
      "email": "<?php echo EMAIL_ADDRESS; ?>",
      "address": "<?php echo LOCATION; ?>",
      "description": "Fresh eggs, Noiler birds and poultry farm supplies in Nigeria."
    }
    </script>
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
                <li class="nav-item"><a class="nav-link" href="<?php echo SITE_URL; ?>blog.php">Blog</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo SITE_URL; ?>track_order.php">Track Order</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo SITE_URL; ?>trust.php">Trust & Transparency</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo SITE_URL; ?>gallery.php">Gallery</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo SITE_URL; ?>contact.php">Contact</a></li>
                <?php if(isCustomerLoggedIn()): ?>
                    <li class="nav-item"><a class="nav-link" href="<?php echo SITE_URL; ?>customer_dashboard.php">My Dashboard</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="<?php echo SITE_URL; ?>customer_login.php">Login</a></li>
                <?php endif; ?>
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