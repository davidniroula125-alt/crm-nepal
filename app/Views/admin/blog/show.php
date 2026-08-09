<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<?php
$statusClass = $post->status === 'Published' ? 'badge-success' : 'badge-warning';
?>

<div class="page-header">
    <h2><?= esc($post->title) ?></h2>
    <div class="d-flex gap-1">
        <?php if ($post->status === 'Draft'): ?>
            <form method="POST" action="<?= base_url('/admin/blog/' . $post->id . '/publish') ?>" style="display:inline;">
                <?= csrf_field() ?>
                <button type="submit" class="btn btn-success">Publish</button>
            </form>
        <?php else: ?>
            <form method="POST" action="<?= base_url('/admin/blog/' . $post->id . '/unpublish') ?>" style="display:inline;">
                <?= csrf_field() ?>
                <button type="submit" class="btn btn-outline">Unpublish</button>
            </form>
        <?php endif; ?>
        <a href="<?= base_url('/admin/blog/' . $post->id . '/edit') ?>" class="btn btn-primary">Edit</a>
        <form method="POST" action="<?= base_url('/admin/blog/' . $post->id . '/delete') ?>" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this blog post?');">
            <?= csrf_field() ?>
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
    </div>
</div>

<div class="admin-card mb-3">
    <div class="admin-card-header">
        <h3>Post Information</h3>
        <span class="badge <?= $statusClass ?>"><?= esc($post->status) ?></span>
    </div>

    <div style="display:grid; grid-template-columns:1fr 1fr; gap:18px;">
        <div>
            <p class="text-muted" style="font-size:.82rem; margin-bottom:2px;">Title</p>
            <p style="font-weight:600;"><?= esc($post->title) ?></p>
        </div>
        <div>
            <p class="text-muted" style="font-size:.82rem; margin-bottom:2px;">Slug</p>
            <p style="font-weight:600;"><?= esc($post->slug) ?></p>
        </div>
        <div>
            <p class="text-muted" style="font-size:.82rem; margin-bottom:2px;">Category</p>
            <p style="font-weight:600;"><?= esc($post->category_name ?? '-') ?></p>
        </div>
        <div>
            <p class="text-muted" style="font-size:.82rem; margin-bottom:2px;">Author</p>
            <p style="font-weight:600;"><?= esc($post->author_name ?? '-') ?></p>
        </div>
        <div>
            <p class="text-muted" style="font-size:.82rem; margin-bottom:2px;">Status</p>
            <p style="font-weight:600;"><?= esc($post->status) ?></p>
        </div>
        <div>
            <p class="text-muted" style="font-size:.82rem; margin-bottom:2px;">Published At</p>
            <p style="font-weight:600;"><?= $post->published_at ? esc(date('M d, Y H:i', strtotime($post->published_at))) : '-' ?></p>
        </div>
        <div>
            <p class="text-muted" style="font-size:.82rem; margin-bottom:2px;">Created</p>
            <p style="font-weight:600;"><?= esc(date('M d, Y H:i', strtotime($post->created_at))) ?></p>
        </div>
        <div>
            <p class="text-muted" style="font-size:.82rem; margin-bottom:2px;">Updated</p>
            <p style="font-weight:600;"><?= esc(date('M d, Y H:i', strtotime($post->updated_at))) ?></p>
        </div>
    </div>

    <?php if ($post->featured_image): ?>
        <div style="margin-top:18px; padding-top:14px; border-top:1px solid var(--color-border);">
            <p class="text-muted" style="font-size:.82rem; margin-bottom:4px;">Featured Image</p>
            <p style="font-weight:600;"><?= esc($post->featured_image) ?></p>
        </div>
    <?php endif; ?>

    <?php if ($post->tags): ?>
        <div style="margin-top:18px; padding-top:14px; border-top:1px solid var(--color-border);">
            <p class="text-muted" style="font-size:.82rem; margin-bottom:4px;">Tags</p>
            <p style="font-weight:600;"><?= esc($post->tags) ?></p>
        </div>
    <?php endif; ?>
</div>

<?php if ($post->excerpt): ?>
    <div class="admin-card mb-3">
        <div class="admin-card-header">
            <h3>Excerpt</h3>
        </div>
        <p style="white-space:pre-wrap;"><?= esc($post->excerpt) ?></p>
    </div>
<?php endif; ?>

<div class="admin-card mb-3">
    <div class="admin-card-header">
        <h3>Body Preview</h3>
    </div>
    <div style="white-space:pre-wrap; line-height:1.7;"><?= esc($post->body) ?></div>
</div>

<?php if ($post->seo_title || $post->meta_description): ?>
    <div class="admin-card">
        <div class="admin-card-header">
            <h3>SEO</h3>
        </div>
        <div style="display:grid; gap:14px;">
            <?php if ($post->seo_title): ?>
                <div>
                    <p class="text-muted" style="font-size:.82rem; margin-bottom:2px;">SEO Title</p>
                    <p style="font-weight:600;"><?= esc($post->seo_title) ?></p>
                </div>
            <?php endif; ?>
            <?php if ($post->meta_description): ?>
                <div>
                    <p class="text-muted" style="font-size:.82rem; margin-bottom:2px;">Meta Description</p>
                    <p style="font-weight:600;"><?= esc($post->meta_description) ?></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>
