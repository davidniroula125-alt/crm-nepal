<?= view('layout/header', ['title' => $item ? 'Edit Content' : 'Create Content']) ?>

<div class="form-container">
    <form method="POST" action="<?= $item ? '/content/update/'.$item['id'] : '/content/store' ?>" class="form-card">
        <div class="form-grid">
            <div class="form-group">
                <label>Section</label>
                <select name="section" required>
                    <?php foreach (['features', 'local_features', 'faq', 'pricing', 'hero'] as $sec): ?>
                    <option value="<?= $sec ?>" <?= ($item['section'] ?? $section ?? '') === $sec ? 'selected' : '' ?>><?= ucfirst(str_replace('_', ' ', $sec)) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Key Name</label>
                <input type="text" name="key_name" value="<?= esc($item['key_name'] ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label>Title</label>
                <input type="text" name="title" value="<?= esc($item['title'] ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label>Icon (emoji or text)</label>
                <input type="text" name="icon" value="<?= esc($item['icon'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label>Sort Order</label>
                <input type="number" name="sort_order" value="<?= $item['sort_order'] ?? '0' ?>">
            </div>
            <div class="form-group full-width">
                <label>Description</label>
                <textarea name="description" rows="4" required><?= esc($item['description'] ?? '') ?></textarea>
            </div>
            <?php if ($item): ?>
            <div class="form-group">
                <label>Active</label>
                <select name="is_active">
                    <option value="1" <?= $item['is_active'] ? 'selected' : '' ?>>Yes</option>
                    <option value="0" <?= !$item['is_active'] ? 'selected' : '' ?>>No</option>
                </select>
            </div>
            <?php endif; ?>
        </div>
        <div class="form-actions">
            <a href="/content?section=<?= $item['section'] ?? $section ?? 'features' ?>" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary"><?= $item ? 'Update' : 'Create' ?></button>
        </div>
    </form>
</div>

<?= view('layout/footer') ?>
