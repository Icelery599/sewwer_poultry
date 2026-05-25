<?php
// contact.php - Contact Page with Form
require_once 'config/db.php';
$page_title = 'Contact Us';
include 'includes/header.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $phone = sanitize($_POST['phone']);
    $subject = sanitize($_POST['subject']);
    $message = sanitize($_POST['message']);
    
    $stmt = $pdo->prepare("INSERT INTO contacts (name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)");
    if($stmt->execute([$name, $email, $phone, $subject, $message])) {
        $success = "Thank you! We'll get back to you shortly.";
    } else {
        $error = "Message failed. Please try again.";
    }
}
?>

<section class="section-padding">
    <div class="container">
        <h1 class="text-center mb-5">Contact Us</h1>
        
        <?php if(isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        <?php if(isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <div class="row">
            <div class="col-lg-6 mb-4">
                <h3>Get In Touch</h3>
                <p><i class="fas fa-map-marker-alt"></i> <?php echo LOCATION; ?></p>
                <p><i class="fas fa-phone"></i> <?php echo PHONE_NUMBER; ?></p>
                <p><i class="fas fa-envelope"></i> <?php echo EMAIL_ADDRESS; ?></p>
                
                <h4 class="mt-4">Bulk Order Inquiries</h4>
                <p>For large orders (restaurants, agro-business, farms), please call us or use this form.</p>
                
                <div class="map-container mt-3">
                    <iframe src="https://maps.google.com/maps?q=TY%20Danjuma%20Way%2C%20ATC%2C%20Kofai%2C%20Nigeria&t=&z=13&ie=UTF8&iwloc=&output=embed" width="100%" height="250" style="border:0;" allowfullscreen></iframe>
                </div>
            </div>
            <div class="col-lg-6">
                <form method="POST" class="contact-form">
                    <div class="mb-3">
                        <input type="text" name="name" class="form-control" placeholder="Your Name" required>
                    </div>
                    <div class="mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email Address" required>
                    </div>
                    <div class="mb-3">
                        <input type="tel" name="phone" class="form-control" placeholder="Phone Number">
                    </div>
                    <div class="mb-3">
                        <input type="text" name="subject" class="form-control" placeholder="Subject" required>
                    </div>
                    <div class="mb-3">
                        <textarea name="message" class="form-control" rows="5" placeholder="Your Message" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Send Message</button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>