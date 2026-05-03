<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Instansi extends Model
{
    protected $table = 'instansi';
    protected $fillable = [
        'nama',
        'tipe',
        'kelurahan',
        'alamat',
        'status',
        'kontak',
        'email',
        'nomor_sk',
        'masa_berlaku',
        'nama_pimpinan',
        'logo',
        'tanda_tangan',
        'latitude',
        'longitude',
    ];

    protected function casts(): array
    {
        return [
            'masa_berlaku' => 'date',
        ];
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
    public function mustahik(): HasMany
    {
        return $this->hasMany(Mustahik::class);
    }
    public function transaksiZakat(): HasMany
    {
        return $this->hasMany(TransaksiZakat::class);
    }
    public function programPenyaluran(): HasMany
    {
        return $this->hasMany(ProgramPenyaluran::class);
    }

    public function rekening(): HasMany
    {
        return $this->hasMany(RekeningInstansi::class);
    }
}
