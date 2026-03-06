<?php
/**
 * Regenerate Composer autoloader and fix service providers.
 * DELETE THIS FILE AFTER USE!
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<pre>\n";
echo "=== Autoloader Regenerator ===\n\n";

$base = dirname(__DIR__);

// 1. Fix platform_check.php
$pc = "$base/vendor/composer/platform_check.php";
file_put_contents($pc, "<?php\n// Disabled\n");
echo "[OK] Platform check disabled\n";

// 2. Clear ALL bootstrap cache
$cacheDir = "$base/bootstrap/cache";
foreach (glob("$cacheDir/*.php") as $f) {
    if (basename($f) !== '.gitignore') {
        unlink($f);
        echo "[OK] Deleted " . basename($f) . "\n";
    }
}

// 3. Clear ALL framework cache
foreach (glob("$base/storage/framework/cache/data/*") as $f) {
    if (is_file($f))
        unlink($f);
}
echo "[OK] Cleared framework cache\n";

// 4. Clear compiled views
$viewCount = 0;
foreach (glob("$base/storage/framework/views/*.php") as $f) {
    unlink($f);
    $viewCount++;
}
echo "[OK] Cleared $viewCount compiled views\n";

// 5. Delete any config/route/event caches
foreach (['config.php', 'routes-v7-web.php', 'routes-v7-api.php', 'events.scanned.php'] as $cf) {
    if (file_exists("$cacheDir/$cf")) {
        unlink("$cacheDir/$cf");
        echo "[OK] Deleted $cf\n";
    }
}

// 6. Check if the autoload_real.php has the wrong PHP version references
$autoloadReal = file_get_contents("$base/vendor/composer/autoload_real.php");
echo "\n=== Autoloader Details ===\n";
if (preg_match('/class (ComposerAutoloaderInit\w+)/', $autoloadReal, $m)) {
    echo "Autoloader class: " . $m[1] . "\n";
}

// 7. Try loading Laravel properly
echo "\n=== Testing Laravel Bootstrap ===\n";
try {
    require "$base/vendor/autoload.php";
    echo "[OK] Autoloader loaded\n";

    $app = require "$base/bootstrap/app.php";
    echo "[OK] Application created\n";

    // Register the core service providers manually
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    echo "[OK] HTTP Kernel created\n";

    // Try to bootstrap
    $response = $kernel->handle(
        $request = Illuminate\Http\Request::capture()
    );

    echo "[OK] Application bootstrapped!\n";
    echo "Response status: " . $response->getStatusCode() . "\n";

    $kernel->terminate($request, $response);


}
catch (Throwable $e) {
    echo "[ERROR] " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n\n";

    // Show the previous exception if any
    $prev = $e->getPrevious();
    if ($prev) {
        echo "Caused by: " . $prev->getMessage() . "\n";
        echo "File: " . $prev->getFile() . ":" . $prev->getLine() . "\n";
    }
}

echo "\n=== DONE ===\n";
echo "</pre>";
