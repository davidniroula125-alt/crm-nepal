<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="admin-page-header">
    <h2>Add New Testimonial</h2>
    <a href="<?= site_url('/admin/testimonials') ?>" class="btn btn-secondary">Back to List</a>
</div>

<div class="admin-form-wrapper">
    <form method="POST" action="<?= site_url('/admin/testimonials/store') ?>">
        <?= csrf_field() ?>

        <div class="form-group">
            <label for="client_name">Client Name <span class="required">*</span></label>
            <input type="text"
                   id="client_name"
                   name="client_name"
                   class="form-control"
                   value="<?= esc(old('client_name')) ?>"
                   required>
        </div>

        <div class="form-group">
            <label for="company">Company</label>
            <input type="text"
                   id="company"
                   name="company"
                   class="form-control"
                   value="<?= esc(old('company')) ?>">
        </div>

        <div class="form-group">
            <label for="designation">Designation</label>
            <input type="text"
                   id="designation"
                   name="designation"
                   class="form-control"
                   value="<?= esc(old('designation')) ?>">
        </div>

        <div class="form-group">
            <label for="profile_image">Profile Image Path</label>
            <input type="text"
                   id="profile_image"
                   name="profile_image"
                   class="form-control"
                   value="<?= esc(old('profile_image')) ?>"
                   placeholder="e.g. assets/images/clients/john.jpg">
        </div>

        <div class="form-group">
            <label for="testimonial_text">Testimonial <span class="required">*</span></label>
            <textarea id="testimonial_text"
                      name="testimonial_text"
                      class="form-control"
                      rows="5"
                      required><?= esc(old('testimonial_text')) ?></textarea>
        </div>

        <div class="form-group">
            <label for="star_rating">Star Rating <span class="required">*</span></label>
            <select id="star_rating" name="star_rating" class="form-control" required>
                <option value="">-- Select --</option>
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <option value="<?= $i ?>" <?= old('star_rating') == $i ? 'selected' : '' ?>>
                        <?= $i ?> <?= $i === 1 ? 'Star' : 'Stars' ?>
                    </option>
                <?php endfor; ?>
            </select>
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
            <button type="submit" class="btn btn-primary">Create Testimonial</button>
            <a href="<?= site_url('/admin/testimonials') ?>" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
