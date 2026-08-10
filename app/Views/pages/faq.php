<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<section class="hero" style="text-align:center;">
    <div class="container">
        <h1><?= esc($pageContent['hero']['headline'] ?? 'Frequently Asked Questions') ?></h1>
        <p style="max-width:520px;margin:0 auto 28px;"><?= esc($pageContent['hero']['subtext'] ?? 'Find answers to common questions.') ?></p>
        <div class="hero__ctas" style="justify-content:center;">
            <a href="<?= site_url('contact-us') ?>" class="btn btn-primary btn-lg">Contact Us</a>
        </div>
    </div>
</section>

<section class="section" style="padding-top:32px;">
    <div class="container" style="max-width:780px;">
        <?php if (! empty($grouped)): ?>
            <?php if (count($categories) > 1): ?>
            <div class="faq-tabs" style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:32px;justify-content:center;">
                <button class="faq-tab is-active" data-cat="all" style="padding:8px 18px;border-radius:20px;border:1px solid var(--color-border);background:#fff;font-size:14px;font-weight:500;cursor:pointer;">All</button>
                <?php foreach ($categories as $cat): ?>
                <button class="faq-tab" data-cat="<?= esc($cat) ?>" style="padding:8px 18px;border-radius:20px;border:1px solid var(--color-border);background:#fff;font-size:14px;font-weight:500;cursor:pointer;"><?= esc($cat) ?></button>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <?php foreach ($grouped as $cat => $catFaqs): ?>
            <div class="faq-category" data-category="<?= esc($cat) ?>">
                <?php if (count($categories) > 1): ?>
                <h3 style="font-size:20px;color:var(--color-primary-dark);margin-bottom:16px;"><?= esc($cat) ?></h3>
                <?php endif; ?>
                <?php foreach ($catFaqs as $faq): ?>
                <div class="faq-item" style="border:1px solid var(--color-border);border-radius:var(--radius-md);margin-bottom:12px;overflow:hidden;">
                    <button class="faq-question" style="width:100%;text-align:left;padding:16px 20px;background:#fff;border:none;font-size:15px;font-weight:600;color:var(--color-primary-dark);cursor:pointer;display:flex;justify-content:space-between;align-items:center;">
                        <span><?= esc($faq->question) ?></span>
                        <span style="font-size:20px;color:var(--color-text-muted);transition:.2s;flex-shrink:0;margin-left:12px;">+</span>
                    </button>
                    <div class="faq-answer" style="display:none;padding:0 20px 16px;font-size:14px;color:var(--color-text-muted);line-height:1.7;">
                        <?= esc($faq->answer) ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div style="text-align:center;padding:40px 0;">
                <p style="color:var(--color-text-muted);margin-bottom:24px;">FAQ content is being managed from the admin panel. Check back soon.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<section class="section section-alt">
    <div class="cta-band">
        <h2>Still have questions?</h2>
        <p>Our team is here to help. Reach out and we'll get back to you within 24 hours.</p>
        <a href="<?= site_url('contact-us') ?>" class="btn btn-outline btn-lg">Contact Us</a>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.faq-question').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var item = this.closest('.faq-item');
            var answer = item.querySelector('.faq-answer');
            var icon = this.querySelector('span:last-child');
            var open = answer.style.display === 'block';
            answer.style.display = open ? 'none' : 'block';
            icon.textContent = open ? '+' : '\u2212';
        });
    });

    var tabs = document.querySelectorAll('.faq-tab');
    var cats = document.querySelectorAll('.faq-category');
    tabs.forEach(function(tab) {
        tab.addEventListener('click', function() {
            tabs.forEach(function(t) { t.classList.remove('is-active'); t.style.background = '#fff'; t.style.color = 'var(--color-text)'; });
            this.classList.add('is-active');
            this.style.background = 'var(--color-primary)';
            this.style.color = '#fff';
            var cat = this.dataset.cat;
            cats.forEach(function(c) {
                c.style.display = (cat === 'all' || c.dataset.category === cat) ? 'block' : 'none';
            });
        });
    });
    if (tabs.length > 0) {
        tabs[0].style.background = 'var(--color-primary)';
        tabs[0].style.color = '#fff';
    }
});
</script>

<?= $this->endSection() ?>
