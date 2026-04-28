<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProgramPenyaluran extends Model
{
    protected $table = 'program_penyaluran';

    protected $fillable = [
        'instansi_id',
        'nama_program',
        'tanggal_mulai',
        'tanggal_selesai',
        'metode_distribusi',
        'target_dana',
        'status'
    ];

    public function instansi(): BelongsTo
    {
        return $this->belongsTo(Instansi::class);
    }

    public function penyaluran(): HasMany
    {
        return $this->hasMany(Penyaluran::class, 'program_id');
    }
}
