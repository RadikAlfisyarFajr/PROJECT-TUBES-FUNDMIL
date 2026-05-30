<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HargaBeras extends Model
{
    protected $table = 'harga_beras';

    protected $fillable = [
        'harga_per_kg',
        'tanggal_berlaku',
        'tanggal_berakhir',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'harga_per_kg' => 'decimal:2',
            'tanggal_berlaku' => 'date',
            'tanggal_berakhir' => 'date',
        ];
    }
}
