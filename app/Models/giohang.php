<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class giohang extends Model
{
    use HasFactory;
    protected $table = 'giohangs';
    protected $fillable = [
        'user_id',
        'sanpham_id',
        'soluong',
        'giaban',
        'hinhanh',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function sanpham()
    {
        return $this->belongsTo(Sanpham::class);
    }
}
