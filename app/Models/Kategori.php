<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_kategori',
    ];

    // 🔗 Relasi ke transaksi (1 kategori bisa punya banyak transaksi)
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }

    // 🔗 Relasi ke user (tiap kategori milik user tertentu)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
