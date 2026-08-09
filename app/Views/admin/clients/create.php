<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="admin-page-header">
    <h2>Add New Client</h2>
    <a href="<?= site_url('/admin/clients') ?>" class="btn btn-secondary">Back to List</a>
</div>

<div class="admin-form-wrapper">
    <form method="POST" action="<?= site_url('/admin/clients') ?>">
        <?= csrf_field() ?>

        <div class="form-group">
            <label for="company_name">Company Name <span class="required">*</span></label>
            <input type="text"
                   id="company_name"
                   name="company_name"
                   class="form-control"
                   value="<?= esc(old('company_name')) ?>"
                   required>
        </div>

        <div class="form-group">
            <label for="contact_name">Contact Name <span class="required">*</span></label>
            <input type="text"
                   id="contact_name"
                   name="contact_name"
                   class="form-control"
                   value="<?= esc(old('contact_name')) ?>"
                   required>
        </div>

        <div class="form-group">
            <label for="email">Email <span class="required">*</span></label>
            <input type="email"
                   id="email"
                   name="email"
                   class="form-control"
                   value="<?= esc(old('email')) ?>"
                   required>
        </div>

        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text"
                   id="phone"
                   name="phone"
                   class="form-control"
                   value="<?= esc(old('phone')) ?>">
        </div>

        <div class="form-group">
            <label for="address">Address</label>
            <textarea id="address"
                      name="address"
                      class="form-control"
                      rows="3"><?= esc(old('address')) ?></textarea>
        </div>

        <div class="form-group">
            <label for="lead_id">Linked Lead (optional)</label>
            <select id="lead_id" name="lead_id" class="form-control">
                <option value="">-- None --</option>
                <?php if (! empty($leads)): ?>
                    <?php foreach ($leads as $lead): ?>
                        <option value="<?= esc($lead->id) ?>"
                            <?= old('lead_id') == $lead->id ? 'selected' : '' ?>>
                            <?= esc($lead->first_name . ' ' . $lead->last_name . ' (' . $lead->email . ')') ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="status">Status <span class="required">*</span></label>
            <select id="status" name="status" class="form-control" required>
                <option value="active" <?= old('status') === 'active' ? 'selected' : '' ?>>Active</option>
                <option value="inactive" <?= old('status') === 'inactive' ? 'selected' : '' ?>>Inactive</option>
            </select>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Create Client</button>
            <a href="<?= site_url('/admin/clients') ?>" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
