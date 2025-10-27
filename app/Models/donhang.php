<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class donhang extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'tongtien', 'trangthai'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');

    }

    public function chitietdonhang()
    {
        return $this->hasMany(chitietdonhang::class);
    }
}
