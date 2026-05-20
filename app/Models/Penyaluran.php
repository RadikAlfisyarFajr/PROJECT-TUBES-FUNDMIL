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

    protected function casts(): array
    {
        return [
            'tanggal_penyaluran' => 'date',
        ];
    }

    public function instansi(): BelongsTo
    {
        return $this->belongsTo(Instansi::class);
    }

    public function programPenyaluran(): BelongsTo
    {
        return $this->belongsTo(ProgramPenyaluran::class, 'program_id');
    }

    public function program_penyaluran(): BelongsTo
    {
        return $this->programPenyaluran();
    }

    public function penyaluranDetail(): HasMany
    {
        return $this->hasMany(PenyaluranDetail::class);
    }

    public function penyaluran_detail(): HasMany
    {
        return $this->penyaluranDetail();
    }
}
