<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="admin-page-header">
    <h2>Subscriptions</h2>
    <a href="<?= site_url('/admin/subscriptions/create') ?>" class="btn btn-primary">New Subscription</a>
</div>

<form method="GET" action="<?= site_url('/admin/subscriptions') ?>" class="admin-filter-form">
    <input type="text"
           name="search"
           class="form-control"
           placeholder="Search by client or plan..."
           value="<?= esc($search) ?>">
    <select name="status" class="form-control">
        <option value="">All Status</option>
        <option value="active" <?= $status === 'active' ? 'selected' : '' ?>>Active</option>
        <option value="expiring" <?= $status === 'expiring' ? 'selected' : '' ?>>Expiring</option>
        <option value="expired" <?= $status === 'expired' ? 'selected' : '' ?>>Expired</option>
        <option value="cancelled" <?= $status === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
    </select>
    <button type="submit" class="btn btn-primary">Search</button>
    <?php if ($search !== '' || $status !== ''): ?>
        <a href="<?= site_url('/admin/subscriptions') ?>" class="btn btn-secondary">Clear</a>
    <?php endif; ?>
</form>

<div class="admin-table-wrapper">
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Client</th>
                <th>Plan</th>
                <th>Billing Cycle</th>
                <th>Amount</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($subscriptions)): ?>
                <tr>
                    <td colspan="9" class="text-center">No subscriptions found.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($subscriptions as $sub): ?>
                    <tr>
                        <td><?= esc($sub->id) ?></td>
                        <td><?= esc($sub->client_name ?? 'Unknown') ?></td>
                        <td><?= esc($sub->plan_name) ?></td>
                        <td><?= esc(ucfirst($sub->billing_cycle)) ?></td>
                        <td>NPR <?= esc(number_format((float) $sub->amount, 2)) ?></td>
                        <td><?= esc(date('M d, Y', strtotime($sub->start_date))) ?></td>
                        <td><?= $sub->end_date ? esc(date('M d, Y', strtotime($sub->end_date))) : '-' ?></td>
                        <td>
                            <?php
                                $badgeClass = 'secondary';
                                if ($sub->status === 'active') { $badgeClass = 'success'; }
                                elseif ($sub->status === 'expiring') { $badgeClass = 'warning'; }
                                elseif ($sub->status === 'expired') { $badgeClass = 'danger'; }
                            ?>
                            <span class="badge badge-<?= $badgeClass ?>">
                                <?= esc(ucfirst($sub->status)) ?>
                            </span>
                        </td>
                        <td>
                            <a href="<?= site_url("/admin/subscriptions/{$sub->id}") ?>" class="btn btn-sm btn-info">View</a>
                            <a href="<?= site_url("/admin/subscriptions/{$sub->id}/edit") ?>" class="btn btn-sm btn-warning">Edit</a>
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
