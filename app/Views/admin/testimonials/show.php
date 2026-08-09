<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="admin-page-header">
    <h2>Testimonial Details</h2>
    <div>
        <a href="<?= site_url("/admin/testimonials/{$testimonial->id}/edit") ?>" class="btn btn-warning">Edit</a>
        <a href="<?= site_url('/admin/testimonials') ?>" class="btn btn-secondary">Back to List</a>
        <form method="POST" action="<?= site_url("/admin/testimonials/{$testimonial->id}/delete") ?>" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this testimonial?');">
            <?= csrf_field() ?>
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-header">
        <h3>Testimonial Information</h3>
        <span class="badge badge-<?= $testimonial->is_published ? 'success' : 'secondary' ?>">
            <?= $testimonial->is_published ? 'Published' : 'Unpublished' ?>
        </span>
    </div>
    <div class="admin-card-body">
        <div class="info-grid">
            <div class="info-item">
                <label>ID</label>
                <span><?= esc($testimonial->id) ?></span>
            </div>
            <div class="info-item">
                <label>Client Name</label>
                <span><?= esc($testimonial->client_name) ?></span>
            </div>
            <div class="info-item">
                <label>Company</label>
                <span><?= esc($testimonial->company ?: 'N/A') ?></span>
            </div>
            <div class="info-item">
                <label>Designation</label>
                <span><?= esc($testimonial->designation ?: 'N/A') ?></span>
            </div>
            <div class="info-item">
                <label>Profile Image</label>
                <span><?= esc($testimonial->profile_image ?: 'N/A') ?></span>
            </div>
            <div class="info-item">
                <label>Star Rating</label>
                <span>
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <?= $i <= $testimonial->star_rating ? '&#9733;' : '&#9734;' ?>
                    <?php endfor; ?>
                    (<?= esc($testimonial->star_rating) ?>/5)
                </span>
            </div>
            <div class="info-item">
                <label>Sort Order</label>
                <span><?= esc($testimonial->sort_order) ?></span>
            </div>
            <div class="info-item">
                <label>Created At</label>
                <span><?= esc(date('M d, Y h:i A', strtotime($testimonial->created_at))) ?></span>
            </div>
        </div>
        <div class="info-item" style="margin-top:1rem;">
            <label>Testimonial Text</label>
            <p style="white-space:pre-wrap;"><?= esc($testimonial->testimonial_text) ?></p>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
