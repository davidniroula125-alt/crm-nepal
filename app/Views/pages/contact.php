<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<section class="section">
    <div class="container" style="max-width:720px;">
        <div class="section__head">
            <h2><?= esc($pageContent['hero']['headline'] ?? 'Contact Us') ?></h2>
            <p><?= esc($pageContent['hero']['subtext'] ?? 'Questions about CRM Software Nepal? Send us a message.') ?></p>
        </div>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <form method="POST" action="<?= site_url('contact-us') ?>" class="form-card">
            <?= csrf_field() ?>
            <div class="form-row">
                <div class="form-group">
                    <label for="name">Full Name *</label>
                    <input type="text" id="name" name="name" required value="<?= old('name') ?>">
                </div>
                <div class="form-group">
                    <label for="company">Company</label>
                    <input type="text" id="company" name="company" value="<?= old('company') ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email" required value="<?= old('email') ?>">
                </div>
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" id="phone" name="phone" value="<?= old('phone') ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="subject">Subject *</label>
                <input type="text" id="subject" name="subject" required value="<?= old('subject') ?>">
            </div>
            <div class="form-group">
                <label for="message">Message *</label>
                <textarea id="message" name="message" rows="5" required><?= old('message') ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-lg">Send Message</button>
        </form>
    </div>
</section>

<?= $this->endSection() ?>
