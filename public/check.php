<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
echo "<pre>\n";
echo "=== DB & Error Check ===\n\n";

$base = dirname(__DIR__);

// Read .env
$env = [];
foreach (file("$base/.env") as $line) {
    $line = trim($line);
    if (!$line || $line[0] === '#')
        continue;
    $parts = explode('=', $line, 2);
    if (count($parts) === 2)
        $env[trim($parts[0])] = trim($parts[1], '"\'');
}

// Check DB
try {
    $pdo = new PDO(
        "mysql:host=" . ($env['DB_HOST'] ?? '127.0.0.1') . ";port=" . ($env['DB_PORT'] ?? '3306') . ";dbname=" . ($env['DB_DATABASE'] ?? ''),
        $env['DB_USERNAME'] ?? '', $env['DB_PASSWORD'] ?? ''
        );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "[OK] DB Connected\n\n";

    // Check quotes table
    $stmt = $pdo->query("SELECT COUNT(*) FROM quotes");
    echo "Quotes count: " . $stmt->fetchColumn() . "\n";

    $stmt = $pdo->query("DESCRIBE quotes");
    echo "\n=== quotes table structure ===\n";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo $row['Field'] . " | " . $row['Type'] . " | " . ($row['Null'] === 'YES' ? 'nullable' : 'required') . " | default: " . ($row['Default'] ?? 'none') . "\n";
    }

    // Check all tables
    echo "\n=== All tables ===\n";
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    foreach ($tables as $t) {
        $count = $pdo->query("SELECT COUNT(*) FROM `$t`")->fetchColumn();
        echo "  $t: $count rows\n";
    }

}
catch (PDOException $e) {
    echo "[FAIL] " . $e->getMessage() . "\n";
}

// Check recent error log
echo "\n=== Recent Laravel Errors ===\n";
$logFile = "$base/storage/logs/laravel.log";
if (is_file($logFile)) {
    $size = filesize($logFile);
    echo "Log file size: " . number_format($size) . " bytes\n\n";

    if ($size > 0) {
        $fp = fopen($logFile, 'r');
        $readSize = min($size, 8000);
        fseek($fp, max(0, $size - $readSize));
        $content = fread($fp, $readSize);
        fclose($fp);

        // Find the last few error entries
        $entries = preg_split('/(\[\d{4}-\d{2}-\d{2})/', $content, -1, PREG_SPLIT_DELIM_CAPTURE);
        $last = array_slice($entries, -8);
        echo implode('', $last);
    }
}
else {
    echo "No log file found\n";
}

// Check .env SESSION_DRIVER
echo "\n\n=== Key .env Settings ===\n";
echo "DB_CONNECTION: " . ($env['DB_CONNECTION'] ?? 'not set') . "\n";
echo "SESSION_DRIVER: " . ($env['SESSION_DRIVER'] ?? 'not set') . "\n";
echo "CACHE_STORE: " . ($env['CACHE_STORE'] ?? 'not set') . "\n";
echo "APP_DEBUG: " . ($env['APP_DEBUG'] ?? 'not set') . "\n";

echo "\n</pre>";
