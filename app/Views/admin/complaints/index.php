<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="admin-page-header">
    <h2>Complaints</h2>
    <div>
        <a href="<?= site_url('/admin/complaints') ?>" class="btn <?= !$status ? 'btn-primary' : 'btn-secondary' ?>">All</a>
        <a href="<?= site_url('/admin/complaints?status=Open') ?>" class="btn <?= $status === 'Open' ? 'btn-warning' : 'btn-secondary' ?>">Open</a>
        <a href="<?= site_url('/admin/complaints?status=In Progress') ?>" class="btn <?= $status === 'In Progress' ? 'btn-info' : 'btn-secondary' ?>">In Progress</a>
        <a href="<?= site_url('/admin/complaints?status=Replied') ?>" class="btn <?= $status === 'Replied' ? 'btn-success' : 'btn-secondary' ?>">Replied</a>
        <a href="<?= site_url('/admin/complaints?status=Closed') ?>" class="btn <?= $status === 'Closed' ? 'btn-secondary' : 'btn-secondary' ?>">Closed</a>
    </div>
</div>

<div class="admin-table-wrapper">
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Subject</th>
                <th>Status</th>
                <th>Created</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($complaints)): ?>
                <tr><td colspan="6" class="text-center">No complaints found.</td></tr>
            <?php else: ?>
                <?php foreach ($complaints as $c): ?>
                    <tr>
                        <td><?= esc($c->id) ?></td>
                        <td>
                            <?= esc($c->user_name) ?>
                            <br><small style="color:#888"><?= esc($c->user_email) ?></small>
                        </td>
                        <td><?= esc($c->subject) ?></td>
                        <td>
                            <?php
                            $badge = 'secondary';
                            if ($c->status === 'Open') $badge = 'warning';
                            elseif ($c->status === 'In Progress') $badge = 'info';
                            elseif ($c->status === 'Replied') $badge = 'success';
                            ?>
                            <span class="badge badge-<?= $badge ?>"><?= esc($c->status) ?></span>
                        </td>
                        <td><?= esc(date('M d, Y', strtotime($c->created_at))) ?></td>
                        <td>
                            <a href="<?= site_url("/admin/complaints/{$c->id}") ?>" class="btn btn-sm btn-info">View</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
