<?php
/**
 * Final cleanup: disable debug, remove deploy scripts.
 * THIS FILE SELF-DESTRUCTS!
 */
$base = dirname(__DIR__);

// Disable debug
$env = file_get_contents("$base/.env");
$env = preg_replace('/^APP_DEBUG=true/m', 'APP_DEBUG=false', $env);
file_put_contents("$base/.env", $env);

// Remove deploy helper scripts
$scripts = ['deploy.php', 'check.php', 'fix.php', 'debug.php', 'migrate.php', 'unzip.php'];
foreach ($scripts as $s) {
    $path = __DIR__ . "/$s";
    if (file_exists($path) && $s !== 'cleanup.php') {
        unlink($path);
    }
}

echo "Cleaned up. Debug disabled. Deploy scripts removed.\n";

// Self-destruct
unlink(__FILE__);
echo "This script has been deleted.\n";
