<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Exception Details</title>
    <style>
        body { font-family: monospace; margin: 0; padding: 2rem; background: #1e1e1e; color: #d4d4d4; }
        h1 { color: #e74c3c; }
        h2 { color: #f39c12; }
        pre { background: #2d2d2d; padding: 1rem; border-radius: 4px; overflow-x: auto; white-space: pre-wrap; word-wrap: break-word; border: 1px solid #444; }
        .label { color: #9cdcfe; font-weight: bold; }
    </style>
</head>
<body>
    <h1>Error Details</h1>

    <?php
    // Try to get exception from different possible variable names
    $ex = null;
    if (isset($exception) && $exception instanceof \Throwable) { $ex = $exception; }
    elseif (isset($e) && $e instanceof \Throwable) { $ex = $e; }
    elseif (isset($exc) && $exc instanceof \Throwable) { $ex = $exc; }

    if ($ex !== null):
    ?>
        <p><span class="label">Exception Class:</span> <?= get_class($ex) ?></p>
        <p><span class="label">Message:</span> <?= htmlspecialchars($ex->getMessage()) ?></p>
        <p><span class="label">File:</span> <?= htmlspecialchars($ex->getFile()) ?></p>
        <p><span class="label">Line:</span> <?= $ex->getLine() ?></p>
        <p><span class="label">Code:</span> <?= $ex->getCode() ?></p>
        <h2>Stack Trace</h2>
        <pre><?= htmlspecialchars($ex->getTraceAsString()) ?></pre>
    <?php
    else:
    ?>
        <p>No exception object found in view variables.</p>
    <?php endif; ?>

    <h2>Debug Info</h2>
    <pre>
PHP: <?= phpversion() ?>
CI_ENVIRONMENT: <?= getenv('CI_ENVIRONMENT') ?: 'not set' ?>
CI_DEBUG: <?= defined('CI_DEBUG') ? (CI_DEBUG ? 'true' : 'false') : 'NOT DEFINED' ?>
REQUEST_URI: <?= $_SERVER['REQUEST_URI'] ?? 'N/A' ?>
HTTP_ACCEPT: <?= $_SERVER['HTTP_ACCEPT'] ?? 'N/A' ?>
</pre>

    <h2>All Defined Variables</h2>
    <pre><?php
    $vars = get_defined_vars();
    unset($vars['GLOBALS']);
    foreach ($vars as $k => $v) {
        echo htmlspecialchars($k) . ' = ' . (is_object($v) ? get_class($v) : var_export($v, true)) . "\n";
    }
    ?></pre>
</body>
</html>
