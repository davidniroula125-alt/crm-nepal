<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<div class="settings-page">
    <div class="settings-header">
        <h2>Settings</h2>
        <p class="text-muted">Manage your profile and account settings</p>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <div class="settings-grid">
        <!-- Profile Card -->
        <div class="settings-card">
            <div class="card-header-bar">
                <span class="card-icon">&#128100;</span>
                <h3>Profile Information</h3>
            </div>
            <form method="post" action="<?= site_url('admin/settings/update') ?>">
                <?= csrf_field() ?>

                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" name="name" id="name" value="<?= esc(old('name', $user->name)) ?>" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" value="<?= esc($user->email) ?>" class="form-control" readonly>
                    <small class="form-help">Email cannot be changed.</small>
                </div>

                <div class="form-group">
                    <label for="role">Account Role</label>
                    <input type="text" value="<?= esc(ucfirst($user->role)) ?>" class="form-control" readonly>
                </div>

                <div class="form-divider"></div>

                <h4 class="section-subtitle">&#128274; Change Password</h4>

                <div class="form-group">
                    <label for="new_password">New Password</label>
                    <input type="password" name="new_password" id="new_password" class="form-control" minlength="8" placeholder="Leave blank to keep current password">
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirm New Password</label>
                    <input type="password" name="confirm_password" id="confirm_password" class="form-control">
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">&#10003; Save Changes</button>
                </div>
            </form>
        </div>

        <!-- Quick Links Card -->
        <div class="settings-card">
            <div class="card-header-bar">
                <span class="card-icon">&#128279;</span>
                <h3>Quick Links</h3>
            </div>
            <div class="quick-links">
                <a href="<?= site_url('/admin/site') ?>" class="quick-link-item">
                    <span class="ql-icon">&#127968;</span>
                    <div>
                        <strong>Site Content</strong>
                        <small>Edit all public website content</small>
                    </div>
                    <span class="ql-arrow">&#8250;</span>
                </a>
                <a href="<?= site_url('/admin/users') ?>" class="quick-link-item">
                    <span class="ql-icon">&#128101;</span>
                    <div>
                        <strong>User Management</strong>
                        <small>Manage user accounts and roles</small>
                    </div>
                    <span class="ql-arrow">&#8250;</span>
                </a>
                <a href="<?= site_url('/admin/logs') ?>" class="quick-link-item">
                    <span class="ql-icon">&#128196;</span>
                    <div>
                        <strong>Activity Logs</strong>
                        <small>View all system activity</small>
                    </div>
                    <span class="ql-arrow">&#8250;</span>
                </a>
                <a href="<?= site_url('/') ?>" class="quick-link-item" target="_blank">
                    <span class="ql-icon">&#127760;</span>
                    <div>
                        <strong>View Website</strong>
                        <small>Preview your public site</small>
                    </div>
                    <span class="ql-arrow">&#8599;</span>
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.settings-page { padding: 0; }
.settings-header { margin-bottom: 24px; }
.settings-header h2 { font-family: var(--font-heading); font-size: 1.5rem; margin-bottom: 4px; }
.text-muted { color: var(--color-text-muted); font-size: .88rem; }

.settings-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }
@media (max-width: 900px) { .settings-grid { grid-template-columns: 1fr; } }

.settings-card {
    background: var(--color-card-bg, #fff);
    border: 1px solid var(--color-border);
    border-radius: 12px;
    padding: 0;
    overflow: hidden;
}
.card-header-bar {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 18px 24px;
    border-bottom: 2px solid var(--color-border);
}
.card-icon { font-size: 1.2rem; }
.card-header-bar h3 { font-family: var(--font-heading); font-size: 1.05rem; margin: 0; }

.settings-card form { padding: 24px; }

.form-group { margin-bottom: 16px; }
.form-group label {
    display: block;
    font-weight: 600;
    font-size: .85rem;
    margin-bottom: 5px;
    color: var(--color-text);
}
.form-control {
    width: 100%;
    padding: 10px 14px;
    border: 1px solid var(--color-border);
    border-radius: 8px;
    font-size: .9rem;
    font-family: var(--font-body);
    transition: border-color .2s, box-shadow .2s;
    background: var(--color-card-bg, #fff);
    color: var(--color-text);
}
.form-control:focus {
    outline: none;
    border-color: var(--color-primary);
    box-shadow: 0 0 0 3px rgba(var(--color-primary-rgb, 15,110,99), .1);
}
.form-control[readonly] { background: var(--color-bg, #f4f7fb); opacity: .7; }
.form-help { display: block; margin-top: 4px; color: var(--color-text-muted); font-size: .78rem; }

.form-divider { height: 1px; background: var(--color-border); margin: 20px 0; }
.section-subtitle { font-size: .92rem; font-weight: 700; margin-bottom: 16px; }
.form-actions { margin-top: 20px; }
.btn { padding: 10px 24px; border: none; border-radius: 8px; font-weight: 600; font-size: .9rem; cursor: pointer; transition: all .2s; font-family: var(--font); display: inline-flex; align-items: center; gap: 6px; }
.btn-primary { background: linear-gradient(135deg, var(--color-primary), var(--color-primary-dark, #0a4a3f)); color: #fff; box-shadow: 0 2px 8px rgba(var(--color-primary-rgb, 15,110,99), .2); }
.btn-primary:hover { transform: translateY(-1px); box-shadow: 0 4px 14px rgba(var(--color-primary-rgb, 15,110,99), .3); }

.quick-links { padding: 8px; }
.quick-link-item {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 14px 16px;
    border-radius: 10px;
    text-decoration: none;
    color: var(--color-text);
    transition: background .2s;
}
.quick-link-item:hover { background: var(--color-primary-light); }
.ql-icon { font-size: 1.3rem; width: 32px; text-align: center; flex-shrink: 0; }
.quick-link-item div { flex: 1; }
.quick-link-item strong { display: block; font-size: .9rem; }
.quick-link-item small { color: var(--color-text-muted); font-size: .78rem; }
.ql-arrow { font-size: 1.2rem; color: var(--color-text-muted); }

.alert { padding: 12px 16px; border-radius: 8px; font-size: .9rem; margin-bottom: 16px; }
.alert-success { background: #D4EDDA; color: #155724; border: 1px solid #C3E6CB; }
.alert-danger { background: #F8D7DA; color: #721C24; border: 1px solid #F5C6CB; }
</style>

<?= $this->endSection() ?>
