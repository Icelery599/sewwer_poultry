<?php
require_once 'config/db.php';
$page_title = 'Poultry Farming Tips Blog';
$page_description = 'Helpful poultry farming tips, Noiler bird care guides, egg handling advice and farm business updates from Sewwer Poultry.';
$posts = $pdo->query("SELECT * FROM blog_posts WHERE status = 'published' ORDER BY published_at DESC, id DESC")->fetchAll();
include 'includes/header.php';
?>
<section class="section-padding">
    <div class="container">
        <h1 class="text-center mb-4">Poultry Farming Tips</h1>
        <p class="text-center mb-5">Practical guidance for healthy birds, better egg production and smarter poultry farm management.</p>
        <div class="row">
            <?php foreach ($posts as $post): ?>
            <div class="col-md-6 col-lg-4 mb-4">
                <article class="feature-card h-100">
                    <p class="text-muted small mb-2"><?php echo date('M d, Y', strtotime($post['published_at'] ?? $post['created_at'])); ?></p>
                    <h3><a href="post.php?slug=<?php echo urlencode($post['slug']); ?>"><?php echo $post['title']; ?></a></h3>
                    <p><?php echo $post['excerpt']; ?></p>
                    <a class="btn btn-outline-primary btn-sm" href="post.php?slug=<?php echo urlencode($post['slug']); ?>">Read More</a>
                </article>
            </div>
            <?php endforeach; ?>
            <?php if (!$posts): ?><p class="text-center">No blog posts published yet.</p><?php endif; ?>
        </div>
    </div>
</section>
<?php include 'includes/footer.php'; ?>
