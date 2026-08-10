<?php
$host = getenv('database.default.hostname');
$port = getenv('database.default.port');
$db   = getenv('database.default.database');
$user = getenv('database.default.username');
$pass = getenv('database.default.password');

echo "Host: $host\nPort: $port\nDB: $db\nUser: $user\nPass: " . ($pass ? 'SET' : 'EMPTY') . "\n\n";

$connStr = "pgsql:host=$host;port=$port;dbname=$db";
try {
    $pdo = new PDO($connStr, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::PGSQL_ATTR_SSLMODE => PDO::PGSQL_SSLMODE_REQUIRE,
    ]);
    echo "Connected!\n";
    $schema = file_get_contents(__DIR__ . '/../database/schema.sql');
    $pdo->exec($schema);
    echo "Schema applied!\n";
    $tables = $pdo->query("SELECT tablename FROM pg_tables WHERE schemaname='public'")->fetchAll(PDO::FETCH_COLUMN);
    echo "Tables: " . implode(', ', $tables) . "\n";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
