<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PenyaluranDetail extends Model
{
    protected $table = 'penyaluran_detail';

    protected $fillable = [
        'penyaluran_id',
        'jenis_penerima',
        'mustahik_id',
        'nama_penerima',
        'jumlah_diterima',
        'status_penerimaan',
        'tanggal_diterima',
        'keterangan'
    ];

    protected function casts(): array
    {
        return [
            'jumlah_diterima' => 'decimal:2',
            'tanggal_diterima' => 'datetime',
        ];
    }

    public function penyaluran(): BelongsTo
    {
        return $this->belongsTo(Penyaluran::class);
    }

    public function mustahik(): BelongsTo
    {
        return $this->belongsTo(Mustahik::class);
    }
}
