<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriDana extends Model
{
    protected $table = 'kategori_dana';
    protected $fillable = ['instansi_id', 'parent_id', 'nama', 'is_active', 'start_date', 'end_date'];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    public function instansi(): BelongsTo
    {
        return $this->belongsTo(Instansi::class);
    }

    // Relasi untuk Sub-Kategori (Recursive)
    public function parent(): BelongsTo
    {
        return $this->belongsTo(KategoriDana::class, 'parent_id');
    }
    public function children(): HasMany
    {
        return $this->hasMany(KategoriDana::class, 'parent_id');
    }
}
