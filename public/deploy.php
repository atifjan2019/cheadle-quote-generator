<?php
/**
 * Deploy helper: runs composer install using PHP directly.
 * DELETE THIS FILE AFTER USE!
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);
set_time_limit(600);
ini_set('memory_limit', '512M');

echo "<pre>\n";
echo "=== Deploy Helper ===\n\n";

$baseDir = dirname(__DIR__);
echo "Base directory: $baseDir\n";
echo "PHP version: " . phpversion() . "\n\n";

// First, let's check the error
echo "=== Checking current error ===\n";
try {
    // Try to load autoloader
    if (file_exists($baseDir . '/vendor/autoload.php')) {
        echo "Autoloader exists\n";
    }
    else {
        echo "ERROR: Autoloader missing!\n";
    }

    // Check .env
    if (file_exists($baseDir . '/.env')) {
        echo ".env exists\n";
        $env = file_get_contents($baseDir . '/.env');
        // Show DB config (hide password)
        preg_match('/DB_CONNECTION=(.*)/', $env, $m);
        echo "DB_CONNECTION=" . trim($m[1] ?? 'not set') . "\n";
        preg_match('/DB_DATABASE=(.*)/', $env, $m);
        echo "DB_DATABASE=" . trim($m[1] ?? 'not set') . "\n";
        preg_match('/DB_HOST=(.*)/', $env, $m);
        echo "DB_HOST=" . trim($m[1] ?? 'not set') . "\n";
    }
    else {
        echo "ERROR: .env missing!\n";
    }

    // Check storage directories
    $dirs = [
        'storage/app',
        'storage/framework/cache',
        'storage/framework/sessions',
        'storage/framework/views',
        'storage/logs',
        'bootstrap/cache',
    ];
    echo "\n=== Directory checks ===\n";
    foreach ($dirs as $dir) {
        $fullPath = $baseDir . '/' . $dir;
        if (is_dir($fullPath)) {
            echo "[OK] $dir (writable: " . (is_writable($fullPath) ? 'yes' : 'NO') . ")\n";
        }
        else {
            echo "[MISSING] $dir - creating...\n";
            mkdir($fullPath, 0755, true);
            echo "  Created.\n";
        }
    }

    // Try to run composer via PHP
    echo "\n=== Attempting composer install ===\n";

    // Check if exec is available
    if (function_exists('exec')) {
        echo "exec() is available\n";

        // Check if composer is available
        $composerPath = null;
        exec('which composer 2>&1', $composerCheck, $rc);
        if ($rc === 0 && !empty($composerCheck)) {
            $composerPath = trim($composerCheck[0]);
            echo "Found composer at: $composerPath\n";
        }

        if (!$composerPath) {
            // Try common paths
            $tryPaths = ['/usr/local/bin/composer', '/usr/bin/composer', '/home/master/bin/composer'];
            foreach ($tryPaths as $tp) {
                if (file_exists($tp)) {
                    $composerPath = $tp;
                    echo "Found composer at: $composerPath\n";
                    break;
                }
            }
        }

        if (!$composerPath) {
            echo "Composer not found in system, downloading...\n";
            $phar = file_get_contents('https://getcomposer.org/download/latest-stable/composer.phar');
            if ($phar) {
                file_put_contents($baseDir . '/composer.phar', $phar);
                $composerPath = 'php ' . $baseDir . '/composer.phar';
                echo "Downloaded composer.phar\n";
            }
            else {
                echo "ERROR: Could not download composer\n";
            }
        }

        if ($composerPath) {
            echo "\nRunning: $composerPath install --no-dev --optimize-autoloader\n";
            echo "This may take a few minutes...\n\n";

            $output = [];
            $returnCode = 0;
            putenv('COMPOSER_HOME=' . $baseDir . '/.composer');
            exec("cd " . escapeshellarg($baseDir) . " && $composerPath install --no-dev --optimize-autoloader 2>&1", $output, $returnCode);
            echo "Return code: $returnCode\n";
            echo implode("\n", $output);

            echo "\n\n=== Running Migrations ===\n";
            $output2 = [];
            exec("cd " . escapeshellarg($baseDir) . " && php artisan migrate --force 2>&1", $output2, $rc2);
            echo "Return code: $rc2\n";
            echo implode("\n", $output2);

            echo "\n\n=== Clearing Cache ===\n";
            exec("cd " . escapeshellarg($baseDir) . " && php artisan config:clear 2>&1", $o);
            echo implode("\n", $o) . "\n";
            exec("cd " . escapeshellarg($baseDir) . " && php artisan view:clear 2>&1", $o2);
            echo implode("\n", $o2) . "\n";
            exec("cd " . escapeshellarg($baseDir) . " && php artisan route:clear 2>&1", $o3);
            echo implode("\n", $o3) . "\n";

            // Create storage link
            if (!file_exists($baseDir . '/public/storage')) {
                exec("cd " . escapeshellarg($baseDir) . " && php artisan storage:link 2>&1", $o4);
                echo implode("\n", $o4) . "\n";
            }
        }
    }
    else {
        echo "exec() is NOT available - cannot run composer\n";
        echo "You'll need to run these commands via Cloudways SSH terminal:\n";
        echo "  cd public_html\n";
        echo "  composer install --no-dev\n";
        echo "  php artisan migrate --force\n";
        echo "  php artisan config:clear\n";
        echo "  php artisan view:clear\n";
    }


}
catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}

echo "\n=== DONE ===\n";
echo "DELETE THIS FILE NOW!\n";
echo "</pre>\n";
