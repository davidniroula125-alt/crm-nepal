<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="page-header">
    <h2>Create Blog Post</h2>
</div>

<div class="admin-card">
    <form method="POST" action="<?= base_url('/admin/blog/store') ?>" class="admin-form">
        <?= csrf_field() ?>

        <div class="form-group">
            <label class="form-label" for="title">Title <span class="text-danger">*</span></label>
            <input type="text" name="title" id="title" class="form-control" value="<?= esc(old('title')) ?>" required maxlength="255">
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="category_id">Category <span class="text-danger">*</span></label>
                <select name="category_id" id="category_id" class="form-control" required>
                    <option value="">Select Category</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= esc($category->id) ?>" <?= old('category_id') == $category->id ? 'selected' : '' ?>>
                            <?= esc($category->name) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label" for="status">Status</label>
                <select name="status" id="status" class="form-control">
                    <?php foreach ($statuses as $status): ?>
                        <option value="<?= esc($status) ?>" <?= old('status', 'Draft') === $status ? 'selected' : '' ?>>
                            <?= esc($status) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="featured_image">Featured Image Path</label>
            <input type="text" name="featured_image" id="featured_image" class="form-control" value="<?= esc(old('featured_image')) ?>" placeholder="e.g. uploads/blog/image.jpg" maxlength="255">
        </div>

        <div class="form-group">
            <label class="form-label" for="excerpt">Excerpt</label>
            <textarea name="excerpt" id="excerpt" class="form-control" rows="3"><?= esc(old('excerpt')) ?></textarea>
        </div>

        <div class="form-group">
            <label class="form-label" for="body">Body</label>
            <textarea name="body" id="body" class="form-control" rows="15"><?= esc(old('body')) ?></textarea>
        </div>

        <div class="form-group">
            <label class="form-label" for="tags">Tags (comma-separated)</label>
            <input type="text" name="tags" id="tags" class="form-control" value="<?= esc(old('tags')) ?>" placeholder="e.g. news, updates, nepal" maxlength="500">
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="seo_title">SEO Title</label>
                <input type="text" name="seo_title" id="seo_title" class="form-control" value="<?= esc(old('seo_title')) ?>" maxlength="255">
            </div>

            <div class="form-group">
                <label class="form-label" for="meta_description">Meta Description</label>
                <input type="text" name="meta_description" id="meta_description" class="form-control" value="<?= esc(old('meta_description')) ?>" maxlength="500">
            </div>
        </div>

        <div class="d-flex gap-1 mt-2">
            <button type="submit" class="btn btn-primary">Create Post</button>
            <a href="<?= base_url('/admin/blog') ?>" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
