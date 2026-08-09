<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="admin-page-header">
    <h2>Add New FAQ</h2>
    <a href="<?= site_url('/admin/faqs') ?>" class="btn btn-secondary">Back to List</a>
</div>

<div class="admin-form-wrapper">
    <form method="POST" action="<?= site_url('/admin/faqs/store') ?>">
        <?= csrf_field() ?>

        <div class="form-group">
            <label for="category">Category <span class="required">*</span></label>
            <select id="category" name="category" class="form-control" required>
                <option value="">-- Select Category --</option>
                <?php
                $categories = ['General', 'Pricing', 'Features', 'Security', 'Hosting', 'Data', 'Support', 'Subscription', 'Account', 'Implementation'];
                foreach ($categories as $cat):
                ?>
                    <option value="<?= esc($cat) ?>" <?= old('category') === $cat ? 'selected' : '' ?>><?= esc($cat) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="question">Question <span class="required">*</span></label>
            <input type="text"
                   id="question"
                   name="question"
                   class="form-control"
                   value="<?= esc(old('question')) ?>"
                   maxlength="500"
                   required>
        </div>

        <div class="form-group">
            <label for="answer">Answer <span class="required">*</span></label>
            <textarea id="answer"
                      name="answer"
                      class="form-control"
                      rows="8"
                      required><?= esc(old('answer')) ?></textarea>
        </div>

        <div class="form-group">
            <label for="sort_order">Sort Order</label>
            <input type="number"
                   id="sort_order"
                   name="sort_order"
                   class="form-control"
                   value="<?= esc(old('sort_order', '0')) ?>">
        </div>

        <div class="form-group">
            <label>
                <input type="checkbox" name="is_published" value="1" <?= old('is_published') ? 'checked' : '' ?>>
                Published
            </label>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Create FAQ</button>
            <a href="<?= site_url('/admin/faqs') ?>" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
