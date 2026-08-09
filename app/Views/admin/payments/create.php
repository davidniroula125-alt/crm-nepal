<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="admin-page-header">
    <h2>Record Payment</h2>
    <a href="<?= site_url('/admin/payments') ?>" class="btn btn-secondary">Back to List</a>
</div>

<div class="admin-form-wrapper">
    <form method="POST" action="<?= site_url('/admin/payments/store') ?>">
        <?= csrf_field() ?>

        <div class="form-group">
            <label for="client_id">Client <span class="required">*</span></label>
            <select id="client_id" name="client_id" class="form-control" required>
                <option value="">-- Select Client --</option>
                <?php if (! empty($clients)): ?>
                    <?php foreach ($clients as $client): ?>
                        <option value="<?= esc($client->id) ?>"
                            <?= old('client_id') == $client->id ? 'selected' : '' ?>>
                            <?= esc($client->company_name) ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="subscription_id">Subscription ID (optional)</label>
            <input type="number"
                   id="subscription_id"
                   name="subscription_id"
                   class="form-control"
                   value="<?= esc(old('subscription_id')) ?>">
        </div>

        <div class="form-group">
            <label for="amount">Amount (NPR) <span class="required">*</span></label>
            <input type="number"
                   id="amount"
                   name="amount"
                   class="form-control"
                   step="0.01"
                   min="0.01"
                   value="<?= esc(old('amount')) ?>"
                   required>
        </div>

        <div class="form-group">
            <label for="status">Status <span class="required">*</span></label>
            <select id="status" name="status" class="form-control" required>
                <option value="Pending" <?= old('status') === 'Pending' ? 'selected' : '' ?>>Pending</option>
                <option value="Paid" <?= old('status') === 'Paid' ? 'selected' : '' ?>>Paid</option>
                <option value="Partial" <?= old('status') === 'Partial' ? 'selected' : '' ?>>Partial</option>
                <option value="Overdue" <?= old('status') === 'Overdue' ? 'selected' : '' ?>>Overdue</option>
            </select>
        </div>

        <div class="form-group">
            <label for="due_date">Due Date</label>
            <input type="date"
                   id="due_date"
                   name="due_date"
                   class="form-control"
                   value="<?= esc(old('due_date')) ?>">
        </div>

        <div class="form-group">
            <label for="method">Payment Method <span class="required">*</span></label>
            <select id="method" name="method" class="form-control" required>
                <option value="">-- Select Method --</option>
                <option value="Bank Transfer" <?= old('method') === 'Bank Transfer' ? 'selected' : '' ?>>Bank Transfer</option>
                <option value="Cash" <?= old('method') === 'Cash' ? 'selected' : '' ?>>Cash</option>
                <option value="Cheque" <?= old('method') === 'Cheque' ? 'selected' : '' ?>>Cheque</option>
                <option value="eSewa" <?= old('method') === 'eSewa' ? 'selected' : '' ?>>eSewa</option>
                <option value="Khalti" <?= old('method') === 'Khalti' ? 'selected' : '' ?>>Khalti</option>
                <option value="Other" <?= old('method') === 'Other' ? 'selected' : '' ?>>Other</option>
            </select>
        </div>

        <div class="form-group">
            <label for="notes">Notes</label>
            <textarea id="notes"
                      name="notes"
                      class="form-control"
                      rows="3"><?= esc(old('notes')) ?></textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Record Payment</button>
            <a href="<?= site_url('/admin/payments') ?>" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
