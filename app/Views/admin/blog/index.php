<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="page-header">
    <h2>Blog Posts</h2>
    <div class="d-flex gap-1">
        <a href="<?= base_url('/admin/blog/categories') ?>" class="btn btn-outline btn-sm">Manage Categories</a>
        <a href="<?= base_url('/admin/blog/create') ?>" class="btn btn-primary">+ New Post</a>
    </div>
</div>

<div class="admin-card mb-3">
    <form method="GET" action="<?= base_url('/admin/blog') ?>" class="d-flex gap-1 align-center" style="flex-wrap:wrap;">
        <div class="search-box">
            <input type="text" name="search" placeholder="Search by title..." value="<?= esc($filters['search'] ?? '') ?>" class="form-control" style="width:240px;">
        </div>

        <select name="status" class="form-control" style="width:160px;">
            <option value="">All Statuses</option>
            <option value="Draft" <?= ($filters['status'] ?? '') === 'Draft' ? 'selected' : '' ?>>Draft</option>
            <option value="Published" <?= ($filters['status'] ?? '') === 'Published' ? 'selected' : '' ?>>Published</option>
        </select>

        <button type="submit" class="btn btn-primary btn-sm">Filter</button>
        <?php if (! empty($filters['search']) || ! empty($filters['status'])): ?>
            <a href="<?= base_url('/admin/blog') ?>" class="btn btn-outline btn-sm">Clear</a>
        <?php endif; ?>
    </form>
</div>

<?php if (empty($posts)): ?>
    <div class="admin-card">
        <div class="empty-state">
            <div class="empty-state-icon">&#9998;</div>
            <h3>No blog posts found</h3>
            <p>There are no blog posts matching your criteria, or no posts have been created yet.</p>
        </div>
    </div>
<?php else: ?>
    <div class="admin-table-wrapper">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Author</th>
                    <th>Status</th>
                    <th>Published At</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($posts as $post): ?>
                    <?php
                    $statusClass = $post->status === 'Published' ? 'badge-success' : 'badge-warning';
                    ?>
                    <tr>
                        <td><?= esc($post->id) ?></td>
                        <td><a href="<?= base_url('/admin/blog/' . $post->id) ?>"><?= esc($post->title) ?></a></td>
                        <td><?= esc($post->category_name ?? '-') ?></td>
                        <td><?= esc($post->author_name ?? '-') ?></td>
                        <td><span class="badge <?= $statusClass ?>"><?= esc($post->status) ?></span></td>
                        <td>
                            <?php if ($post->published_at): ?>
                                <?= esc(date('M d, Y H:i', strtotime($post->published_at))) ?>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                        <td><?= esc(date('M d, Y', strtotime($post->created_at))) ?></td>
                        <td>
                            <div class="table-actions">
                                <a href="<?= base_url('/admin/blog/' . $post->id) ?>" class="btn btn-outline btn-sm">View</a>
                                <a href="<?= base_url('/admin/blog/' . $post->id . '/edit') ?>" class="btn btn-primary btn-sm">Edit</a>
                                <form method="POST" action="<?= base_url('/admin/blog/' . $post->id . '/delete') ?>" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this blog post?');">
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

    <?php
    $lastPage = ceil($total / $perPage);
    if ($lastPage > 1): ?>
        <div class="pagination">
            <?php if ($currentPage > 1): ?>
                <a href="<?= base_url('/admin/blog?' . http_build_query(array_merge($filters, ['page' => $currentPage - 1]))) ?>">&laquo; Prev</a>
            <?php endif; ?>

            <?php
            $start = max(1, $currentPage - 2);
            $end   = min($lastPage, $currentPage + 2);

            for ($i = $start; $i <= $end; $i++):
            ?>
                <?php if ($i === $currentPage): ?>
                    <span class="active"><?= $i ?></span>
                <?php else: ?>
                    <a href="<?= base_url('/admin/blog?' . http_build_query(array_merge($filters, ['page' => $i]))) ?>"><?= $i ?></a>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($currentPage < $lastPage): ?>
                <a href="<?= base_url('/admin/blog?' . http_build_query(array_merge($filters, ['page' => $currentPage + 1]))) ?>">Next &raquo;</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
<?php endif; ?>

<?= $this->endSection() ?>
