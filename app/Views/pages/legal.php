<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container legal-page">
    <h1><?= esc($legalTitle) ?> <span class="tbd">TBD — insert final legal text</span></h1>
    <p style="color:var(--color-text-muted);">Placeholder — final <?= esc(strtolower($legalTitle)) ?> content to be supplied and inserted here (or made editable via the admin Content CMS in Part 2).</p>
</div>

<?= $this->endSection() ?>
