<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
use App\Models\danhmuc;
$all = danhmuc::all();
if ($all->isEmpty()) {
    echo "(no categories found)\n";
    exit(0);
}
foreach ($all as $d) {
    echo $d->id . " ::: " . $d->tendanhmuc . PHP_EOL;
}
