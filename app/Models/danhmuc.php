<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class danhmuc extends Model
{
    use HasFactory;
    protected $fillable = ['tendanhmuc', 'mota'];

    function sanpham()
    {
        return $this->hasMany(sanpham::class);
    }
}
