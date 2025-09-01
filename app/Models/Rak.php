<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rak extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_rak',
        'nama_rak',
        'lokasi',
    ];

    public function bukus()
    {
        return $this->hasMany(Buku::class, 'rak_id');
    }
}
