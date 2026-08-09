<?= view('layout/header', ['title' => $contact ? 'Edit Contact' : 'Create Contact']) ?>

<div class="form-container">
    <form method="POST" action="<?= $contact ? '/contacts/update/'.$contact['id'] : '/contacts/store' ?>" class="form-card">
        <div class="form-grid">
            <div class="form-group">
                <label for="name">Full Name *</label>
                <input type="text" id="name" name="name" value="<?= esc($contact['name'] ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label for="company_name">Company Name</label>
                <input type="text" id="company_name" name="company_name" value="<?= esc($contact['company_name'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?= esc($contact['email'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" id="phone" name="phone" value="<?= esc($contact['phone'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status">
                    <option value="lead" <?= ($contact['status'] ?? '') === 'lead' ? 'selected' : '' ?>>Lead</option>
                    <option value="prospect" <?= ($contact['status'] ?? '') === 'prospect' ? 'selected' : '' ?>>Prospect</option>
                    <option value="customer" <?= ($contact['status'] ?? '') === 'customer' ? 'selected' : '' ?>>Customer</option>
                    <option value="inactive" <?= ($contact['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>
            <div class="form-group">
                <label for="value">Value (NPR)</label>
                <input type="number" id="value" name="value" step="0.01" value="<?= $contact['value'] ?? '0' ?>">
            </div>
            <div class="form-group">
                <label for="last_contact_date">Last Contact Date</label>
                <input type="date" id="last_contact_date" name="last_contact_date" value="<?= $contact['last_contact_date'] ?? date('Y-m-d') ?>">
            </div>
        </div>
        <div class="form-actions">
            <a href="/contacts" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary"><?= $contact ? 'Update Contact' : 'Create Contact' ?></button>
        </div>
    </form>
</div>

<?= view('layout/footer') ?>
