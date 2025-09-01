<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Buku;

class KategoriBuku extends Model
{
    use HasFactory;
    protected $table = 'kategori_bukus';
    protected $fillable = ['kode', 'nama', 'deskripsi'];

    public function bukus()
    {
        return $this->hasMany(Buku::class, 'kategori_id');
    }
}
