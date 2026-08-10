<?php
header('Content-Type: text/plain; charset=utf-8');

echo "=== ENVIRONMENT ===\n";
$ciEnv = getenv('CI_ENVIRONMENT');
echo "CI_ENVIRONMENT via getenv: " . ($ciEnv !== false ? $ciEnv : 'NOT SET') . "\n";
echo "CI_ENVIRONMENT via _SERVER: " . (isset($_SERVER['CI_ENVIRONMENT']) ? $_SERVER['CI_ENVIRONMENT'] : 'NOT SET') . "\n";
echo "\n";

echo "=== DATABASE ENV VARS ===\n";
$keys = ['hostname','database','username','password','port','DBDriver'];
foreach ($keys as $k) {
    $v = getenv("database.default.$k");
    if ($v === false) {
        echo "database.default.$k = NOT SET\n";
    } elseif ($k === 'password') {
        echo "database.default.$k = " . ($v !== '' ? "SET (len=" . strlen($v) . ")" : "EMPTY") . "\n";
    } else {
        echo "database.default.$k = $v\n";
    }
}
echo "\n";

echo "=== PHP ===\n";
echo "Version: " . phpversion() . "\n";
echo "Extensions: " . implode(', ', get_loaded_extensions()) . "\n";
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
        $dsn = "pgsql:host=$host;port=$port;dbname=$db";
        $pdo = new PDO($dsn, $user, $pass, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        echo "Connection: SUCCESS\n";
        echo "Version: " . $pdo->query("SELECT version()")->fetchColumn() . "\n";
        echo "Tables: ";
        $tables = $pdo->query("SELECT tablename FROM pg_tables WHERE schemaname='public'")->fetchAll(PDO::FETCH_COLUMN);
        echo count($tables) > 0 ? implode(', ', $tables) : "NONE (no tables!)";
        echo "\n";
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
$dirs = array('writable/cache','writable/logs','writable/session','writable/uploads');
foreach ($dirs as $d) {
    $full = dirname(__DIR__) . '/' . $d;
    if (is_dir($full)) {
        echo "$d: EXISTS (perm=" . substr(sprintf('%o', fileperms($full)), -4) . ")\n";
    } else {
        echo "$d: MISSING\n";
    }
}
