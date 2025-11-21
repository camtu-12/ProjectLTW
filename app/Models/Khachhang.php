<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Khachhang extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ten',
        'sdt',
        'diachi',
        'gioitinh',
        'ngaysinh',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function donhangs()
    {
        return $this->hasMany(Donhang::class);
    }

    
}
