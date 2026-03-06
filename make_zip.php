<?php
$zip = new ZipArchive();
$zipFile = __DIR__ . '/vendor.zip';

if (file_exists($zipFile))
    unlink($zipFile);

$res = $zip->open($zipFile, ZipArchive::CREATE);
if ($res !== TRUE) {
    echo "Cannot create zip\n";
    exit(1);
}

$vendorDir = __DIR__ . '/vendor';
$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($vendorDir, RecursiveDirectoryIterator::SKIP_DOTS),
    RecursiveIteratorIterator::SELF_FIRST    );

$count = 0;
foreach ($iterator as $item) {
    // Use forward slashes for Linux compatibility
    $relativePath = 'vendor/' . str_replace('\\', '/', $iterator->getSubPathname());

    if ($item->isDir()) {
        $zip->addEmptyDir($relativePath);
    }
    else {
        $zip->addFile($item->getRealPath(), $relativePath);
        $count++;
    }

    if ($count % 1000 === 0 && $count > 0) {
        echo "Added $count files...\n";
    }
}

$zip->close();
echo "Done! Created vendor.zip with $count files\n";
echo "Size: " . number_format(filesize($zipFile)) . " bytes\n";
