<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pendaftarans', function (Blueprint $table) {
            $table->string('no_seri_pendaftaran', 50)->primary(); // PK berupa string (contoh: REG-2026-001)
            $table->unsignedBigInteger('id_peserta'); // Foreign Key
            $table->string('file_kk');
            $table->string('file_akta');
            $table->string('status_pendaftaran', 30)->default('Menunggu'); // Menunggu, Diterima, Revisi
            $table->timestamps();

            // Mengatur relasi ke tabel peserta
            $table->foreign('id_peserta')->references('id_peserta')->on('pesertas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftarans');
    }
};
