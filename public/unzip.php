<?php
/**
 * Clean up backslash-named files, unzip vendor.zip, run migrations.
 * DELETE THIS FILE AFTER USE!
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);
set_time_limit(600);
ini_set('memory_limit', '512M');

echo "<pre>\n";
echo "=== Full Deploy Script v3 ===\n\n";

$base = dirname(__DIR__);

// 1. Clean up backslash-named files from broken zip extraction
echo "Step 1: Cleaning up broken files from previous extraction...\n";
$items = scandir($base);
$cleaned = 0;
foreach ($items as $item) {
    if ($item === '.' || $item === '..')
        continue;
    if (strpos($item, '\\') !== false) {
        $path = "$base/$item";
        if (is_file($path)) {
            unlink($path);
            $cleaned++;
        }
    }
}
// Also remove autoload.php if it ended up in base dir
if (is_file("$base/autoload.php")) {
    unlink("$base/autoload.php");
    $cleaned++;
}
echo "Cleaned $cleaned broken files.\n\n";

// 2. Extract vendor.zip
$zipFile = "$base/vendor.zip";
if (!file_exists($zipFile)) {
    echo "ERROR: vendor.zip not found!\n";
    echo "</pre>";
    exit;
}

echo "Step 2: Found vendor.zip: " . number_format(filesize($zipFile)) . " bytes\n";

// Remove old vendor if exists
if (is_dir("$base/vendor")) {
    echo "Removing old vendor directory...\n";
    function rrmdir($dir)
    {
        foreach (scandir($dir) as $item) {
            if ($item === '.' || $item === '..')
                continue;
            $path = "$dir/$item";
            is_dir($path) ? rrmdir($path) : unlink($path);
        }
        rmdir($dir);
    }
    rrmdir("$base/vendor");
    echo "Done.\n";
}

echo "Extracting...\n";
$zip = new ZipArchive();
if ($zip->open($zipFile) === TRUE) {
    echo "Files in zip: " . $zip->numFiles . "\n";
    echo "First entry: " . $zip->getNameIndex(0) . "\n";
    $zip->extractTo($base);
    $zip->close();

    if (is_file("$base/vendor/autoload.php")) {
        echo "[OK] vendor/autoload.php exists!\n";
    }
    else {
        echo "[FAIL] vendor/autoload.php missing!\n";
        echo "</pre>";
        exit;
    }
}
else {
    echo "ERROR: Cannot open zip\n";
    echo "</pre>";
    exit;
}

unlink($zipFile);
echo "Cleaned up vendor.zip\n\n";

// 3. Bootstrap Laravel
echo "Step 3: Bootstrapping Laravel...\n";
try {
    require "$base/vendor/autoload.php";
    $app = require_once "$base/bootstrap/app.php";
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

    echo "Laravel " . $app->version() . "\n";
    echo "DB: " . config('database.default') . "\n";
    echo "DB name: " . config('database.connections.' . config('database.default') . '.database') . "\n\n";

    // Clear caches
    echo "Step 4: Clearing caches...\n";
    $kernel->call('config:clear');
    $kernel->call('view:clear');
    $kernel->call('route:clear');
    $kernel->call('cache:clear');
    echo "Done.\n\n";

    // Run migrations
    echo "Step 5: Running migrations...\n";
    $exitCode = $kernel->call('migrate', ['--force' => true]);
    echo Artisan::output();
    echo "Exit code: $exitCode\n\n";

    // Storage link
    if (!is_link("$base/public/storage")) {
        echo "Step 6: Creating storage link...\n";
        $kernel->call('storage:link');
        echo Artisan::output();
    }

    echo "\n[SUCCESS] Deployment complete!\n";


}
catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}

echo "\n=== DONE ===\n";
echo "DELETE THIS FILE NOW!\n";
echo "</pre>";
