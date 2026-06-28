<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    protected $primaryKey = 'id_peserta';
    protected $guarded = []; // Mengizinkan semua kolom diisi

    // Relasi One-to-One ke Pendaftaran
    public function pendaftaran()
    {
        return $this->hasOne(Pendaftaran::class, 'id_peserta', 'id_peserta');
    }
}
