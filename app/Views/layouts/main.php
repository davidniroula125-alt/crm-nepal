<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= esc($metaTitle ?? $siteName) ?></title>
<meta name="description" content="<?= esc($metaDescription ?? '') ?>">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/theme.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>
<body>

<?= $this->include('partials/nav') ?>

<main><?= $this->renderSection('content') ?></main>

<?= $this->include('partials/footer') ?>

<script src="<?= base_url('assets/js/main.js') ?>"></script>
</body>
</html>
