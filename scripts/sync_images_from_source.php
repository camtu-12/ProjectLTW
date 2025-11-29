<?php
if ($argc < 2) {
    echo "Usage: php sync_images_from_source.php <source_folder>\n";
    exit(1);
}
$source = rtrim($argv[1], "\\/") . DIRECTORY_SEPARATOR;
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
use App\Models\Sanpham;

$products = Sanpham::whereNotNull('hinhanh')->pluck('hinhanh')->unique();
$copied = 0;
$missing = [];
foreach ($products as $hinhanh) {
    $relative = ltrim($hinhanh, '\\/');
    $sourcePath1 = $source . $relative; // exact match relative path
    $sourcePath2 = $source . basename($relative); // filename in source root

    $destPath = __DIR__ . '/../storage/app/public/' . $relative;
    $destDir = dirname($destPath);
    if (!is_dir($destDir)) {
        mkdir($destDir, 0755, true);
    }

    if (file_exists($sourcePath1)) {
        copy($sourcePath1, $destPath);
        $copied++;
        echo "Copied: $sourcePath1 -> $destPath\n";
        continue;
    }
    if (file_exists($sourcePath2)) {
        copy($sourcePath2, $destPath);
        $copied++;
        echo "Copied: $sourcePath2 -> $destPath\n";
        continue;
    }

    // try recursive search for filename in source
    $filename = basename($relative);
    $found = null;
    $rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source));
    foreach ($rii as $file) {
        if ($file->isDir()) continue;
        if (strcasecmp($file->getFilename(), $filename) === 0) {
            $found = $file->getPathname();
            break;
        }
    }
    if ($found) {
        copy($found, $destPath);
        $copied++;
        echo "Copied (found): $found -> $destPath\n";
        continue;
    }

    $missing[] = $relative;
    echo "Missing: $relative\n";
}

echo "\nDone. Copied: $copied. Missing: " . count($missing) . "\n";
if (count($missing) > 0) {
    echo "Missing files list:\n" . implode("\n", $missing) . "\n";
}

echo "\nRun: php artisan storage:link if not already run.\n";
