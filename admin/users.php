<?php
require_once '../config/db.php';
if(!isLoggedIn()) redirect('admin/login.php');

$message = '';
$error = '';
$currentAdminId = (int) ($_SESSION['admin_id'] ?? 0);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = sanitize($_POST['action'] ?? '');

    if ($action === 'create') {
        $username = sanitize($_POST['username'] ?? '');
        $email = strtolower(sanitize($_POST['email'] ?? ''));
        $role = sanitize($_POST['role'] ?? 'staff');
        $password = $_POST['password'] ?? '';

        if (!$username || !$email || !$password) {
            $error = 'Username, email, and password are required.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Please enter a valid email address.';
        } elseif (strlen($password) < 6) {
            $error = 'Password must be at least 6 characters.';
        } elseif (!in_array($role, ['admin', 'staff'], true)) {
            $error = 'Please choose a valid role.';
        } else {
            $exists = $pdo->prepare('SELECT id FROM users WHERE username = ? LIMIT 1');
            $exists->execute([$username]);
            if ($exists->fetch()) {
                $error = 'That username is already in use.';
            } else {
                $stmt = $pdo->prepare('INSERT INTO users (username, email, role, password) VALUES (?, ?, ?, ?)');
                $stmt->execute([$username, $email, $role, password_hash($password, PASSWORD_DEFAULT)]);
                $message = 'Admin user created successfully.';
            }
        }
    }

    if ($action === 'update') {
        $userId = (int) ($_POST['user_id'] ?? 0);
        $email = strtolower(sanitize($_POST['email'] ?? ''));
        $role = sanitize($_POST['role'] ?? 'staff');
        $password = $_POST['password'] ?? '';

        if (!$userId || !$email) {
            $error = 'A valid user and email are required.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Please enter a valid email address.';
        } elseif (!in_array($role, ['admin', 'staff'], true)) {
            $error = 'Please choose a valid role.';
        } elseif ($password && strlen($password) < 6) {
            $error = 'Password must be at least 6 characters.';
        } else {
            $stmt = $pdo->prepare('SELECT role FROM users WHERE id = ? LIMIT 1');
            $stmt->execute([$userId]);
            $existingUser = $stmt->fetch();
            $adminCount = (int) $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'admin'")->fetchColumn();

            if (!$existingUser) {
                $error = 'The selected user could not be found.';
            } elseif ($existingUser['role'] === 'admin' && $role !== 'admin' && $adminCount <= 1) {
                $error = 'At least one admin account must remain active.';
            } elseif ($password) {
                $stmt = $pdo->prepare('UPDATE users SET email = ?, role = ?, password = ? WHERE id = ?');
                $stmt->execute([$email, $role, password_hash($password, PASSWORD_DEFAULT), $userId]);
            } else {
                $stmt = $pdo->prepare('UPDATE users SET email = ?, role = ? WHERE id = ?');
                $stmt->execute([$email, $role, $userId]);
            }
            if (!$error) {
                $message = 'Admin user updated successfully.';
            }
        }
    }

    if ($action === 'delete') {
        $userId = (int) ($_POST['user_id'] ?? 0);
        $adminCount = (int) $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'admin'")->fetchColumn();
        $stmt = $pdo->prepare('SELECT role FROM users WHERE id = ? LIMIT 1');
        $stmt->execute([$userId]);
        $user = $stmt->fetch();

        if (!$userId || !$user) {
            $error = 'The selected user could not be found.';
        } elseif ($userId === $currentAdminId) {
            $error = 'You cannot delete your own account while signed in.';
        } elseif ($user['role'] === 'admin' && $adminCount <= 1) {
            $error = 'At least one admin account must remain active.';
        } else {
            $stmt = $pdo->prepare('DELETE FROM users WHERE id = ?');
            $stmt->execute([$userId]);
            $message = 'Admin user deleted successfully.';
        }
    }
}

$users = $pdo->query('SELECT id, username, email, role, created_at FROM users ORDER BY role ASC, username ASC')->fetchAll();
include 'includes/admin_header.php';
?>
<div class="container-fluid"><div class="row"><?php include 'includes/admin_sidebar.php'; ?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center gap-2 pt-3 pb-2 mb-3 border-bottom">
        <div>
            <h1>Manage Users</h1>
            <p class="text-muted mb-0">Create staff accounts, update roles, and reset passwords for the admin panel.</p>
        </div>
    </div>

    <?php if($message): ?><div class="alert alert-success"><?php echo $message; ?></div><?php endif; ?>
    <?php if($error): ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endif; ?>

    <div class="card card-body mb-4">
        <h2 class="h5 mb-3">Add New User</h2>
        <form method="POST" class="row g-3">
            <input type="hidden" name="action" value="create">
            <div class="col-md-3"><label class="form-label">Username</label><input name="username" class="form-control" required></div>
            <div class="col-md-3"><label class="form-label">Email</label><input type="email" name="email" class="form-control" required></div>
            <div class="col-md-2"><label class="form-label">Role</label><select name="role" class="form-select"><option value="staff">Staff</option><option value="admin">Admin</option></select></div>
            <div class="col-md-2"><label class="form-label">Password</label><input type="password" name="password" class="form-control" minlength="6" required></div>
            <div class="col-md-2 d-flex align-items-end"><button class="btn btn-primary w-100">Add User</button></div>
        </form>
    </div>

    <div class="card card-body">
        <h2 class="h5 mb-3">Admin Accounts</h2>
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead><tr><th>Username</th><th>Email</th><th>Role</th><th>Created</th><th>New Password</th><th>Actions</th></tr></thead>
                <tbody>
                    <?php foreach($users as $user): ?>
                    <tr>
                        <td><strong><?php echo htmlspecialchars($user['username']); ?></strong><?php if((int)$user['id'] === $currentAdminId): ?><br><span class="badge bg-primary">You</span><?php endif; ?></td>
                        <td>
                            <form method="POST" id="user-form-<?php echo $user['id']; ?>" class="d-none"></form>
                            <input form="user-form-<?php echo $user['id']; ?>" type="hidden" name="action" value="update">
                            <input form="user-form-<?php echo $user['id']; ?>" type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                            <input form="user-form-<?php echo $user['id']; ?>" type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                        </td>
                        <td><select form="user-form-<?php echo $user['id']; ?>" name="role" class="form-select"><option value="staff" <?php echo $user['role'] === 'staff' ? 'selected' : ''; ?>>Staff</option><option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>Admin</option></select></td>
                        <td><?php echo htmlspecialchars($user['created_at']); ?></td>
                        <td><input form="user-form-<?php echo $user['id']; ?>" type="password" name="password" class="form-control" minlength="6" placeholder="Leave unchanged"></td>
                        <td class="admin-table-actions">
                            <button form="user-form-<?php echo $user['id']; ?>" class="btn btn-sm btn-primary">Save</button>
                            <form method="POST" onsubmit="return confirm('Delete this admin user?');" class="d-inline">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                <button class="btn btn-sm btn-outline-danger" <?php echo (int)$user['id'] === $currentAdminId ? 'disabled' : ''; ?>>Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</main></div></div>
<?php include 'includes/admin_footer.php'; ?>
