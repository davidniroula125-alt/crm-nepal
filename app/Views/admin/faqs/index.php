<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="admin-page-header">
    <h2>FAQs</h2>
    <a href="<?= site_url('/admin/faqs/create') ?>" class="btn btn-primary">Add FAQ</a>
</div>

<form method="GET" action="<?= site_url('/admin/faqs') ?>" class="admin-filter-form">
    <select name="category" class="form-control">
        <option value="">All Categories</option>
        <?php
        $categories = ['General', 'Pricing', 'Features', 'Security', 'Hosting', 'Data', 'Support', 'Subscription', 'Account', 'Implementation'];
        foreach ($categories as $cat):
        ?>
            <option value="<?= esc($cat) ?>" <?= $currentCategory === $cat ? 'selected' : '' ?>><?= esc($cat) ?></option>
        <?php endforeach; ?>
    </select>
    <button type="submit" class="btn btn-primary">Filter</button>
    <?php if ($currentCategory !== ''): ?>
        <a href="<?= site_url('/admin/faqs') ?>" class="btn btn-secondary">Clear</a>
    <?php endif; ?>
</form>

<div class="admin-table-wrapper">
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Category</th>
                <th>Question</th>
                <th>Published</th>
                <th>Sort Order</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($faqs)): ?>
                <tr>
                    <td colspan="6" class="text-center">No FAQs found.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($faqs as $faq): ?>
                    <tr>
                        <td><?= esc($faq->id) ?></td>
                        <td><span class="badge badge-info"><?= esc($faq->category) ?></span></td>
                        <td><?= esc(mb_strimwidth($faq->question, 0, 80, '...')) ?></td>
                        <td>
                            <a href="<?= site_url("/admin/faqs/{$faq->id}/toggle-publish") ?>"
                               class="badge badge-<?= $faq->is_published ? 'success' : 'secondary' ?>"
                               onclick="event.preventDefault(); document.getElementById('toggle-form-<?= $faq->id ?>').submit();">
                                <?= $faq->is_published ? 'Published' : 'Unpublished' ?>
                            </a>
                            <form id="toggle-form-<?= $faq->id ?>" method="POST" action="<?= site_url("/admin/faqs/{$faq->id}/toggle-publish") ?>" style="display:none;">
                                <?= csrf_field() ?>
                            </form>
                        </td>
                        <td><?= esc($faq->sort_order) ?></td>
                        <td>
                            <a href="<?= site_url("/admin/faqs/{$faq->id}") ?>" class="btn btn-sm btn-info">View</a>
                            <a href="<?= site_url("/admin/faqs/{$faq->id}/edit") ?>" class="btn btn-sm btn-warning">Edit</a>
                            <form method="POST" action="<?= site_url("/admin/faqs/{$faq->id}/delete") ?>" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this FAQ?');">
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
