<?php
// about.php
require_once 'config/db.php';
$page_title = 'About Us';
include 'includes/header.php';
?>

<section class="section-padding">
    <div class="container">
        <h1 class="text-center mb-5">About Sewwer Poultry</h1>
        <div class="row">
            <div class="col-lg-6">
                <img src="assets/images/about-farm.jpg" alt="About Sewwer Poultry" class="img-fluid rounded mb-4">
            </div>
            <div class="col-lg-6">
                <h2>Our Story</h2>
                <p>Sewwer Poultry was established in 2025 with the mission of providing healthy, quality Noiler birds, fresh eggs, poultry manure, and mature birds for consumption. We are committed to ethical poultry farming, proper bird care, and customer satisfaction while maintaining quality production standards.</p>
                <h3>Mission</h3>
                <p>To deliver premium poultry products while promoting sustainable and ethical farming practices that benefit our community.</p>
                <h3>Vision</h3>
                <p>To become Nigeria's most trusted source for Noiler birds and organic poultry products.</p>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>