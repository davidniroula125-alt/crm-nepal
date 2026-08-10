<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="admin-page-header">
    <h2>Edit User</h2>
    <a href="<?= site_url('/admin/users') ?>" class="btn btn-secondary">Back to List</a>
</div>

<div class="admin-form-wrapper">
    <form method="POST" action="<?= site_url("/admin/users/{$user->id}/update") ?>">
        <?= csrf_field() ?>

        <div class="form-group">
            <label for="name">Name <span class="required">*</span></label>
            <input type="text"
                   id="name"
                   name="name"
                   class="form-control"
                   value="<?= esc(old('name', $user->name)) ?>"
                   required>
        </div>

        <div class="form-group">
            <label for="email">Email <span class="required">*</span></label>
            <input type="email"
                   id="email"
                   name="email"
                   class="form-control"
                   value="<?= esc(old('email', $user->email)) ?>"
                   readonly>
        </div>

        <div class="form-group">
            <label for="role">Role <span class="required">*</span></label>
            <select id="role" name="role" class="form-control" required>
                <option value="admin" <?= old('role', $user->role) === 'admin' ? 'selected' : '' ?>>Admin</option>
                <option value="editor" <?= old('role', $user->role) === 'editor' ? 'selected' : '' ?>>Editor (CMS Content)</option>
                <option value="sales" <?= old('role', $user->role) === 'sales' ? 'selected' : '' ?>>Sales</option>
                <option value="support" <?= old('role', $user->role) === 'support' ? 'selected' : '' ?>>Support</option>
                <option value="user" <?= old('role', $user->role) === 'user' ? 'selected' : '' ?>>User (Complaints)</option>
            </select>
        </div>

        <div class="form-group">
            <label for="is_active">Active <span class="required">*</span></label>
            <select id="is_active" name="is_active" class="form-control" required>
                <option value="1" <?= old('is_active', $user->is_active) == '1' ? 'selected' : '' ?>>Yes</option>
                <option value="0" <?= old('is_active', $user->is_active) == '0' ? 'selected' : '' ?>>No</option>
            </select>
        </div>

        <div class="form-group">
            <label for="password">New Password (leave blank to keep current)</label>
            <input type="password"
                   id="password"
                   name="password"
                   class="form-control"
                   minlength="8">
        </div>

        <div class="form-group">
            <label for="password_confirm">Confirm New Password</label>
            <input type="password"
                   id="password_confirm"
                   name="password_confirm"
                   class="form-control"
                   minlength="8">
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Update User</button>
            <a href="<?= site_url("/admin/users/{$user->id}") ?>" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
