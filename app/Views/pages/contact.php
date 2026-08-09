<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<section class="section">
    <div class="container">
        <div class="section__head">
            <h2>Contact Us</h2>
            <p>Questions about CRM Software Nepal? Send us a message.</p>
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

            <form method="post" action="<?= site_url('contact-us') ?>">
                <?= csrf_field() ?>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Name *</label>
                        <input type="text" name="name" value="<?= old('name') ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Company</label>
                        <input type="text" name="company" value="<?= old('company') ?>">
                    </div>
                    <div class="form-group">
                        <label>Email *</label>
                        <input type="email" name="email" value="<?= old('email') ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" name="phone" value="<?= old('phone') ?>">
                    </div>
                    <div class="form-group full">
                        <label>Subject *</label>
                        <input type="text" name="subject" value="<?= old('subject') ?>" required>
                    </div>
                    <div class="form-group full">
                        <label>Message *</label>
                        <textarea name="message" rows="5" required><?= old('message') ?></textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-lg" style="width:100%;">Send Message</button>
            </form>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
