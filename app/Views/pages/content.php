<?= view('layout/header', ['title' => 'Content Manager']) ?>

<div class="page-actions">
    <div class="filter-form">
        <select onchange="window.location.href='/content?section='+this.value" class="filter-select">
            <?php foreach (['features', 'local_features', 'faq', 'pricing', 'hero'] as $sec): ?>
            <option value="<?= $sec ?>" <?= ($currentSection ?? '') === $sec ? 'selected' : '' ?>><?= ucfirst(str_replace('_', ' ', $sec)) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <a href="/content/create?section=<?= $currentSection ?? 'features' ?>" class="btn btn-primary">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Add Content
    </a>
</div>

<div class="table-container">
    <table class="data-table">
        <thead>
            <tr>
                <th>Order</th>
                <th>Key</th>
                <th>Title</th>
                <th>Description</th>
                <th>Icon</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($content)): ?>
            <tr><td colspan="7" class="empty-state">No content found</td></tr>
            <?php else: ?>
            <?php foreach ($content as $item): ?>
            <tr>
                <td><?= $item['sort_order'] ?></td>
                <td><code><?= esc($item['key_name']) ?></code></td>
                <td><strong><?= esc($item['title']) ?></strong></td>
                <td><?= esc(substr($item['description'], 0, 80)) ?>...</td>
                <td><?= esc($item['icon']) ?></td>
                <td>
                    <form method="POST" action="/content/toggle/<?= $item['id'] ?>" style="display:inline;">
                        <button type="submit" class="badge <?= $item['is_active'] ? 'badge-green' : 'badge-gray' ?>">
                            <?= $item['is_active'] ? 'Active' : 'Inactive' ?>
                        </button>
                    </form>
                </td>
                <td>
                    <div class="action-buttons">
                        <a href="/content/edit/<?= $item['id'] ?>" class="btn-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        </a>
                        <a href="/content/delete/<?= $item['id'] ?>" class="btn-icon btn-danger" onclick="return confirm('Delete?')">
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
