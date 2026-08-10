<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Error</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; margin: 0; padding: 2rem; background: #f5f5f5; color: #333; }
        .error-container { max-width: 900px; margin: 0 auto; background: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); padding: 2rem; }
        h1 { color: #e74c3c; border-bottom: 2px solid #eee; padding-bottom: 1rem; }
        .error-info { margin: 1rem 0; }
        .error-info strong { display: inline-block; width: 100px; color: #555; }
        .trace { background: #1e1e1e; color: #d4d4d4; padding: 1rem; border-radius: 4px; overflow-x: auto; font-size: 0.85rem; line-height: 1.6; }
        a { display: inline-block; margin-top: 1rem; padding: 0.75rem 2rem; background: #3498db; color: #fff; text-decoration: none; border-radius: 4px; }
        a:hover { background: #2980b9; }
    </style>
</head>
<body>
    <div class="error-container">
        <h1><?= esc($heading ?? 'Error') ?></h1>
        <div class="error-info">
            <p><?= esc($message ?? 'An unexpected error occurred.') ?></p>
        </div>

        <?php if (defined('CI_DEBUG') && CI_DEBUG): ?>
            <?php if (!empty($file)): ?>
                <div class="error-info">
                    <strong>File:</strong> <?= esc($file) ?>
                    <?php if (!empty($line)): ?>
                        <strong>Line:</strong> <?= esc($line) ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($trace)): ?>
                <div class="trace"><pre><?= esc($trace) ?></pre></div>
            <?php endif; ?>
        <?php endif; ?>

        <a href="/">Go Home</a>
    </div>
</body>
</html>
