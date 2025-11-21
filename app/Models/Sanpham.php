<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sanpham extends Model
{
    use HasFactory;

    protected $table = 'sanphams';

    // Bảng hiện tại không có cột created_at/updated_at nên tắt timestamps
    public $timestamps = false;

    protected $fillable = [
        'tensanpham',
        'masanpham',
        'motangan',
        'giagoc',
        'giaban',
        'kichthuoc',
        'soluong',
        'trangthai',
        'danhmuc_id',
    ];

    public function chitietdonhang()
    {
        return $this->hasMany(Chitietdonhang::class);
    }
}