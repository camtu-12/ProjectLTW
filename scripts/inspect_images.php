<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
// Bootstrap the kernel so database and models are available
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Sanpham;

$rows = Sanpham::take(12)->get();
foreach ($rows as $p) {
    echo $p->id . ' | ' . $p->tensanpham . ' | ' . ($p->hinhanh ?? 'NULL') . PHP_EOL;
}


echo "\n-- Check sample file existence in public/storage and public/images for first non-empty hinhanh --\n";
$first = $rows->first(function($r){ return !empty($r->hinhanh); });
if ($first) {
    $path = $first->hinhanh;
    $storagePath = __DIR__ . '/../public/storage/' . ltrim($path, '/');
    $publicPath = __DIR__ . '/../public/images/' . ltrim($path, '/');
    echo "hinhanh to check: $path\n";
    echo "public/storage path: $storagePath => " . (file_exists($storagePath) ? 'FOUND' : 'MISSING') . PHP_EOL;
    echo "public/images path: $publicPath => " . (file_exists($publicPath) ? 'FOUND' : 'MISSING') . PHP_EOL;
} else {
    echo "No product with hinhanh found in sample set." . PHP_EOL;
}
