<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kategori_id',
        'jenis',
        'jumlah',
        'deskripsi',
        'tanggal',
    ];

    // 🔗 Setiap transaksi milik satu kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    // 🔗 Setiap transaksi milik satu user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
