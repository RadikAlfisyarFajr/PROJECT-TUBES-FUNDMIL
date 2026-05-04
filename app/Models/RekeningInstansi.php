<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RekeningInstansi extends Model
{
    protected $table = 'rekening_instansi';

    protected $fillable = [
        'instansi_id',
        'nama_bank',
        'nomor_rekening',
        'nama_pemilik',
    ];

    public function instansi(): BelongsTo
    {
        return $this->belongsTo(Instansi::class);
    }
}
