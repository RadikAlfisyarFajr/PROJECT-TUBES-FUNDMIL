<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Program extends Model
{
    protected $fillable = [
        'instansi_id',
        'nama_program',
        'tanggal_mulai',
        'tanggal_selesai',
        'deskripsi',
        'total_dana',
        'target_mustahik',
        'status',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'total_dana' => 'decimal:2',
    ];

    public function instansi(): BelongsTo
    {
        return $this->belongsTo(Instansi::class);
    }

    public function programDana(): HasMany
    {
        return $this->hasMany(ProgramDana::class);
    }

    public function kategoriDana(): HasManyThrough
    {
        return $this->hasManyThrough(
            KategoriDana::class,
            ProgramDana::class,
            'program_id',
            'id',
            'id',
            'kategori_dana_id'
        );
    }
}
