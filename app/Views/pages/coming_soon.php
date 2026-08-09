<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container plain-page">
    <h1><?= esc($pageTitle) ?></h1>
    <p><?= esc($note) ?></p>
</div>

<?= $this->endSection() ?>
