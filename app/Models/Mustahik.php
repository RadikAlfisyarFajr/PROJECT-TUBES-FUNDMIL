<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mustahik extends Model
{
    public const KATEGORI = [
        'fakir' => 'Fakir',
        'miskin' => 'Miskin',
        'amil' => 'Amil',
        'riqab' => 'Riqab',
        'gharim' => 'Gharim',
        'fisabilillah' => 'Fisabilillah',
        'ibnu_sabil' => 'Ibnu Sabil',
    ];

    protected $table = 'mustahik';

    protected $fillable = [
        'instansi_id',
        'nama',
        'nik',
        'no_kk',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'desa_kelurahan',
        'rw',
        'rt',
        'alamat',
        'kategori_asnaf',
        'kontak',
        'keterangan',
        'status',
        'tanggal_verifikasi',
        'foto_ktp',
        'foto_kk',
        'latitude',
        'longitude'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_verifikasi' => 'datetime',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    public function instansi(): BelongsTo
    {
        return $this->belongsTo(Instansi::class);
    }

    public function getNamaLengkapAttribute(): string
    {
        return $this->nama;
    }

    public function getKategoriLabelAttribute(): string
    {
        return self::KATEGORI[$this->kategori_asnaf] ?? str($this->kategori_asnaf)->replace('_', ' ')->title();
    }
}
