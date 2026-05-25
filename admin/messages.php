<?php
// admin/messages.php - View contact messages
require_once '../config/db.php';
if(!isLoggedIn()) redirect('login.php');
$messages = $pdo->query("SELECT * FROM contacts ORDER BY id DESC")->fetchAll();
include 'includes/admin_header.php';
?>
<div class="container-fluid">
    <div class="row">
        <?php include 'includes/admin_sidebar.php'; ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <h2>Customer Messages</h2>
            <table class="table">
                <thead><tr><th>Name</th><th>Email</th><th>Subject</th><th>Message</th><th>Date</th></tr></thead>
                <tbody>
                    <?php foreach($messages as $msg): ?>
                    <tr>
                        <td><?php echo $msg['name']; ?></td>
                        <td><?php echo $msg['email']; ?></td>
                        <td><?php echo $msg['subject']; ?></td>
                        <td><?php echo substr($msg['message'],0,100); ?></td>
                        <td><?php echo $msg['created_at']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </main>
    </div>
</div>
<?php include 'includes/admin_footer.php'; ?>