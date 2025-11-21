<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Database Initialization</h2>";

// Try to load config
$config = require __DIR__ . '/config/database.php';

echo "<p>Attempting connection to: {$config['host']} / {$config['database']}</p>";

try {
    $dsn = sprintf(
        'mysql:host=%s;dbname=%s;charset=%s',
        $config['host'],
        $config['database'],
        $config['charset']
    );
    
    $pdo = new PDO(
        $dsn,
        $config['username'],
        $config['password'],
        $config['options']
    );
    
    echo "<p style='color:green'>✅ Database connected successfully!</p>";
    
    // Load and execute schema
    $schema = file_get_contents(__DIR__ . '/database/schema.sql');
    if ($schema) {
        $statements = array_filter(array_map('trim', explode(';', $schema)));
        $executed = 0;
        foreach ($statements as $statement) {
            if (!empty($statement)) {
                try {
                    $pdo->exec($statement);
                    $executed++;
                } catch (PDOException $e) {
                    // Ignore "table exists" errors
                    if (strpos($e->getMessage(), 'already exists') === false) {
                        echo "<p style='color:orange'>Warning: " . htmlspecialchars($e->getMessage()) . "</p>";
                    }
                }
            }
        }
        echo "<p style='color:green'>✅ Executed {$executed} schema statements</p>";
    }
    
    // Load and execute seeds
    $seeds = file_get_contents(__DIR__ . '/database/seeds.sql');
    if ($seeds) {
        $statements = array_filter(array_map('trim', explode(';', $seeds)));
        $executed = 0;
        foreach ($statements as $statement) {
            if (!empty($statement)) {
                try {
                    $pdo->exec($statement);
                    $executed++;
                } catch (PDOException $e) {
                    // Ignore duplicate entry errors
                    if (strpos($e->getMessage(), 'Duplicate entry') === false) {
                        echo "<p style='color:orange'>Warning: " . htmlspecialchars($e->getMessage()) . "</p>";
                    }
                }
            }
        }
        echo "<p style='color:green'>✅ Executed {$executed} seed statements</p>";
    }
    
    // Show table count
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    echo "<p style='color:green'>✅ Database has " . count($tables) . " tables</p>";
    echo "<ul>";
    foreach ($tables as $table) {
        $count = $pdo->query("SELECT COUNT(*) FROM `{$table}`")->fetchColumn();
        echo "<li>{$table}: {$count} rows</li>";
    }
    echo "</ul>";
    
    echo "<h3>Test Queries</h3>";
    
    // Test products
    $products = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
    echo "<p>Products: {$products}</p>";
    
    // Test users
    $users = $pdo->query("SELECT id, username, role FROM staff")->fetchAll();
    echo "<p>Users:</p><ul>";
    foreach ($users as $user) {
        echo "<li>{$user['username']} ({$user['role']})</li>";
    }
    echo "</ul>";
    
    echo "<p style='color:green;font-weight:bold'>✅ Database initialization complete!</p>";
    echo "<p><a href='/pos/public/'>Go to POS System</a></p>";
    
} catch (PDOException $e) {
    echo "<p style='color:red'>❌ Database error: " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<pre>" . print_r($config, true) . "</pre>";
}
