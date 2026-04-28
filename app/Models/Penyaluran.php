<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Penyaluran extends Model
{
    protected $table = 'penyaluran';

    protected $fillable = [
        'instansi_id',
        'program_id',
        'tanggal_penyaluran',
        'status',
        'keterangan',
        'bukti_foto'
    ];

    public function program_penyaluran(): BelongsTo
    {
        return $this->belongsTo(ProgramPenyaluran::class, 'program_id');
    }

    public function penyaluran_detail(): HasMany
    {
        return $this->hasMany(PenyaluranDetail::class);
    }
}
