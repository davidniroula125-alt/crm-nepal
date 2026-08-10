<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="admin-page-header">
    <h2>Activity Logs</h2>
</div>

<div class="admin-table-wrapper">
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Activity</th>
                <th>IP Address</th>
                <th>Time</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($logs)): ?>
                <tr><td colspan="5" class="text-center">No activity logs found.</td></tr>
            <?php else: ?>
                <?php foreach ($logs as $log): ?>
                    <tr>
                        <td><?= esc($log->id) ?></td>
                        <td><?= esc($log->user_name ?? 'System') ?></td>
                        <td><?= esc($log->action) ?></td>
                        <td><?= esc($log->ip_address ?? 'N/A') ?></td>
                        <td><?= esc(date('M d, Y h:i A', strtotime($log->created_at))) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php if (isset($pager) && $pager->getTotalPages() > 1): ?>
<div class="admin-pagination">
    <?= $pager->links() ?>
</div>
<?php endif; ?>

<?= $this->endSection() ?>
