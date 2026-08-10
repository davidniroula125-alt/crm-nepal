<?php
// Load .env manually
$envFile = dirname(__DIR__) . '/.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (trim($line) === '' || $line[0] === '#') continue;
        if (strpos($line, '=') === false) continue;
        list($key, $value) = explode('=', $line, 2);
        $key = trim($key);
        $value = trim(trim($value), "'");
        putenv("$key=$value");
        $_ENV[$key] = $value;
    }
}

$host = getenv('database.default.hostname');
$port = getenv('database.default.port');
$db   = getenv('database.default.database');
$user = getenv('database.default.username');
$pass = getenv('database.default.password');

echo "Host: $host\nPort: $port\nDB: $db\nUser: $user\n";

$connStr = "host=$host port=$port dbname=$db user=$user password=$pass";
echo "Connecting...\n";

$conn = @pg_connect($connStr);
if (!$conn) {
    echo "Failed. Trying with sslmode=prefer...\n";
    $conn = @pg_connect("$connStr sslmode=prefer");
}
if (!$conn) {
    echo "Failed. Trying with sslmode=require...\n";
    $conn = @pg_connect("$connStr sslmode=require");
}
if (!$conn) {
    echo "Failed. Trying external host...\n";
    $extHost = 'dpg-d9sa7o142hec73bv25b0-a.oregon-postgres.render.com';
    $conn = @pg_connect("host=$extHost port=$port dbname=$db user=$user password=$pass sslmode=require");
}

if ($conn) {
    echo "Connected!\n";
    $schema = file_get_contents(__DIR__ . '/../database/schema.sql');
    $result = pg_query($conn, $schema);
    if ($result) {
        echo "Schema applied!\n";
        $res = pg_query($conn, "SELECT tablename FROM pg_tables WHERE schemaname='public'");
        $tables = [];
        while ($row = pg_fetch_assoc($res)) {
            $tables[] = $row['tablename'];
        }
        echo "Tables (" . count($tables) . "): " . implode(', ', $tables) . "\n";
    } else {
        echo "Schema error: " . pg_last_error($conn) . "\n";
    }
    pg_close($conn);
} else {
    echo "All connection attempts failed.\n";
    echo "pg_last_error: " . pg_last_error() . "\n";
}
