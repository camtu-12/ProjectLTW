<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
use App\Models\danhmuc;
$name = 'Áo Thun Nữ';
$exists = danhmuc::where('tendanhmuc', $name)->first();
if ($exists) {
    echo "Category already exists: {$exists->id} ::: {$exists->tendanhmuc}\n";
    exit(0);
}
$c = danhmuc::create([ 'tendanhmuc' => $name, 'mota' => 'Tạo tự động bởi script' ]);
if ($c) echo "Created category: {$c->id} ::: {$c->tendanhmuc}\n";
