<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class sanpham extends Model
{
    use HasFactory;

    protected $fillable = [
        'danhmuc_id',
        'tensanpham',
        'gia',
        'hinhanh',
        'mota',
        'soluong',
    ];

    public function danhmuc()
    {
        return $this->belongsTo(danhmuc::class);
    }
    public function chitietdonhang()
    {
        return $this->hasMany(chitietdonhang::class);
    }
}
