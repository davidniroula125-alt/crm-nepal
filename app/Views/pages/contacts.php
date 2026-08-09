<?= view('layout/header', ['title' => 'Contacts']) ?>

<div class="page-actions">
    <div class="search-filter">
        <form method="GET" action="/contacts" class="filter-form">
            <div class="search-box">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input type="text" name="search" value="<?= esc($search ?? '') ?>" placeholder="Search contacts...">
            </div>
            <select name="status" class="filter-select">
                <option value="">All Status</option>
                <option value="lead" <?= ($status ?? '') === 'lead' ? 'selected' : '' ?>>Lead</option>
                <option value="prospect" <?= ($status ?? '') === 'prospect' ? 'selected' : '' ?>>Prospect</option>
                <option value="customer" <?= ($status ?? '') === 'customer' ? 'selected' : '' ?>>Customer</option>
                <option value="inactive" <?= ($status ?? '') === 'inactive' ? 'selected' : '' ?>>Inactive</option>
            </select>
            <button type="submit" class="btn btn-secondary">Filter</button>
        </form>
    </div>
    <a href="/contacts/create" class="btn btn-primary">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Add Contact
    </a>
</div>

<div class="table-container">
    <table class="data-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Company</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Status</th>
                <th>Value</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($contacts)): ?>
            <tr><td colspan="7" class="empty-state">No contacts found</td></tr>
            <?php else: ?>
            <?php foreach ($contacts as $contact): ?>
            <tr>
                <td><strong><?= esc($contact['name']) ?></strong></td>
                <td><?= esc($contact['company_name']) ?></td>
                <td><?= esc($contact['email']) ?></td>
                <td><?= esc($contact['phone']) ?></td>
                <td><?= status_badge($contact['status']) ?></td>
                <td><?= format_currency($contact['value']) ?></td>
                <td>
                    <div class="action-buttons">
                        <a href="/contacts/edit/<?= $contact['id'] ?>" class="btn-icon" title="Edit">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        </a>
                        <a href="/contacts/delete/<?= $contact['id'] ?>" class="btn-icon btn-danger" onclick="return confirm('Delete this contact?')" title="Delete">
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

<?php if ($totalPages > 1): ?>
<div class="pagination">
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
    <a href="?page=<?= $i ?>&search=<?= esc($search ?? '') ?>&status=<?= esc($status ?? '') ?>" class="page-link <?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
    <?php endfor; ?>
</div>
<?php endif; ?>

<!-- Add/Edit Modal -->
<div id="contactModal" class="modal" style="display:none;">
    <div class="modal-overlay" onclick="closeModal('contactModal')"></div>
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalTitle">Contact</h3>
            <button class="modal-close" onclick="closeModal('contactModal')">&times;</button>
        </div>
        <div class="modal-body" id="modalBody"></div>
    </div>
</div>

<?= view('layout/footer') ?>
