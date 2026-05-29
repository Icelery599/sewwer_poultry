<?php
require_once 'config/db.php';
header('Content-Type: application/xml; charset=utf-8');
$staticPages = ['', 'about.php', 'products.php', 'blog.php', 'reviews.php', 'track_order.php', 'contact.php'];
$posts = $pdo->query("SELECT slug, updated_at FROM blog_posts WHERE status = 'published'")->fetchAll();
echo '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php foreach ($staticPages as $page): ?>
  <url><loc><?php echo SITE_URL . $page; ?></loc><changefreq>weekly</changefreq><priority><?php echo $page === '' ? '1.0' : '0.8'; ?></priority></url>
<?php endforeach; ?>
<?php foreach ($posts as $post): ?>
  <url><loc><?php echo SITE_URL . 'post.php?slug=' . urlencode($post['slug']); ?></loc><lastmod><?php echo date('Y-m-d', strtotime($post['updated_at'])); ?></lastmod><changefreq>monthly</changefreq><priority>0.7</priority></url>
<?php endforeach; ?>
</urlset>
