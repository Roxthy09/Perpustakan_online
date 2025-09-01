<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    use HasFactory;

    protected $table = 'pengembalians';

    protected $fillable = [
        'user_id','pengembalian_id', 'tgl_kembali'
    ];

    // Relasi: Return → Loan
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }

     public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Return → Denda
    public function denda()
    {
        return $this->hasOne(Denda::class, 'return_id');
    }
}
