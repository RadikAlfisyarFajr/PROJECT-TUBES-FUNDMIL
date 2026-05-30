<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nishab extends Model
{
    protected $table = 'nishab';

    protected $fillable = [
        'jenis_zakat',
        'nishab_kg',
        'nishab_rupiah',
        'tarif_fitrah_kg',
        'tanggal_berlaku',
        'tanggal_berakhir',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'nishab_kg' => 'decimal:2',
            'nishab_rupiah' => 'decimal:2',
            'tarif_fitrah_kg' => 'decimal:2',
            'tanggal_berlaku' => 'date',
            'tanggal_berakhir' => 'date',
        ];
    }
}
