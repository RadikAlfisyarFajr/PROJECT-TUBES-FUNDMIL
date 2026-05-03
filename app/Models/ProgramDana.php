<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProgramDana extends Model
{
    protected $table = 'program_dana';

    protected $fillable = [
        'program_id',
        'kategori_dana_id',
        'alokasi_dana',
    ];

    protected $casts = [
        'alokasi_dana' => 'decimal:2',
    ];

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function kategoriDana(): BelongsTo
    {
        return $this->belongsTo(KategoriDana::class);
    }
}
