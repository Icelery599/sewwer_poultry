<?php
// trust.php - Trust & Transparency Page
require_once 'config/db.php';
$page_title = 'Trust & Transparency';
include 'includes/header.php';
?>

<section class="section-padding">
    <div class="container">
        <h1 class="text-center mb-5">Our Commitment to Quality & Trust</h1>
        
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="trust-card">
                    <i class="fas fa-thermometer"></i>
                    <h3>Biosecurity Measures</h3>
                    <ul>
                        <li>Clean poultry housing with regular disinfection</li>
                        <li>Controlled access to farm facilities</li>
                        <li>Foot baths and protective gear for staff</li>
                        <li>Regular health monitoring</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="trust-card">
                    <i class="fas fa-syringe"></i>
                    <h3>Vaccination Program</h3>
                    <ul>
                        <li>Newcastle Disease vaccination</li>
                        <li>Gumboro (IBD) vaccination</li>
                        <li>Fowl Pox protection</li>
                        <li>Regular veterinary oversight</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="trust-card">
                    <i class="fas fa-hand-holding-heart"></i>
                    <h3>Ethical Farming Practices</h3>
                    <ul>
                        <li>Proper nutrition and clean water</li>
                        <li>Humane handling and processing</li>
                        <li>Environmentally friendly waste management</li>
                        <li>No unnecessary antibiotics</li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="certification-box text-center">
            <h3>Quality Guarantee</h3>
            <p>All our products are sourced from healthy, well-cared-for birds. We maintain strict quality control from hatch to delivery.</p>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>