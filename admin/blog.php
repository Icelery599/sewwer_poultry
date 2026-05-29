<?php
require_once '../config/db.php';
if(!isLoggedIn()) redirect('admin/login.php');
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = sanitize($_POST['title'] ?? '');
    $excerpt = sanitize($_POST['excerpt'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $status = sanitize($_POST['status'] ?? 'draft');
    $metaTitle = sanitize($_POST['meta_title'] ?? $title);
    $metaDescription = sanitize($_POST['meta_description'] ?? $excerpt);
    if ($title && $content) {
        $slug = slugify($title);
        $publishedAt = $status === 'published' ? date('Y-m-d H:i:s') : null;
        $stmt = $pdo->prepare('INSERT INTO blog_posts (title, slug, excerpt, content, meta_title, meta_description, status, published_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([$title, $slug, $excerpt, $content, $metaTitle, $metaDescription, $status, $publishedAt]);
        $message = 'Blog post saved.';
    }
}
$posts = $pdo->query('SELECT * FROM blog_posts ORDER BY id DESC')->fetchAll();
include 'includes/admin_header.php';
?>
<div class="container-fluid"><div class="row"><?php include 'includes/admin_sidebar.php'; ?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="pt-3 pb-2 mb-3 border-bottom"><h1>Blog Manager</h1><p class="text-muted">Publish poultry farming tips with SEO title and description fields.</p></div>
    <?php if($message): ?><div class="alert alert-success"><?php echo $message; ?></div><?php endif; ?>
    <form method="POST" class="card card-body mb-4">
        <div class="row"><div class="col-md-8 mb-3"><label>Title</label><input name="title" class="form-control" required></div><div class="col-md-4 mb-3"><label>Status</label><select name="status" class="form-control"><option value="draft">Draft</option><option value="published">Published</option></select></div></div>
        <div class="mb-3"><label>Excerpt</label><textarea name="excerpt" class="form-control" rows="2"></textarea></div>
        <div class="mb-3"><label>Content</label><textarea name="content" class="form-control" rows="8" required></textarea></div>
        <div class="row"><div class="col-md-6 mb-3"><label>SEO Meta Title</label><input name="meta_title" class="form-control"></div><div class="col-md-6 mb-3"><label>SEO Meta Description</label><input name="meta_description" class="form-control"></div></div>
        <button class="btn btn-primary">Save Post</button>
    </form>
    <table class="table table-striped"><thead><tr><th>Title</th><th>Status</th><th>Published</th><th>Slug</th></tr></thead><tbody><?php foreach($posts as $post): ?><tr><td><?php echo $post['title']; ?></td><td><?php echo $post['status']; ?></td><td><?php echo $post['published_at']; ?></td><td><?php echo $post['slug']; ?></td></tr><?php endforeach; ?></tbody></table>
</main></div></div>
<?php include 'includes/admin_footer.php'; ?>
