<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_buku', 'judul', 'kategori_id', 'penulis', 'penerbit', 'tahun_terbit', 'stok'
    ];

    // Relasi: Book → Peminjamans (satu buku bisa dipinjam berkali-kali)
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }

    public function kategoris()
{
    return $this->belongsTo(KategoriBuku::class, 'kategori_id');
}


    public function rak()
{
    return $this->belongsTo(Rak::class, 'rak_id');
}

}
