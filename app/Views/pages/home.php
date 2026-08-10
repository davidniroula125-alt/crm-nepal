<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<!-- HERO -->
<section class="hero">
    <div class="container hero__grid">
        <div>
            <h1><?= esc($hero['headline'] ?? 'Powerful CRM Software for Travel Agencies in Nepal') ?></h1>
            <p><?= esc($hero['subtext'] ?? 'One platform to capture leads, manage customers, run your sales pipeline, track payments and report on your whole travel business.') ?></p>
            <div class="hero__ctas">
                <a href="<?= site_url($hero['cta_primary_link'] ?? 'request-a-demo') ?>" class="btn btn-primary btn-lg"><?= esc($hero['cta_primary'] ?? 'Request a Demo') ?></a>
                <a href="<?= site_url($hero['cta_secondary_link'] ?? 'features') ?>" class="btn btn-outline btn-lg"><?= esc($hero['cta_secondary'] ?? 'Explore Features') ?></a>
            </div>
        </div>
        <div class="hero__mock">
            <div style="position:relative;z-index:1">
                <div style="font-size:48px;margin-bottom:12px;">&#128202;</div>
                <div style="font-weight:600;font-size:16px;color:#fff;margin-bottom:4px;">CRM Dashboard</div>
                <div style="font-size:13px;opacity:.7;">Your travel business, visualized</div>
            </div>
        </div>
    </div>
</section>

<!-- TRUST -->
<section class="section">
    <div class="container">
        <div class="stats">
            <?php foreach ($trustStats as $i => $s): ?>
            <div class="stat fade-in" style="animation-delay:<?= ($i * 0.1) ?>s">
                <div class="stat__value"><?= esc($s['value']) ?></div>
                <div class="stat__label"><?= esc($s['label']) ?></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- PROBLEMS -->
<section class="section section-alt">
    <div class="container">
        <div class="section__head">
            <h2><?= esc($problems['headline'] ?? 'Running a travel agency without a CRM looks like this') ?></h2>
            <p><?= esc($problems['subtext'] ?? 'Sound familiar? Here\'s what CRM Software Nepal replaces.') ?></p>
        </div>
        <div class="problems">
            <?php foreach ($painPoints as $i => $p): ?>
            <div class="problem fade-in" style="animation-delay:<?= ($i * 0.05) ?>s">
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
            <h2><?= esc($features['headline'] ?? 'Everything your team needs, in one CRM') ?></h2>
            <p><?= esc($features['subtext'] ?? 'Purpose-built modules for every step of the customer journey.') ?></p>
        </div>
        <div class="features-grid">
            <?php foreach ($featureGroups as $i => $fg): ?>
            <div class="feature-card fade-in" style="animation-delay:<?= ($i * 0.08) ?>s">
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
            <h2><?= esc($howItWorks['headline'] ?? 'How It Works') ?></h2>
            <p><?= esc($howItWorks['subtext'] ?? 'From first inquiry to repeat customer — in five simple steps.') ?></p>
        </div>
        <div class="steps">
            <?php foreach ($howItWorksSteps as $i => $s): ?>
            <div class="step fade-in" style="animation-delay:<?= ($i * 0.1) ?>s">
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
            <h2>See it in action</h2>
            <p>Placeholder tiles below — replace each with an actual product screenshot before launch.</p>
        </div>
        <div class="screens-grid">
            <?php foreach ($screenshots as $i => $s): ?>
            <div class="screen-card fade-in" style="animation-delay:<?= ($i * 0.06) ?>s"><?= esc($s) ?></div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="section">
    <div class="cta-band">
        <h2><?= esc($ctaBand['headline'] ?? 'See CRM Software Nepal on your own data') ?></h2>
        <p><?= esc($ctaBand['subtext'] ?? 'Book a free walkthrough with our team — no commitment required.') ?></p>
        <a href="<?= site_url('request-a-demo') ?>" class="btn btn-outline btn-lg"><?= esc($ctaBand['cta_text'] ?? 'Request a Demo') ?></a>
    </div>
</section>

<?= $this->endSection() ?>
