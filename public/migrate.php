<?php
$connStr = 'pgsql:host=' . getenv('database.default.hostname') . ';port=' . getenv('database.default.port') . ';dbname=' . getenv('database.default.database') . ';sslmode=require';
$user = getenv('database.default.username');
$pass = getenv('database.default.password');

echo "Connecting...\n";
try {
    $pdo = new PDO($connStr, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    echo "Connected!\n";
    $schema = file_get_contents(__DIR__ . '/../database/schema.sql');
    $pdo->exec($schema);
    echo "Schema applied!\n";
    $tables = $pdo->query("SELECT tablename FROM pg_tables WHERE schemaname='public'")->fetchAll(PDO::FETCH_COLUMN);
    echo "Tables (" . count($tables) . "): " . implode(', ', $tables) . "\n";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
