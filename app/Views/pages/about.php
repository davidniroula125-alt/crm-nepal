<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<section class="section">
    <div class="container">
        <div class="section__head">
            <h2><?= esc($pageContent['hero']['headline'] ?? 'About CRM Software Nepal') ?></h2>
        </div>

        <div style="max-width:780px;margin:0 auto;display:grid;gap:32px;">
            <?php
            $sections = [
                'who_we_are' => 'Who We Are',
                'vision'     => 'Our Vision',
                'mission'    => 'Our Mission',
                'why_us'     => 'Why CRM Software Nepal',
            ];
            foreach ($sections as $key => $title):
                $content = $pageContent[$key]['content'] ?? '';
            ?>
                <?php if (!empty($content)): ?>
                <div>
                    <h3 style="color:var(--color-primary-dark);margin-bottom:8px;"><?= $title ?></h3>
                    <p style="color:var(--color-text-muted);"><?= nl2br(esc($content)) ?></p>
                </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
