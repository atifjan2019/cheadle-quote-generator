<?php
/**
 * Enable debug mode and clear caches to see actual error.
 * DELETE THIS FILE AFTER USE!
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<pre>\n";
echo "=== Debug Helper ===\n\n";

$base = dirname(__DIR__);

// Update .env to enable debug
$env = file_get_contents("$base/.env");
$env = preg_replace('/^APP_DEBUG=false/m', 'APP_DEBUG=true', $env);
file_put_contents("$base/.env", $env);
echo "[OK] Enabled APP_DEBUG\n";

// Delete any cached config files
$cacheFiles = glob("$base/bootstrap/cache/*.php");
foreach ($cacheFiles as $f) {
    $basename = basename($f);
    if ($basename !== '.gitignore') {
        unlink($f);
        echo "[OK] Deleted cache: $basename\n";
    }
}

// Delete compiled views
$viewFiles = glob("$base/storage/framework/views/*.php");
foreach ($viewFiles as $f) {
    unlink($f);
}
echo "[OK] Cleared " . count($viewFiles) . " compiled views\n";

// Also check for config/sanctum.php
if (file_exists("$base/config/sanctum.php")) {
    rename("$base/config/sanctum.php", "$base/config/sanctum.php.disabled");
    echo "[OK] Disabled sanctum config\n";
}

// Check what config files reference classes that might not exist
echo "\n=== Checking config files ===\n";
$configFiles = glob("$base/config/*.php");
foreach ($configFiles as $cf) {
    $contents = file_get_contents($cf);
    if (preg_match_all('/([A-Z][a-z]+\\\\[A-Z][a-z]+\\\\[A-Z]\w+)::/', $contents, $matches)) {
        $bn = basename($cf);
        foreach ($matches[1] as $class) {
            $classExists = class_exists($class, false);
            echo "  $bn: $class " . ($classExists ? "[OK]" : "[MISSING]") . "\n";
        }
    }
}

echo "\n=== Now try loading the home page... ===\n";
echo "Visit: https://phplaravel-1196470-6262337.cloudwaysapps.com/\n";
echo "You should see a detailed error page now.\n";
echo "</pre>";
