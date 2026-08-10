<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="admin-page-header">
    <h2>Complaint #<?= esc($complaint->id) ?></h2>
    <a href="<?= base_url('/admin/complaints') ?>" class="btn btn-secondary">Back to List</a>
</div>

<div class="admin-card">
    <div class="card-row">
        <div class="card-label">User</div>
        <div class="card-value"><?= esc($complaint->user_name) ?> (<?= esc($complaint->user_email) ?>)</div>
    </div>
    <div class="card-row">
        <div class="card-label">Subject</div>
        <div class="card-value"><?= esc($complaint->subject) ?></div>
    </div>
    <div class="card-row">
        <div class="card-label">Status</div>
        <div class="card-value">
            <?php
            $badgeClass = 'badge-secondary';
            if ($complaint->status === 'Open') $badgeClass = 'badge-warning';
            elseif ($complaint->status === 'In Progress') $badgeClass = 'badge-info';
            elseif ($complaint->status === 'Replied') $badgeClass = 'badge-success';
            ?>
            <span class="badge <?= $badgeClass ?>"><?= esc($complaint->status) ?></span>
        </div>
    </div>
    <div class="card-row">
        <div class="card-label">Message</div>
        <div class="card-value card-message"><?= nl2br(esc($complaint->message)) ?></div>
    </div>
    <?php if ($complaint->admin_reply): ?>
    <div class="card-row">
        <div class="card-label">Your Reply</div>
        <div class="card-value card-message" style="background:#e8f5e9;"><?= nl2br(esc($complaint->admin_reply)) ?></div>
    </div>
    <?php endif; ?>
    <div class="card-row">
        <div class="card-label">Created</div>
        <div class="card-value"><?= esc($complaint->created_at) ?></div>
    </div>
</div>

<div class="admin-actions">
    <div>
        <h3>Reply</h3>
        <form method="POST" action="<?= base_url("/admin/complaints/{$complaint->id}/reply") ?>" style="margin-top:10px;">
            <?= csrf_field() ?>
            <textarea name="admin_reply" rows="4" cols="60" placeholder="Type your reply..." required style="width:100%;max-width:600px;padding:10px;border:1px solid #ccc;border-radius:4px;font-family:inherit;"><?= esc($complaint->admin_reply ?? '') ?></textarea>
            <div style="margin-top:10px;">
                <button type="submit" class="btn btn-primary">Send Reply</button>
            </div>
        </form>
    </div>

    <div>
        <h3>Status</h3>
        <form method="POST" action="<?= base_url("/admin/complaints/{$complaint->id}/status") ?>" style="margin-top:10px;display:flex;gap:10px;align-items:center;">
            <?= csrf_field() ?>
            <select name="status">
                <option value="Open" <?= $complaint->status === 'Open' ? 'selected' : '' ?>>Open</option>
                <option value="In Progress" <?= $complaint->status === 'In Progress' ? 'selected' : '' ?>>In Progress</option>
                <option value="Replied" <?= $complaint->status === 'Replied' ? 'selected' : '' ?>>Replied</option>
                <option value="Closed" <?= $complaint->status === 'Closed' ? 'selected' : '' ?>>Closed</option>
            </select>
            <button type="submit" class="btn btn-warning">Update</button>
        </form>
    </div>
</div>

<style>
    .admin-page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
    .admin-card { background: #fff; border: 1px solid #e0e0e0; border-radius: 6px; padding: 20px; }
    .card-row { display: flex; padding: 10px 0; border-bottom: 1px solid #f0f0f0; }
    .card-row:last-child { border-bottom: none; }
    .card-label { width: 200px; font-weight: 600; color: #555; }
    .card-value { flex: 1; }
    .card-message { white-space: pre-wrap; background: #f8f9fa; padding: 10px; border-radius: 4px; }
    .badge { padding: 2px 8px; border-radius: 12px; font-size: 14px; }
    .badge-warning { background: #ffc107; color: #333; }
    .badge-info { background: #17a2b8; color: #fff; }
    .badge-success { background: #28a745; color: #fff; }
    .badge-secondary { background: #6c757d; color: #fff; }
    .admin-actions { margin-top: 25px; display: flex; gap: 40px; align-items: flex-start; }
    .admin-actions h3 { margin: 0; }
    .btn { padding: 6px 14px; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; font-size: 14px; display: inline-block; }
    .btn-primary { background: #007bff; color: #fff; }
    .btn-secondary { background: #6c757d; color: #fff; }
    .btn-warning { background: #ffc107; color: #333; }
</style>

<?= $this->endSection() ?>
