<?php
/**
 * Run migrations without exec() by bootstrapping Laravel directly.
 * DELETE THIS FILE AFTER USE!
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);
set_time_limit(300);

echo "<pre>\n";
echo "=== Laravel Migration Runner ===\n\n";

// Bootstrap Laravel
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

// Clear config cache first 
echo "Clearing config cache...\n";
try {
    $exitCode = $kernel->call('config:clear');
    echo "config:clear exit code: $exitCode\n";
}
catch (Exception $e) {
    echo "config:clear error: " . $e->getMessage() . "\n";
}

echo "\nClearing view cache...\n";
try {
    $exitCode = $kernel->call('view:clear');
    echo "view:clear exit code: $exitCode\n";
}
catch (Exception $e) {
    echo "view:clear error: " . $e->getMessage() . "\n";
}

echo "\nClearing route cache...\n";
try {
    $exitCode = $kernel->call('route:clear');
    echo "route:clear exit code: $exitCode\n";
}
catch (Exception $e) {
    echo "route:clear error: " . $e->getMessage() . "\n";
}

// Show current DB config
echo "\n=== Database Config ===\n";
echo "Connection: " . config('database.default') . "\n";
echo "Host: " . config('database.connections.mysql.host') . "\n";
echo "Database: " . config('database.connections.mysql.database') . "\n";
echo "Username: " . config('database.connections.mysql.username') . "\n\n";

// Run migrations
echo "=== Running Migrations ===\n";
try {
    $exitCode = $kernel->call('migrate', ['--force' => true]);
    echo "Migration exit code: $exitCode\n";
    echo Artisan::output();
}
catch (Exception $e) {
    echo "Migration error: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}

// Create storage link
echo "\n=== Storage Link ===\n";
try {
    $exitCode = $kernel->call('storage:link');
    echo "storage:link exit code: $exitCode\n";
}
catch (Exception $e) {
    echo "storage:link: " . $e->getMessage() . "\n";
}

echo "\n=== DONE ===\n";
echo "DELETE THIS FILE NOW!\n";
echo "</pre>";
