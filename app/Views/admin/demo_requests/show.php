<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="admin-page-header">
    <h2>Demo Request #<?= esc($demoRequest->id) ?></h2>
    <a href="<?= base_url('/admin/demo-requests') ?>" class="btn btn-secondary">Back to List</a>
</div>

<div class="admin-card">
    <div class="card-row">
        <div class="card-label">Full Name</div>
        <div class="card-value"><?= esc($demoRequest->full_name) ?></div>
    </div>
    <div class="card-row">
        <div class="card-label">Company Name</div>
        <div class="card-value"><?= esc($demoRequest->company_name) ?></div>
    </div>
    <div class="card-row">
        <div class="card-label">Email</div>
        <div class="card-value"><?= esc($demoRequest->email) ?></div>
    </div>
    <div class="card-row">
        <div class="card-label">Phone</div>
        <div class="card-value"><?= esc($demoRequest->phone) ?></div>
    </div>
    <div class="card-row">
        <div class="card-label">Address</div>
        <div class="card-value"><?= esc($demoRequest->address ?? 'N/A') ?></div>
    </div>
    <div class="card-row">
        <div class="card-label">Employee Count</div>
        <div class="card-value"><?= esc($demoRequest->employee_count ?? 'N/A') ?></div>
    </div>
    <div class="card-row">
        <div class="card-label">Current Software</div>
        <div class="card-value"><?= esc($demoRequest->current_software ?? 'N/A') ?></div>
    </div>
    <div class="card-row">
        <div class="card-label">Business Type</div>
        <div class="card-value"><?= esc($demoRequest->business_type) ?></div>
    </div>
    <div class="card-row">
        <div class="card-label">Preferred Date</div>
        <div class="card-value"><?= esc($demoRequest->preferred_date) ?></div>
    </div>
    <div class="card-row">
        <div class="card-label">Preferred Time</div>
        <div class="card-value"><?= esc($demoRequest->preferred_time ?? 'N/A') ?></div>
    </div>
    <div class="card-row">
        <div class="card-label">Status</div>
        <div class="card-value">
            <?php
            $badgeClass = 'badge-pending';
            if ($demoRequest->status === 'Scheduled') $badgeClass = 'badge-scheduled';
            elseif ($demoRequest->status === 'Completed') $badgeClass = 'badge-completed';
            elseif ($demoRequest->status === 'Cancelled') $badgeClass = 'badge-cancelled';
            ?>
            <span class="badge <?= $badgeClass ?>"><?= esc($demoRequest->status) ?></span>
        </div>
    </div>
    <div class="card-row">
        <div class="card-label">Message</div>
        <div class="card-value card-message"><?= nl2br(esc($demoRequest->message ?? 'N/A')) ?></div>
    </div>
    <div class="card-row">
        <div class="card-label">Created At</div>
        <div class="card-value"><?= esc($demoRequest->created_at) ?></div>
    </div>
</div>

<div class="admin-actions">
    <h3>Change Status</h3>
    <form method="POST" action="<?= base_url('/admin/demo-requests/' . $demoRequest->id . '/status') ?>" class="status-form">
        <?= csrf_field() ?>
        <select name="status">
            <option value="Pending" <?= $demoRequest->status === 'Pending' ? 'selected' : '' ?>>Pending</option>
            <option value="Scheduled" <?= $demoRequest->status === 'Scheduled' ? 'selected' : '' ?>>Scheduled</option>
            <option value="Completed" <?= $demoRequest->status === 'Completed' ? 'selected' : '' ?>>Completed</option>
            <option value="Cancelled" <?= $demoRequest->status === 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
        </select>
        <button type="submit" class="btn btn-primary">Update Status</button>
    </form>

    <form method="POST" action="<?= base_url('/admin/demo-requests/' . $demoRequest->id . '/delete') ?>" onsubmit="return confirm('Are you sure you want to delete this demo request?');" class="delete-form">
        <?= csrf_field() ?>
        <button type="submit" class="btn btn-danger">Delete</button>
    </form>
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
    .badge-pending { background: #ffc107; color: #333; }
    .badge-scheduled { background: #007bff; color: #fff; }
    .badge-completed { background: #28a745; color: #fff; }
    .badge-cancelled { background: #dc3545; color: #fff; }
    .admin-actions { margin-top: 25px; display: flex; gap: 20px; align-items: center; }
    .admin-actions h3 { margin: 0; }
    .status-form { display: flex; gap: 10px; align-items: center; }
    .status-form select { padding: 6px 12px; border: 1px solid #ccc; border-radius: 4px; }
    .btn { padding: 6px 14px; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; font-size: 14px; display: inline-block; }
    .btn-primary { background: #007bff; color: #fff; }
    .btn-secondary { background: #6c757d; color: #fff; }
    .btn-danger { background: #dc3545; color: #fff; }
    .delete-form { margin-left: auto; }
</style>

<?= $this->endSection() ?>
