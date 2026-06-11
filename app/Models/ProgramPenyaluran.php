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
        'status',
        'approval_status',
        'approved_by',
        'approved_at',
        'approval_note',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_mulai' => 'date',
            'tanggal_selesai' => 'date',
            'approved_at' => 'datetime',
        ];
    }

    public function instansi(): BelongsTo
    {
        return $this->belongsTo(Instansi::class);
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function penyaluran(): HasMany
    {
        return $this->hasMany(Penyaluran::class, 'program_id');
    }
}
