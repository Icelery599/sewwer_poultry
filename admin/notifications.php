<?php
require_once '../config/db.php';
if(!isLoggedIn()) redirect('admin/login.php');
$logs = $pdo->query('SELECT * FROM notifications_log ORDER BY id DESC LIMIT 100')->fetchAll();
include 'includes/admin_header.php';
?>
<div class="container-fluid"><div class="row"><?php include 'includes/admin_sidebar.php'; ?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="pt-3 pb-2 mb-3 border-bottom"><h1>SMS & Email Notifications</h1><p class="text-muted">Notification events are queued here for connection to your SMS gateway and email provider.</p></div>
    <table class="table table-striped"><thead><tr><th>Date</th><th>Channel</th><th>Recipient</th><th>Subject</th><th>Status</th></tr></thead><tbody>
        <?php foreach($logs as $log): ?><tr><td><?php echo $log['created_at']; ?></td><td><?php echo strtoupper($log['channel']); ?></td><td><?php echo $log['recipient']; ?></td><td><?php echo $log['subject']; ?></td><td><span class="badge bg-secondary"><?php echo $log['status']; ?></span></td></tr><?php endforeach; ?>
    </tbody></table>
</main></div></div>
<?php include 'includes/admin_footer.php'; ?>
