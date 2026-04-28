<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mustahik extends Model
{
    protected $table = 'mustahik';
    protected $fillable = [
        'instansi_id',
        'nama',
        'nik',
        'alamat',
        'kategori_asnaf',
        'status',
        'tanggal_verifikasi',
        'latitude',
        'longitude'
    ];

    public function instansi(): BelongsTo
    {
        return $this->belongsTo(Instansi::class);
    }
}
