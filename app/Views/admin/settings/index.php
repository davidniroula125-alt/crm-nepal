<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<div class="page-header">
    <h1>Settings</h1>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
<?php endif; ?>
<?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger">
        <?php foreach (session()->getFlashdata('errors') as $err): ?>
            <?= esc($err) ?><br>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<div class="card" style="max-width:600px;">
    <h3 style="margin-bottom:20px;">Edit Profile</h3>
    <form method="post" action="<?= site_url('admin/settings/update') ?>">
        <?= csrf_field() ?>

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="<?= esc(old('name', $user->name)) ?>" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="email">Email (readonly)</label>
            <input type="email" id="email" value="<?= esc($user->email) ?>" class="form-control" readonly>
        </div>

        <div class="form-group">
            <label for="role">Role</label>
            <input type="text" value="<?= esc(ucfirst($user->role)) ?>" class="form-control" readonly>
        </div>

        <hr style="margin:20px 0;border-color:var(--color-border);">

        <h4 style="margin-bottom:16px;">Change Password</h4>

        <div class="form-group">
            <label for="new_password">New Password</label>
            <input type="password" name="new_password" id="new_password" class="form-control" minlength="8">
            <small style="color:var(--color-text-muted);">Leave blank to keep current password.</small>
        </div>

        <div class="form-group">
            <label for="confirm_password">Confirm New Password</label>
            <input type="password" name="confirm_password" id="confirm_password" class="form-control">
        </div>

        <div style="margin-top:20px;">
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
