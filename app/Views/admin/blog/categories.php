<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="page-header">
    <h2>Blog Categories</h2>
    <div class="d-flex gap-1">
        <a href="<?= base_url('/admin/blog/categories/create') ?>" class="btn btn-primary">+ Add Category</a>
    </div>
</div>

<?php if (empty($categories)): ?>
    <div class="admin-card">
        <div class="empty-state">
            <div class="empty-state-icon">&#9733;</div>
            <h3>No categories found</h3>
            <p>No blog categories have been created yet.</p>
        </div>
    </div>
<?php else: ?>
    <div class="admin-table-wrapper">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $category): ?>
                    <tr>
                        <td><?= esc($category->id) ?></td>
                        <td><?= esc($category->name) ?></td>
                        <td><?= esc($category->slug) ?></td>
                        <td>
                            <div class="table-actions">
                                <a href="<?= base_url('/admin/blog/categories/' . $category->id . '/edit') ?>" class="btn btn-primary btn-sm">Edit</a>
                                <form method="POST" action="<?= base_url('/admin/blog/categories/' . $category->id . '/delete') ?>" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>
