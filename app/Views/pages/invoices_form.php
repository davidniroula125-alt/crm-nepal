<?= view('layout/header', ['title' => $invoice ? 'Edit Invoice' : 'Create Invoice']) ?>

<div class="form-container">
    <form method="POST" action="<?= $invoice ? '/invoices/update/'.$invoice['id'] : '/invoices/store' ?>" class="form-card">
        <div class="form-grid">
            <div class="form-group">
                <label for="invoice_number">Invoice Number</label>
                <input type="text" id="invoice_number" name="invoice_number" value="<?= esc($invoice['invoice_number'] ?? $invoiceNumber) ?>" required>
            </div>
            <div class="form-group">
                <label for="contact_id">Contact</label>
                <select id="contact_id" name="contact_id">
                    <option value="">Select Contact</option>
                    <?php foreach ($contacts as $contact): ?>
                    <option value="<?= $contact['id'] ?>" <?= ($invoice['contact_id'] ?? '') == $contact['id'] ? 'selected' : '' ?>><?= esc($contact['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="amount">Amount (NPR)</label>
                <input type="number" id="amount" name="amount" step="0.01" value="<?= $invoice['amount'] ?? '0' ?>" required>
            </div>
            <div class="form-group">
                <label for="payment_method">Payment Method</label>
                <select id="payment_method" name="payment_method">
                    <option value="bank_transfer" <?= ($invoice['payment_method'] ?? '') === 'bank_transfer' ? 'selected' : '' ?>>Bank Transfer</option>
                    <option value="esewa" <?= ($invoice['payment_method'] ?? '') === 'esewa' ? 'selected' : '' ?>>eSewa</option>
                    <option value="khalti" <?= ($invoice['payment_method'] ?? '') === 'khalti' ? 'selected' : '' ?>>Khalti</option>
                    <option value="cash" <?= ($invoice['payment_method'] ?? '') === 'cash' ? 'selected' : '' ?>>Cash</option>
                </select>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status">
                    <option value="pending" <?= ($invoice['status'] ?? '') === 'pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="paid" <?= ($invoice['status'] ?? '') === 'paid' ? 'selected' : '' ?>>Paid</option>
                    <option value="overdue" <?= ($invoice['status'] ?? '') === 'overdue' ? 'selected' : '' ?>>Overdue</option>
                </select>
            </div>
            <div class="form-group">
                <label for="due_date">Due Date</label>
                <input type="date" id="due_date" name="due_date" value="<?= $invoice['due_date'] ?? date('Y-m-d', strtotime('+30 days')) ?>" required>
            </div>
        </div>
        <div class="form-actions">
            <a href="/invoices" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary"><?= $invoice ? 'Update Invoice' : 'Create Invoice' ?></button>
        </div>
    </form>
</div>

<?= view('layout/footer') ?>
