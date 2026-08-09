<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<!-- HERO -->
<section class="hero">
    <div class="container hero__grid">
        <div>
            <h1>Powerful CRM Software for Travel Agencies in Nepal</h1>
            <p>One platform to capture leads, manage customers, run your sales pipeline, track payments and report on your whole travel business — built for Nepal's travel, trekking and tour operators.</p>
            <div class="hero__ctas">
                <a href="<?= site_url('request-a-demo') ?>" class="btn btn-primary btn-lg">Request a Demo</a>
                <a href="<?= site_url('features') ?>" class="btn btn-outline btn-lg">Explore Features</a>
            </div>
        </div>
        <div class="hero__mock">
            Product dashboard screenshot placeholder<br>(swap with real UI screenshot)
        </div>
    </div>
</section>

<!-- TRUST -->
<section class="section">
    <div class="container">
        <div class="stats">
            <?php foreach ($trustStats as $s): ?>
            <div class="stat">
                <div class="stat__value"><?= esc($s['value']) ?></div>
                <div class="stat__label"><?= esc($s['label']) ?><?php if (! empty($s['tbd'])): ?><span class="tbd">TBD</span><?php endif; ?></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- PROBLEMS -->
<section class="section section-alt">
    <div class="container">
        <div class="section__head">
            <h2>Running a travel agency without a CRM looks like this</h2>
            <p>Sound familiar? Here's what CRM Software Nepal replaces.</p>
        </div>
        <div class="problems">
            <?php foreach ($painPoints as $p): ?>
            <div class="problem">
                <span class="problem__x">&times;</span>
                <span><?= esc($p) ?></span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- FEATURES -->
<section class="section" id="features">
    <div class="container">
        <div class="section__head">
            <h2>Everything your team needs, in one CRM</h2>
            <p>Purpose-built modules for every step of the customer journey.</p>
        </div>
        <div class="features-grid">
            <?php foreach ($featureGroups as $fg): ?>
            <div class="feature-card">
                <div class="feature-card__icon"><?= strtoupper(substr($fg['title'], 0, 1)) ?></div>
                <h3><?= esc($fg['title']) ?></h3>
                <ul>
                    <?php foreach ($fg['items'] as $item): ?>
                    <li><?= esc($item) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- HOW IT WORKS -->
<section class="section section-alt">
    <div class="container">
        <div class="section__head">
            <h2>How It Works</h2>
        </div>
        <div class="steps">
            <?php foreach ($howItWorks as $s): ?>
            <div class="step">
                <div class="step__num"><?= $s['step'] ?></div>
                <h4><?= esc($s['title']) ?></h4>
                <p><?= esc($s['desc']) ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- SCREENSHOTS -->
<section class="section">
    <div class="container">
        <div class="section__head">
            <h2>See it in action <span class="tbd">TBD — real screenshots</span></h2>
            <p>Placeholder tiles below — replace each with an actual product screenshot before launch.</p>
        </div>
        <div class="screens-grid">
            <?php foreach ($screenshots as $s): ?>
            <div class="screen-card"><?= esc($s) ?></div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="section">
    <div class="cta-band">
        <h2>See CRM Software Nepal on your own data</h2>
        <p>Book a free walkthrough with our team — no commitment required.</p>
        <a href="<?= site_url('request-a-demo') ?>" class="btn btn-outline btn-lg">Request a Demo</a>
    </div>
</section>

<?= $this->endSection() ?>
