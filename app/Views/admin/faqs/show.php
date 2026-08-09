<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="admin-page-header">
    <h2>FAQ Details</h2>
    <div>
        <a href="<?= site_url("/admin/faqs/{$faq->id}/edit") ?>" class="btn btn-warning">Edit</a>
        <a href="<?= site_url('/admin/faqs') ?>" class="btn btn-secondary">Back to List</a>
        <form method="POST" action="<?= site_url("/admin/faqs/{$faq->id}/delete") ?>" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this FAQ?');">
            <?= csrf_field() ?>
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-header">
        <h3>FAQ Information</h3>
        <span class="badge badge-<?= $faq->is_published ? 'success' : 'secondary' ?>">
            <?= $faq->is_published ? 'Published' : 'Unpublished' ?>
        </span>
    </div>
    <div class="admin-card-body">
        <div class="info-grid">
            <div class="info-item">
                <label>ID</label>
                <span><?= esc($faq->id) ?></span>
            </div>
            <div class="info-item">
                <label>Category</label>
                <span><span class="badge badge-info"><?= esc($faq->category) ?></span></span>
            </div>
            <div class="info-item">
                <label>Sort Order</label>
                <span><?= esc($faq->sort_order) ?></span>
            </div>
            <div class="info-item">
                <label>Created At</label>
                <span><?= esc(date('M d, Y h:i A', strtotime($faq->created_at))) ?></span>
            </div>
        </div>
        <div class="info-item" style="margin-top:1rem;">
            <label>Question</label>
            <p><?= esc($faq->question) ?></p>
        </div>
        <div class="info-item" style="margin-top:1rem;">
            <label>Answer</label>
            <p style="white-space:pre-wrap;"><?= esc($faq->answer) ?></p>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
