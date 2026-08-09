<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="admin-page-header">
    <h2>Payments</h2>
    <a href="<?= site_url('/admin/payments/create') ?>" class="btn btn-primary">Record Payment</a>
</div>

<form method="GET" action="<?= site_url('/admin/payments') ?>" class="admin-filter-form">
    <input type="text"
           name="search"
           class="form-control"
           placeholder="Search by client name..."
           value="<?= esc($search) ?>">
    <select name="status" class="form-control">
        <option value="">All Status</option>
        <option value="Paid" <?= $status === 'Paid' ? 'selected' : '' ?>>Paid</option>
        <option value="Pending" <?= $status === 'Pending' ? 'selected' : '' ?>>Pending</option>
        <option value="Overdue" <?= $status === 'Overdue' ? 'selected' : '' ?>>Overdue</option>
        <option value="Partial" <?= $status === 'Partial' ? 'selected' : '' ?>>Partial</option>
    </select>
    <button type="submit" class="btn btn-primary">Search</button>
    <?php if ($search !== '' || $status !== ''): ?>
        <a href="<?= site_url('/admin/payments') ?>" class="btn btn-secondary">Clear</a>
    <?php endif; ?>
</form>

<div class="admin-table-wrapper">
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Client</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Method</th>
                <th>Due Date</th>
                <th>Paid At</th>
                <th>Invoice #</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($payments)): ?>
                <tr>
                    <td colspan="9" class="text-center">No payments found.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($payments as $payment): ?>
                    <?php
                    $badgeClass = 'secondary';
                    if ($payment->status === 'Paid') {
                        $badgeClass = 'success';
                    } elseif ($payment->status === 'Pending') {
                        $badgeClass = 'warning';
                    } elseif ($payment->status === 'Overdue') {
                        $badgeClass = 'danger';
                    } elseif ($payment->status === 'Partial') {
                        $badgeClass = 'orange';
                    }
                    ?>
                    <tr>
                        <td><?= esc($payment->id) ?></td>
                        <td><?= esc($payment->company_name ?? 'N/A') ?></td>
                        <td>NPR <?= esc(number_format($payment->amount, 2)) ?></td>
                        <td>
                            <span class="badge badge-<?= $badgeClass ?>">
                                <?= esc($payment->status) ?>
                            </span>
                        </td>
                        <td><?= esc($payment->method ?? 'N/A') ?></td>
                        <td><?= $payment->due_date ? esc(date('M d, Y', strtotime($payment->due_date))) : 'N/A' ?></td>
                        <td><?= $payment->paid_at ? esc(date('M d, Y', strtotime($payment->paid_at))) : 'N/A' ?></td>
                        <td>
                            <?php
                            $inv = $invoiceMap[$payment->id] ?? null;
                            echo $inv ? esc($inv->invoice_number) : 'N/A';
                            ?>
                        </td>
                        <td>
                            <a href="<?= site_url("/admin/payments/{$payment->id}") ?>" class="btn btn-sm btn-info">View</a>
                            <a href="<?= site_url("/admin/payments/{$payment->id}/edit") ?>" class="btn btn-sm btn-warning">Edit</a>
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
