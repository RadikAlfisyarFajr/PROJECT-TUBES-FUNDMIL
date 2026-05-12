<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PengaturanDistribusi extends Model
{
    protected $table = 'pengaturan_distribusi';

    protected $fillable = [
        'instansi_id',
        'program_penyaluran_id',
        'kode_rencana',
        'tipe_penerima',
        'nominal_per_penerima',
        'jumlah_penerima',
        'total_alokasi',
        'saldo_awal',
        'estimasi_sisa_saldo',
        'sumber_dana',
        'penerima',
        'status',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'nominal_per_penerima' => 'decimal:2',
            'total_alokasi' => 'decimal:2',
            'saldo_awal' => 'decimal:2',
            'estimasi_sisa_saldo' => 'decimal:2',
            'sumber_dana' => 'array',
            'penerima' => 'array',
        ];
    }

    public function instansi(): BelongsTo
    {
        return $this->belongsTo(Instansi::class);
    }

    public function programPenyaluran(): BelongsTo
    {
        return $this->belongsTo(ProgramPenyaluran::class, 'program_penyaluran_id');
    }
}
