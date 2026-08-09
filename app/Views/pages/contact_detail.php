<?= view('layout/header', ['title' => 'Contact Detail']) ?>

<div class="detail-card">
    <div class="detail-header">
        <h2><?= esc($contact['name']) ?></h2>
        <div class="detail-actions">
            <a href="/contacts/edit/<?= $contact['id'] ?>" class="btn btn-secondary">Edit</a>
            <a href="/contacts" class="btn btn-primary">Back to Contacts</a>
        </div>
    </div>
    <div class="detail-grid">
        <div class="detail-item">
            <label>Company</label>
            <p><?= esc($contact['company_name']) ?></p>
        </div>
        <div class="detail-item">
            <label>Email</label>
            <p><?= esc($contact['email']) ?></p>
        </div>
        <div class="detail-item">
            <label>Phone</label>
            <p><?= esc($contact['phone']) ?></p>
        </div>
        <div class="detail-item">
            <label>Status</label>
            <p><?= status_badge($contact['status']) ?></p>
        </div>
        <div class="detail-item">
            <label>Value</label>
            <p><strong><?= format_currency($contact['value']) ?></strong></p>
        </div>
        <div class="detail-item">
            <label>Last Contact</label>
            <p><?= date('M d, Y', strtotime($contact['last_contact_date'])) ?></p>
        </div>
    </div>
</div>

<?= view('layout/footer') ?>
