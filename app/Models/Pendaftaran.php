<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    protected $primaryKey = 'no_seri_pendaftaran';
    public $incrementing = false; // Karena PK adalah string, bukan auto-increment
    protected $keyType = 'string';
    protected $guarded = [];

    // Relasi kebalikannya
    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'id_peserta', 'id_peserta');
    }
}
