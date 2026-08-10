<?php
$connStr = 'pgsql:host=dpg-d9sa7o142hec73bv25b0-a.oregon-postgres.render.com;port=5432;dbname=crm_software_nepal';
try {
    $pdo = new PDO($connStr, 'crm_software_nepal_user', 'AoDYhnnMLmRjSrxIOTtkBjqBoa8xnUJE', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    echo "Connected!\n";
    $schema = file_get_contents(__DIR__ . '/../database/schema.sql');
    $pdo->exec($schema);
    echo "Schema applied!\n";
    $tables = $pdo->query("SELECT tablename FROM pg_tables WHERE schemaname='public'")->fetchAll(PDO::FETCH_COLUMN);
    echo "Tables: " . implode(', ', $tables) . "\n";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
