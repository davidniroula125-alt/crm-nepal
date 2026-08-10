
<?= $heading ?? 'Debug Error' . "\n" ?>
<?= $message ?? 'An unexpected error occurred.' . "\n" ?>

<?php if (!empty($file)): ?>
File: <?= $file ?>
<?php if (!empty($line)): ?>
Line: <?= $line ?>
<?php endif; ?>
<?php endif; ?>

<?php if (!empty($trace)): ?>
<?= $trace ?>
<?php endif; ?>
