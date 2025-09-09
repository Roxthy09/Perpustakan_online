<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    use HasFactory;

    protected $table = 'pengembalians';

    protected $fillable = [
        'peminjaman_id','user_id','pengembalian_id', 'buku_id', 'tgl_kembali','kondisi', 'hari_telat', 'status'
    ];

    // Relasi: Return → Loan
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }

     public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Return → Denda
    public function denda()
    {
        return $this->hasOne(Denda::class, 'pengembalian_id');
    }
}
