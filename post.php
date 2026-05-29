<?php
require_once 'config/db.php';
$slug = sanitize($_GET['slug'] ?? '');
$stmt = $pdo->prepare("SELECT * FROM blog_posts WHERE slug = ? AND status = 'published' LIMIT 1");
$stmt->execute([$slug]);
$post = $stmt->fetch();
if (!$post) redirect('blog.php');
$page_title = $post['meta_title'] ?: $post['title'];
$page_description = $post['meta_description'] ?: $post['excerpt'];
$canonical_url = SITE_URL . 'post.php?slug=' . urlencode($post['slug']);
include 'includes/header.php';
?>
<section class="section-padding">
    <div class="container narrow-container">
        <article class="feature-card blog-post">
            <p class="text-muted"><?php echo date('F d, Y', strtotime($post['published_at'] ?? $post['created_at'])); ?></p>
            <h1><?php echo $post['title']; ?></h1>
            <p class="lead"><?php echo $post['excerpt']; ?></p>
            <hr>
            <?php echo nl2br(htmlspecialchars($post['content'])); ?>
        </article>
    </div>
</section>
<?php include 'includes/footer.php'; ?>
