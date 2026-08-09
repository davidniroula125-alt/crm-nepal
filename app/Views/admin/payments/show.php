<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="admin-page-header">
    <h2>Payment Details</h2>
    <div>
        <a href="<?= site_url("/admin/payments/{$payment->id}/edit") ?>" class="btn btn-warning">Edit</a>
        <a href="<?= site_url('/admin/payments') ?>" class="btn btn-secondary">Back to List</a>
        <?php if ($payment->status !== 'Paid'): ?>
            <form method="POST" action="<?= site_url("/admin/payments/{$payment->id}/mark-paid") ?>" style="display:inline;">
                <?= csrf_field() ?>
                <button type="submit" class="btn btn-success" onclick="return confirm('Mark this payment as Paid?');">Mark as Paid</button>
            </form>
        <?php endif; ?>
        <form method="POST" action="<?= site_url("/admin/payments/{$payment->id}/delete") ?>" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this payment and its invoice?');">
            <?= csrf_field() ?>
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-header">
        <h3>Payment Information</h3>
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
        <span class="badge badge-<?= $badgeClass ?>"><?= esc($payment->status) ?></span>
    </div>
    <div class="admin-card-body">
        <div class="info-grid">
            <div class="info-item">
                <label>ID</label>
                <span><?= esc($payment->id) ?></span>
            </div>
            <div class="info-item">
                <label>Client</label>
                <span><?= esc($payment->company_name ?? 'N/A') ?></span>
            </div>
            <div class="info-item">
                <label>Contact</label>
                <span><?= esc($payment->contact_name ?? 'N/A') ?></span>
            </div>
            <div class="info-item">
                <label>Email</label>
                <span><?= esc($payment->email ?? 'N/A') ?></span>
            </div>
            <div class="info-item">
                <label>Amount</label>
                <span>NPR <?= esc(number_format($payment->amount, 2)) ?></span>
            </div>
            <div class="info-item">
                <label>Payment Method</label>
                <span><?= esc($payment->method ?? 'N/A') ?></span>
            </div>
            <div class="info-item">
                <label>Due Date</label>
                <span><?= $payment->due_date ? esc(date('M d, Y', strtotime($payment->due_date))) : 'N/A' ?></span>
            </div>
            <div class="info-item">
                <label>Paid At</label>
                <span><?= $payment->paid_at ? esc(date('M d, Y h:i A', strtotime($payment->paid_at))) : 'N/A' ?></span>
            </div>
            <div class="info-item">
                <label>Subscription ID</label>
                <span><?= $payment->subscription_id ? esc($payment->subscription_id) : 'None' ?></span>
            </div>
            <div class="info-item">
                <label>Notes</label>
                <span><?= esc($payment->notes ?: 'N/A') ?></span>
            </div>
            <div class="info-item">
                <label>Created At</label>
                <span><?= esc(date('M d, Y h:i A', strtotime($payment->created_at))) ?></span>
            </div>
        </div>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-header">
        <h3>Invoice Details</h3>
    </div>
    <div class="admin-card-body">
        <?php if ($invoice): ?>
            <div class="info-grid">
                <div class="info-item">
                    <label>Invoice ID</label>
                    <span><?= esc($invoice->id) ?></span>
                </div>
                <div class="info-item">
                    <label>Invoice Number</label>
                    <span><?= esc($invoice->invoice_number) ?></span>
                </div>
                <div class="info-item">
                    <label>Issued At</label>
                    <span><?= esc(date('M d, Y h:i A', strtotime($invoice->issued_at))) ?></span>
                </div>
                <div class="info-item">
                    <label>PDF</label>
                    <span><?= $invoice->pdf_path ? '<a href="' . esc($invoice->pdf_path) . '" target="_blank">Download</a>' : 'Not generated' ?></span>
                </div>
            </div>
        <?php else: ?>
            <p class="text-muted">No invoice found for this payment.</p>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
