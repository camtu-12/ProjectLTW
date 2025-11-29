<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
use App\Models\Sanpham;
$all = Sanpham::select('id','tensanpham','danhmuc_id')->limit(50)->get();
if ($all->isEmpty()) { echo "(no products)\n"; exit; }
foreach ($all as $p) {
    echo $p->id . " ::: " . ($p->tensanpham ?: '(no title)') . " ::: danhmuc_id=" . ($p->danhmuc_id ?? 'NULL') . PHP_EOL;
}
