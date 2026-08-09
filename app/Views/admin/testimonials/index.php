<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="admin-page-header">
    <h2>Testimonials</h2>
    <a href="<?= site_url('/admin/testimonials/create') ?>" class="btn btn-primary">Add Testimonial</a>
</div>

<form method="GET" action="<?= site_url('/admin/testimonials') ?>" class="admin-filter-form">
    <select name="published" class="form-control">
        <option value="">All Status</option>
        <option value="1" <?= $currentPublished === '1' ? 'selected' : '' ?>>Published</option>
        <option value="0" <?= $currentPublished === '0' ? 'selected' : '' ?>>Unpublished</option>
    </select>
    <button type="submit" class="btn btn-primary">Filter</button>
    <?php if ($currentPublished !== ''): ?>
        <a href="<?= site_url('/admin/testimonials') ?>" class="btn btn-secondary">Clear</a>
    <?php endif; ?>
</form>

<div class="admin-table-wrapper">
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Client Name</th>
                <th>Company</th>
                <th>Rating</th>
                <th>Published</th>
                <th>Sort Order</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($testimonials)): ?>
                <tr>
                    <td colspan="7" class="text-center">No testimonials found.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($testimonials as $testimonial): ?>
                    <tr>
                        <td><?= esc($testimonial->id) ?></td>
                        <td><?= esc($testimonial->client_name) ?></td>
                        <td><?= esc($testimonial->company ?: 'N/A') ?></td>
                        <td>
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <?= $i <= $testimonial->star_rating ? '&#9733;' : '&#9734;' ?>
                            <?php endfor; ?>
                        </td>
                        <td>
                            <a href="<?= site_url("/admin/testimonials/{$testimonial->id}/toggle-publish") ?>"
                               class="badge badge-<?= $testimonial->is_published ? 'success' : 'secondary' ?>"
                               onclick="event.preventDefault(); document.getElementById('toggle-form-<?= $testimonial->id ?>').submit();">
                                <?= $testimonial->is_published ? 'Published' : 'Unpublished' ?>
                            </a>
                            <form id="toggle-form-<?= $testimonial->id ?>" method="POST" action="<?= site_url("/admin/testimonials/{$testimonial->id}/toggle-publish") ?>" style="display:none;">
                                <?= csrf_field() ?>
                            </form>
                        </td>
                        <td>
                            <form method="POST" action="<?= site_url("/admin/testimonials/{$testimonial->id}/reorder") ?>" class="inline-form">
                                <?= csrf_field() ?>
                                <input type="number" name="sort_order" value="<?= esc($testimonial->sort_order) ?>" class="form-control form-control-sm" style="width:70px;display:inline-block;">
                                <button type="submit" class="btn btn-sm btn-primary">Save</button>
                            </form>
                        </td>
                        <td>
                            <a href="<?= site_url("/admin/testimonials/{$testimonial->id}") ?>" class="btn btn-sm btn-info">View</a>
                            <a href="<?= site_url("/admin/testimonials/{$testimonial->id}/edit") ?>" class="btn btn-sm btn-warning">Edit</a>
                            <form method="POST" action="<?= site_url("/admin/testimonials/{$testimonial->id}/delete") ?>" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this testimonial?');">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php if ($pager): ?>
    <div class="admin-pagination">
        <?= $pager->links() ?>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>
