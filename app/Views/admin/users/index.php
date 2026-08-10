<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="admin-page-header">
    <h2>Users</h2>
    <a href="<?= site_url('/admin/users/create') ?>" class="btn btn-primary">Add User</a>
</div>

<div class="admin-table-wrapper">
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Active</th>
                <th>Last Login</th>
                <th>Created</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($users)): ?>
                <tr>
                    <td colspan="8" class="text-center">No users found.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= esc($user->id) ?></td>
                        <td><?= esc($user->name) ?></td>
                        <td><?= esc($user->email) ?></td>
                        <td>
                            <form method="POST" action="<?= site_url("/admin/users/{$user->id}/role") ?>" style="display:inline-flex;gap:4px;align-items:center;">
                                <?= csrf_field() ?>
                                <select name="role" class="form-control" style="width:auto;padding:4px 8px;font-size:.82rem;" onchange="this.form.submit()">
                                    <option value="admin" <?= $user->role === 'admin' ? 'selected' : '' ?>>Admin</option>
                                    <option value="editor" <?= $user->role === 'editor' ? 'selected' : '' ?>>Editor</option>
                                    <option value="sales" <?= $user->role === 'sales' ? 'selected' : '' ?>>Sales</option>
                                    <option value="support" <?= $user->role === 'support' ? 'selected' : '' ?>>Support</option>
                                    <option value="user" <?= $user->role === 'user' ? 'selected' : '' ?>>User</option>
                                </select>
                            </form>
                        </td>
                        <td>
                            <form method="POST" action="<?= site_url("/admin/users/{$user->id}/toggle-status") ?>" style="display:inline;">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-sm <?= $user->is_active ? 'btn-success' : 'btn-secondary' ?>">
                                    <?= $user->is_active ? 'Active' : 'Inactive' ?>
                                </button>
                            </form>
                        </td>
                        <td><?= $user->last_login_at ? esc(date('M d, Y h:i A', strtotime($user->last_login_at))) : 'Never' ?></td>
                        <td><?= esc(date('M d, Y', strtotime($user->created_at))) ?></td>
                        <td>
                            <a href="<?= site_url("/admin/users/{$user->id}") ?>" class="btn btn-sm btn-info">View</a>
                            <a href="<?= site_url("/admin/users/{$user->id}/edit") ?>" class="btn btn-sm btn-warning">Edit</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php if ($pager): ?>
    <div class="admin-pagination">
        <?= $pager->links() ?>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>
