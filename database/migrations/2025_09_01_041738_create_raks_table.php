<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('raks', function (Blueprint $table) {
            $table->id();
            $table->string('kode_rak')->unique(); // contoh: A1
            $table->string('nama_rak');           // contoh: Fiksi & Agama
            $table->string('lokasi');             // contoh: Lantai 1 - Kiri
            $table->timestamps();
        });

        // tambah relasi ke tabel bukus
        Schema::table('bukus', function (Blueprint $table) {
            $table->foreignId('rak_id')->nullable()
                  ->constrained('raks')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('bukus', function (Blueprint $table) {
            $table->dropConstrainedForeignId('rak_id');
        });

        Schema::dropIfExists('raks');
    }
};
