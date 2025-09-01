<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'book_id', 'tgl_pinjam', 'tgl_jatuh_tempo', 'status'
    ];

    // Relasi: Peminjaman → User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Peminjaman → Book
    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }

    // Relasi: Peminjaman → Return (satu peminjaman punya satu pengembalian)
    public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class, 'Peminjaman_id');
    }
}
