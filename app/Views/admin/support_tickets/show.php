<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="admin-page-header">
    <h2>Support Ticket Details</h2>
    <div>
        <a href="<?= site_url("/admin/support-tickets/{$ticket->id}/edit") ?>" class="btn btn-warning">Edit</a>
        <a href="<?= site_url('/admin/support-tickets') ?>" class="btn btn-secondary">Back to List</a>
        <form method="POST" action="<?= site_url("/admin/support-tickets/{$ticket->id}/delete") ?>" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this ticket?');">
            <?= csrf_field() ?>
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-header">
        <h3>Ticket Information</h3>
        <?php
        $badgeClass = 'secondary';
        if ($ticket->status === 'Open') {
            $badgeClass = 'primary';
        } elseif ($ticket->status === 'In Progress') {
            $badgeClass = 'warning';
        } elseif ($ticket->status === 'Resolved') {
            $badgeClass = 'success';
        }
        ?>
        <span class="badge badge-<?= $badgeClass ?>">
            <?= esc($ticket->status) ?>
        </span>
    </div>
    <div class="admin-card-body">
        <div class="info-grid">
            <div class="info-item">
                <label>ID</label>
                <span><?= esc($ticket->id) ?></span>
            </div>
            <div class="info-item">
                <label>Subject</label>
                <span><?= esc($ticket->subject) ?></span>
            </div>
            <div class="info-item">
                <label>Client</label>
                <span><?= $client ? esc($client->company_name) : 'N/A' ?></span>
            </div>
            <div class="info-item">
                <label>Assigned To</label>
                <span><?= $assignee ? esc($assignee->name) : 'Unassigned' ?></span>
            </div>
            <div class="info-item full-width">
                <label>Description</label>
                <span><?= nl2br(esc($ticket->description)) ?></span>
            </div>
            <div class="info-item">
                <label>Created At</label>
                <span><?= esc(date('M d, Y h:i A', strtotime($ticket->created_at))) ?></span>
            </div>
            <div class="info-item">
                <label>Updated At</label>
                <span><?= $ticket->updated_at ? esc(date('M d, Y h:i A', strtotime($ticket->updated_at))) : 'N/A' ?></span>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
