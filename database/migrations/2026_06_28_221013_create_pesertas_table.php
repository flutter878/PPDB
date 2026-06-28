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
    Schema::create('pesertas', function (Blueprint $table) {
        $table->id('id_peserta');
        $table->string('nama_lengkap', 150);
        $table->text('alamat');
        $table->string('tempat_lahir', 100);
        $table->date('tanggal_lahir');
        $table->string('no_hp', 20);
        $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
        $table->timestamps();
    });
}       
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesertas');
    }
};
