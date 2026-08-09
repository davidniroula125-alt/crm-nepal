<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="admin-page-header">
    <h2>Support Tickets</h2>
    <a href="<?= site_url('/admin/support-tickets/create') ?>" class="btn btn-primary">New Ticket</a>
</div>

<form method="GET" action="<?= site_url('/admin/support-tickets') ?>" class="admin-filter-form">
    <select name="status" class="form-control">
        <option value="">All Status</option>
        <option value="Open" <?= $status === 'Open' ? 'selected' : '' ?>>Open</option>
        <option value="In Progress" <?= $status === 'In Progress' ? 'selected' : '' ?>>In Progress</option>
        <option value="Resolved" <?= $status === 'Resolved' ? 'selected' : '' ?>>Resolved</option>
        <option value="Closed" <?= $status === 'Closed' ? 'selected' : '' ?>>Closed</option>
    </select>
    <button type="submit" class="btn btn-primary">Filter</button>
    <?php if ($status !== ''): ?>
        <a href="<?= site_url('/admin/support-tickets') ?>" class="btn btn-secondary">Clear</a>
    <?php endif; ?>
</form>

<div class="admin-table-wrapper">
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Subject</th>
                <th>Client</th>
                <th>Assigned To</th>
                <th>Status</th>
                <th>Created</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($tickets)): ?>
                <tr>
                    <td colspan="7" class="text-center">No support tickets found.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($tickets as $ticket): ?>
                    <tr>
                        <td><?= esc($ticket->id) ?></td>
                        <td><?= esc($ticket->subject) ?></td>
                        <td><?= esc($clientMap[$ticket->client_id] ?? 'N/A') ?></td>
                        <td><?= esc($userMap[$ticket->assigned_to] ?? 'Unassigned') ?></td>
                        <td>
                            <?php
                            $badgeClass = 'secondary';
                            if ($ticket->status === 'Open') {
                                $badgeClass = 'primary';
                            } elseif ($ticket->status === 'In Progress') {
                                $badgeClass = 'warning';
                            } elseif ($ticket->status === 'Resolved') {
                                $badgeClass = 'success';
                            } elseif ($ticket->status === 'Closed') {
                                $badgeClass = 'secondary';
                            }
                            ?>
                            <span class="badge badge-<?= $badgeClass ?>">
                                <?= esc($ticket->status) ?>
                            </span>
                        </td>
                        <td><?= esc(date('M d, Y', strtotime($ticket->created_at))) ?></td>
                        <td>
                            <a href="<?= site_url("/admin/support-tickets/{$ticket->id}") ?>" class="btn btn-sm btn-info">View</a>
                            <a href="<?= site_url("/admin/support-tickets/{$ticket->id}/edit") ?>" class="btn btn-sm btn-warning">Edit</a>
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
