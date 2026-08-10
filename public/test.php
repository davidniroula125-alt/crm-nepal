<?php
header('Content-Type: text/plain; charset=utf-8');

echo "=== ENVIRONMENT VARIABLES ===\n";
echo "CI_ENVIRONMENT (getenv): " . (getenv('CI_ENVIRONMENT') ?: 'NOT SET') . "\n";
echo "CI_ENVIRONMENT (\$_ENV): " . (\$_ENV['CI_ENVIRONMENT'] ?? 'NOT SET') . "\n";
echo "\n";

echo "=== DATABASE ENV VARS ===\n";
foreach (['hostname','database','username','password','port','DBDriver'] as $k) {
    $v = getenv("database.default.$k");
    if ($v === false) $v = 'NOT SET';
    elseif ($k === 'password') $v = $v ? "(set, len=" . strlen($v) . ")" : "EMPTY";
    echo "database.default.$k = $v\n";
}
echo "\n";

echo "=== PHP ===\n";
echo "Version: " . phpversion() . "\n";
echo "Loaded: " . implode(', ', get_loaded_extensions()) . "\n";
echo "\n";

echo "=== POSTGRESQL TEST ===\n";
if (extension_loaded('pdo_pgsql')) {
    $host = getenv('database.default.hostname') ?: 'localhost';
    $port = getenv('database.default.port') ?: '5432';
    $db   = getenv('database.default.database') ?: '';
    $user = getenv('database.default.username') ?: '';
    $pass = getenv('database.default.password') ?: '';
    echo "DSN: pgsql:host=$host;port=$port;dbname=$db\n";
    try {
        $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$db", $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        echo "Connection: SUCCESS\n";
        echo "Version: " . $pdo->query("SELECT version()")->fetchColumn() . "\n";
    } catch (PDOException $e) {
        echo "Connection: FAILED\n";
        echo "Error: " . $e->getMessage() . "\n";
    }
} else {
    echo "pdo_pgsql extension NOT loaded\n";
}
echo "\n";

echo "=== FILES ===\n";
echo "vendor/autoload.php: " . (file_exists(dirname(__DIR__) . '/vendor/autoload.php') ? 'EXISTS' : 'MISSING') . "\n";
echo "CI4 Boot.php: " . (file_exists(dirname(__DIR__) . '/vendor/codeigniter4/framework/system/Boot.php') ? 'EXISTS' : 'MISSING') . "\n";
echo "\n";

echo "=== WRITABLE DIRS ===\n";
foreach (['writable/cache','writable/logs','writable/session','writable/uploads'] as $d) {
    $full = dirname(__DIR__) . '/' . $d;
    if (is_dir($full)) {
        echo "$d: EXISTS (perm=" . substr(sprintf('%o', fileperms($full)), -4) . ")\n";
    } else {
        echo "$d: MISSING\n";
    }
}
