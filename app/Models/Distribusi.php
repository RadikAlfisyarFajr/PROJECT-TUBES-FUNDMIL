<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Distribusi extends Model
{
    protected $table = 'distribusi';

    protected $fillable = [
        'program_id',
        'mustahik_id',
        'jumlah_dana',
        'status',
        'tanggal_distribusi',
        'catatan',
    ];

    protected $casts = [
        'jumlah_dana' => 'decimal:2',
        'tanggal_distribusi' => 'date',
    ];

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function mustahik(): BelongsTo
    {
        return $this->belongsTo(Mustahik::class);
    }
}
