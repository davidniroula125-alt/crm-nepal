<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="admin-page-header">
    <h2>User Details</h2>
    <div>
        <a href="<?= site_url("/admin/users/{$user->id}/edit") ?>" class="btn btn-warning">Edit</a>
        <a href="<?= site_url('/admin/users') ?>" class="btn btn-secondary">Back to List</a>
        <form method="POST" action="<?= site_url("/admin/users/{$user->id}/toggle-status") ?>" style="display:inline;">
            <?= csrf_field() ?>
            <button type="submit" class="btn btn-sm <?= $user->is_active ? 'btn-success' : 'btn-secondary' ?>">
                <?= $user->is_active ? 'Deactivate' : 'Activate' ?>
            </button>
        </form>
        <form method="POST" action="<?= site_url("/admin/users/{$user->id}/delete") ?>" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this user?');">
            <?= csrf_field() ?>
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-header">
        <h3>User Information</h3>
        <span class="badge badge-<?= $user->is_active ? 'success' : 'secondary' ?>">
            <?= $user->is_active ? 'Active' : 'Inactive' ?>
        </span>
    </div>
    <div class="admin-card-body">
        <div class="info-grid">
            <div class="info-item">
                <label>ID</label>
                <span><?= esc($user->id) ?></span>
            </div>
            <div class="info-item">
                <label>Name</label>
                <span><?= esc($user->name) ?></span>
            </div>
            <div class="info-item">
                <label>Email</label>
                <span><?= esc($user->email) ?></span>
            </div>
            <div class="info-item">
                <label>Role</label>
                <span>
                    <?php
                    $roleBadge = 'secondary';
                    if ($user->role === 'admin') {
                        $roleBadge = 'danger';
                    } elseif ($user->role === 'sales') {
                        $roleBadge = 'primary';
                    } elseif ($user->role === 'support') {
                        $roleBadge = 'warning';
                    }
                    ?>
                    <span class="badge badge-<?= $roleBadge ?>">
                        <?= esc(ucfirst($user->role)) ?>
                    </span>
                </span>
            </div>
            <div class="info-item">
                <label>Last Login</label>
                <span><?= $user->last_login_at ? esc(date('M d, Y h:i A', strtotime($user->last_login_at))) : 'Never logged in' ?></span>
            </div>
            <div class="info-item">
                <label>Last Login IP</label>
                <span><?= esc($user->last_login_ip ?? 'N/A') ?></span>
            </div>
            <div class="info-item">
                <label>Failed Login Attempts</label>
                <span><?= esc($user->failed_login_attempts ?? 0) ?></span>
            </div>
            <div class="info-item">
                <label>Created At</label>
                <span><?= esc(date('M d, Y h:i A', strtotime($user->created_at))) ?></span>
            </div>
            <div class="info-item">
                <label>Updated At</label>
                <span><?= $user->updated_at ? esc(date('M d, Y h:i A', strtotime($user->updated_at))) : 'N/A' ?></span>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
