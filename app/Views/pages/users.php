<?= view('layout/header', ['title' => 'User Management']) ?>

<div class="page-actions">
    <button class="btn btn-primary" onclick="openUserModal()">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Add User
    </button>
</div>

<div class="section-card">
    <h3>Users</h3>
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Language</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $u): ?>
                <tr>
                    <td><strong><?= esc($u['name']) ?></strong></td>
                    <td><?= esc($u['email']) ?></td>
                    <td>
                        <form method="POST" action="/users/updateRole/<?= $u['id'] ?>" style="display:inline;">
                            <select name="role" onchange="this.form.submit()" class="status-select">
                                <option value="super_admin" <?= $u['role'] === 'super_admin' ? 'selected' : '' ?>>Super Admin</option>
                                <option value="admin" <?= $u['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                                <option value="team_member" <?= $u['role'] === 'team_member' ? 'selected' : '' ?>>Team Member</option>
                                <option value="user" <?= $u['role'] === 'user' ? 'selected' : '' ?>>User</option>
                            </select>
                        </form>
                    </td>
                    <td><?= esc(strtoupper($u['language'])) ?></td>
                    <td><?= date('M d, Y', strtotime($u['created_at'])) ?></td>
                    <td>
                        <?php if ($u['id'] != session()->get('user_id')): ?>
                        <form method="POST" action="/users/delete/<?= $u['id'] ?>" style="display:inline;">
                            <button type="submit" class="btn-icon btn-danger" onclick="return confirm('Delete this user?')">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                            </button>
                        </form>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="section-card">
    <h3>Active Sessions</h3>
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr><th>User ID</th><th>IP Address</th><th>Logged In</th></tr>
            </thead>
            <tbody>
                <?php if (empty($activeSessions)): ?>
                <tr><td colspan="3" class="empty-state">No active sessions</td></tr>
                <?php else: ?>
                <?php foreach ($activeSessions as $session): ?>
                <tr>
                    <td><?= $session['user_id'] ?></td>
                    <td><?= esc($session['ip_address']) ?></td>
                    <td><?= date('M d, Y H:i', strtotime($session['logged_in_at'])) ?></td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="section-card">
    <h3>Recent Login Attempts</h3>
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr><th>Email</th><th>IP Address</th><th>Time</th></tr>
            </thead>
            <tbody>
                <?php if (empty($recentAttempts)): ?>
                <tr><td colspan="3" class="empty-state">No login attempts</td></tr>
                <?php else: ?>
                <?php foreach ($recentAttempts as $attempt): ?>
                <tr>
                    <td><?= esc($attempt['email']) ?></td>
                    <td><?= esc($attempt['ip_address']) ?></td>
                    <td><?= date('M d, Y H:i', strtotime($attempt['attempted_at'])) ?></td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- User Modal -->
<div id="userModal" class="modal" style="display:none;">
    <div class="modal-overlay" onclick="closeModal('userModal')"></div>
    <div class="modal-content">
        <div class="modal-header">
            <h3>Add User</h3>
            <button class="modal-close" onclick="closeModal('userModal')">&times;</button>
        </div>
        <div class="modal-body">
            <form method="POST" action="/users/store">
                <div class="form-group">
                    <label>Name *</label>
                    <input type="text" name="name" required>
                </div>
                <div class="form-group">
                    <label>Email *</label>
                    <input type="email" name="email" required>
                </div>
                <div class="form-group">
                    <label>Password *</label>
                    <input type="password" name="password" required minlength="6">
                </div>
                <div class="form-group">
                    <label>Role</label>
                    <select name="role">
                        <option value="user">User</option>
                        <option value="team_member">Team Member</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('userModal')">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openUserModal() {
    document.getElementById('userModal').style.display = 'flex';
}
</script>

<?= view('layout/footer') ?>
