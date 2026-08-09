<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="admin-page-header">
    <h2>Add New User</h2>
    <a href="<?= site_url('/admin/users') ?>" class="btn btn-secondary">Back to List</a>
</div>

<div class="admin-form-wrapper">
    <form method="POST" action="<?= site_url('/admin/users') ?>">
        <?= csrf_field() ?>

        <div class="form-group">
            <label for="name">Name <span class="required">*</span></label>
            <input type="text"
                   id="name"
                   name="name"
                   class="form-control"
                   value="<?= esc(old('name')) ?>"
                   required>
        </div>

        <div class="form-group">
            <label for="email">Email <span class="required">*</span></label>
            <input type="email"
                   id="email"
                   name="email"
                   class="form-control"
                   value="<?= esc(old('email')) ?>"
                   required>
        </div>

        <div class="form-group">
            <label for="password">Password <span class="required">*</span></label>
            <input type="password"
                   id="password"
                   name="password"
                   class="form-control"
                   minlength="8"
                   required>
        </div>

        <div class="form-group">
            <label for="password_confirm">Confirm Password <span class="required">*</span></label>
            <input type="password"
                   id="password_confirm"
                   name="password_confirm"
                   class="form-control"
                   minlength="8"
                   required>
        </div>

        <div class="form-group">
            <label for="role">Role <span class="required">*</span></label>
            <select id="role" name="role" class="form-control" required>
                <option value="admin" <?= old('role') === 'admin' ? 'selected' : '' ?>>Admin</option>
                <option value="sales" <?= old('role') === 'sales' ? 'selected' : '' ?>>Sales</option>
                <option value="support" <?= old('role') === 'support' ? 'selected' : '' ?>>Support</option>
            </select>
        </div>

        <div class="form-group">
            <label for="is_active">Active <span class="required">*</span></label>
            <select id="is_active" name="is_active" class="form-control" required>
                <option value="1" <?= old('is_active', '1') === '1' ? 'selected' : '' ?>>Yes</option>
                <option value="0" <?= old('is_active') === '0' ? 'selected' : '' ?>>No</option>
            </select>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Create User</button>
            <a href="<?= site_url('/admin/users') ?>" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
