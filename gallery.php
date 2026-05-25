<?php
// gallery.php
require_once 'config/db.php';
$page_title = 'Gallery';
include 'includes/header.php';

$stmt = $pdo->query("SELECT * FROM gallery ORDER BY sort_order, id DESC");
$gallery_images = $stmt->fetchAll();
?>

<section class="section-padding">
    <div class="container">
        <h1 class="text-center mb-5">Our Farm Gallery</h1>
        <div class="row">
            <?php foreach($gallery_images as $img): ?>
            <div class="col-md-4 col-lg-3 mb-4">
                <div class="gallery-item">
                    <img src="assets/images/gallery/<?php echo $img['image']; ?>" alt="<?php echo $img['title']; ?>" class="img-fluid rounded">
                    <p class="mt-2 text-center"><?php echo $img['title']; ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>