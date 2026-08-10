<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<section class="section">
    <div class="container">
        <div class="section__head">
            <h2><?= esc($pageContent['hero']['headline'] ?? 'Request a Demo') ?></h2>
            <p><?= esc($pageContent['hero']['subtext'] ?? 'Tell us a bit about your agency and we\'ll set up a walkthrough.') ?></p>
        </div>

        <div class="form-card">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-error">
                    <?php foreach (session()->getFlashdata('errors') as $err): ?>
                        <?= esc($err) ?><br>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form method="post" action="<?= site_url('request-a-demo') ?>">
                <?= csrf_field() ?>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Full Name *</label>
                        <input type="text" name="full_name" value="<?= old('full_name') ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Company / Agency Name *</label>
                        <input type="text" name="company_name" value="<?= old('company_name') ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Email *</label>
                        <input type="email" name="email" value="<?= old('email') ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Phone *</label>
                        <input type="text" name="phone" value="<?= old('phone') ?>" required>
                    </div>
                    <div class="form-group full">
                        <label>Address</label>
                        <input type="text" name="address" value="<?= old('address') ?>">
                    </div>
                    <div class="form-group">
                        <label>Number of Employees</label>
                        <select name="employee_count">
                            <option value="">Select</option>
                            <option>1–5</option>
                            <option>6–20</option>
                            <option>21–50</option>
                            <option>50+</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Current Software (if any)</label>
                        <input type="text" name="current_software" value="<?= old('current_software') ?>">
                    </div>
                    <div class="form-group">
                        <label>Business Type *</label>
                        <select name="business_type" required>
                            <option value="">Select</option>
                            <option>Travel Agency</option>
                            <option>Trekking Agency</option>
                            <option>Tour Operator</option>
                            <option>DMC</option>
                            <option>Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Preferred Demo Date</label>
                        <input type="date" name="preferred_date" value="<?= old('preferred_date') ?>">
                    </div>
                    <div class="form-group">
                        <label>Preferred Demo Time</label>
                        <input type="time" name="preferred_time" value="<?= old('preferred_time') ?>">
                    </div>
                    <div class="form-group full">
                        <label>Message</label>
                        <textarea name="message" rows="4"><?= old('message') ?></textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-lg" style="width:100%;">Request Demo</button>
            </form>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
