<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="page-header">
    <h2>Edit Blog Category</h2>
</div>

<div class="admin-card">
    <form method="POST" action="<?= base_url('/admin/blog/categories/' . $category->id . '/update') ?>" class="admin-form">
        <?= csrf_field() ?>

        <div class="form-group">
            <label class="form-label" for="name">Category Name <span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" class="form-control" value="<?= esc(old('name', $category->name)) ?>" required maxlength="150">
        </div>

        <div class="form-group">
            <label class="form-label" for="slug">Slug <span class="text-danger">*</span></label>
            <input type="text" name="slug" id="slug" class="form-control" value="<?= esc(old('slug', $category->slug)) ?>" required maxlength="150">
        </div>

        <div class="d-flex gap-1 mt-2">
            <button type="submit" class="btn btn-primary">Update Category</button>
            <a href="<?= base_url('/admin/blog/categories') ?>" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>

<script>
document.getElementById('name').addEventListener('input', function() {
    var slugField = document.getElementById('slug');
    slugField.value = this.value
        .toLowerCase()
        .replace(/[^a-z0-9\s-]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-')
        .replace(/^-|-$/g, '');
});
</script>

<?= $this->endSection() ?>
