<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class chitietdonhang extends Model
{

    use HasFactory;
    protected $fillable = ['donhang_id', 'sanpham_id', 'soluong', 'gia'];

    public function donhang()
    {
        return $this->belongsTo(donhang::class);
    }

    public function sanpham()
    {
        return $this->belongsTo(sanpham::class);
    }
}
