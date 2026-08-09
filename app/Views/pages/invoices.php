<?= view('layout/header', ['title' => 'Invoices']) ?>

<div class="stats-grid stats-3">
    <div class="stat-card stat-green">
        <div class="stat-info">
            <span class="stat-value"><?= format_currency($totalPaid) ?></span>
            <span class="stat-label">Total Paid</span>
        </div>
    </div>
    <div class="stat-card stat-orange">
        <div class="stat-info">
            <span class="stat-value"><?= format_currency($totalPending) ?></span>
            <span class="stat-label">Pending</span>
        </div>
    </div>
    <div class="stat-card stat-red">
        <div class="stat-info">
            <span class="stat-value"><?= format_currency($totalOverdue) ?></span>
            <span class="stat-label">Overdue</span>
        </div>
    </div>
</div>

<div class="page-actions">
    <a href="/invoices/create" class="btn btn-primary">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Create Invoice
    </a>
</div>

<div class="table-container">
    <table class="data-table">
        <thead>
            <tr>
                <th>Invoice #</th>
                <th>Amount</th>
                <th>VAT</th>
                <th>Total</th>
                <th>Payment</th>
                <th>Status</th>
                <th>Due Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($invoices)): ?>
            <tr><td colspan="8" class="empty-state">No invoices found</td></tr>
            <?php else: ?>
            <?php foreach ($invoices as $invoice): ?>
            <tr>
                <td><strong><?= esc($invoice['invoice_number']) ?></strong></td>
                <td><?= format_currency($invoice['amount']) ?></td>
                <td><?= format_currency($invoice['vat_amount']) ?></td>
                <td><?= format_currency($invoice['amount'] + $invoice['vat_amount']) ?></td>
                <td><?= esc(ucfirst(str_replace('_', ' ', $invoice['payment_method']))) ?></td>
                <td><?= status_badge($invoice['status']) ?></td>
                <td><?= date('M d, Y', strtotime($invoice['due_date'])) ?></td>
                <td>
                    <div class="action-buttons">
                        <a href="/invoices/edit/<?= $invoice['id'] ?>" class="btn-icon" title="Edit">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        </a>
                        <a href="/invoices/delete/<?= $invoice['id'] ?>" class="btn-icon btn-danger" onclick="return confirm('Delete this invoice?')" title="Delete">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                        </a>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= view('layout/footer') ?>
