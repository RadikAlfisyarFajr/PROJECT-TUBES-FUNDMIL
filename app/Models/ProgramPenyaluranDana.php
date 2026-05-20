<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProgramPenyaluranDana extends Model
{
    protected $table = 'program_penyaluran_dana';

    protected $fillable = [
        'program_penyaluran_id',
        'kategori_dana_id',
    ];

    public function programPenyaluran(): BelongsTo
    {
        return $this->belongsTo(ProgramPenyaluran::class);
    }

    public function kategoriDana(): BelongsTo
    {
        return $this->belongsTo(KategoriDana::class);
    }
}
